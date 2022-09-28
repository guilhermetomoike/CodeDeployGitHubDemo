<?php

namespace App\Services\File\Parse;

use App\Models\Guia;
use App\Models\GuiaLiberacao;
use App\Models\GuiasDatasPadrao;
use App\Models\Upload;
use App\Modules\ConvertPDFToText;
use App\Modules\FileParser\Guia\Parser;
use App\Repositories\EmpresaRepository;
use App\Services\File\FileService;
use App\Services\GuiaService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser as PdfParser;


class ParseGuiasService
{
    private $empresaRepository;
    private $guiaService;
    private $fileService;
    private $storageS3;
    private $storageLocal;

    public function __construct(
        EmpresaRepository $empresaRepository,
        GuiaService $guiaService,
        FileService $fileService
    ) {
        $this->empresaRepository = $empresaRepository;
        $this->guiaService = $guiaService;
        $this->fileService = $fileService;
        $this->storageS3 = Storage::disk('s3');
        $this->storageLocal = Storage::disk('local');
    }

    public function parseGuia(Upload $upload)
    {
        try {
            $pdf = $this->storageS3->get($upload->path);
            $this->storageLocal->put($upload->path, $pdf);
            $localPath = storage_path('app/private/') . $upload->path;



            try {
                $cnpj = '';
                $parser = new PdfParser();
                $pdf    = $parser->parseFile($localPath);
                $text =  $this->sanitizeString($pdf->getText());

                $guiaParser = (new Parser([$text]))->parse();
                // return response()->json($guiaParser, 200);
            } catch (\Exception $exception) {
                $cnpj =  $this->getCnpj($text);
                $pdfTexto = (new ConvertPDFToText($localPath))->run();
                $guiaParser = (new Parser($pdfTexto))->parse();
                if ($cnpj != "") {
                    $guiaParser['cnpj'] = $cnpj;
                }
            }
            if (!isset($guiaParser['cnpj'][0])) {
                $pdfTexto = (new ConvertPDFToText($localPath))->run();
                $guiaParser = (new Parser($pdfTexto))->parse();
            }

            $guiaData = [
                'upload' => $upload,
                'parser' => $guiaParser,
                'empresa' => $this->identifyEmpresaFromGuia($guiaParser),
            ];
            $this->createGuia($guiaData);
        } catch (\Exception $exception) {
            Log::error('ParseGuiasService: ' . $exception->getMessage());
            $this->fileService->errorOnUpload($upload, $exception->getMessage());
        } finally {
            $this->storageLocal->delete($upload->path);
        }
    }

    private function identifyEmpresaFromGuia(array $guia)
    {
        foreach ($guia['cnpj'] as $cnpj) {
            str_replace(['8', '3'], ['%'], $cnpj);
            $foundEmpresa = $this->empresaRepository->getEmpresaByCnpj($cnpj);
            if ($foundEmpresa) {
                return $foundEmpresa;
            }
        }
        throw new \Exception('Não encontrada empresa que corresponde a esta guia: ' . json_encode($guia));
    }

    private function createGuia(array $guiaData)
    {
        $upload = $guiaData['upload'];
        $parser = $guiaData['parser'];
        $empresa = $guiaData['empresa'];
        $diaVencimento = $this->resolveDiaVencimento($guiaData);

        $data = [
            'data_upload' => now(),
            'data_vencimento' => $diaVencimento,
            'nome_guia' => $upload->path,
            'valor' => $parser['valor'],
            'barcode' => $parser['barcode'],
            'usuarios_id' => $upload->usuario_id,
        ];
        $gdps = GuiasDatasPadrao::get();
            $senaopadrao =false;
        foreach( $gdps as $gdp ){
            if($gdp->tipo == $parser['tipo'] ){
            if($gdp->data_vencimento != $data['data_vencimento'] ){
                $senaopadrao == 1;
            }
            }
        }
        $guia = Guia::query()->updateOrCreate([
            'empresas_id' => $empresa->id,
            'data_competencia' => $upload->data_competencia,
            'tipo' => $parser['tipo'],
            'padrao_data_vencimento' => $senaopadrao
        ], $data);
        $guia
            ->arquivo()
            ->create(['nome_original' => $upload->name, 'caminho' => $upload->path]);

        $upload->delete();
    }

    private function resolveDiaVencimento(array $guiaData): string
    {
        $tipo = $guiaData['parser']['tipo'];
        return $this->guiaService->getDataPadraoByTipo($tipo)->data_vencimento;
    }
    function sanitizeString($str)
    {

        $str = preg_replace('/[]/', ' ', $str);
        $str = preg_replace('/(\v|\s)+/', ' ', $str);
        $str = str_replace("\\t", ' ', $str);
        $str = str_replace(" / ", ' ', $str);


        return $str;
    }


    protected function getCnpj(string $text)
    {
        preg_match_all('/\b ?\d{1} ?\d{1}\. ?\d{1} ?\d{1} ?\d{1}\. ?\d{1} ?\d{1} ?\d{1} ?\/\d{4}\-\d{2}\b|\b\d{2,3}\.\d{3}\. \d{3}\/\d{4}\-\d{2}\b/m', $text, $matches);
        return collect($matches)
            ->flatten()
            ->unique()
            ->map(function ($cnpj) {
                return formata_cnpj_bd(str_replace(" ", "", $cnpj));
            });
    }
}
