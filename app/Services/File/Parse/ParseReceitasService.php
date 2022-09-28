<?php

namespace App\Services\File\Parse;

use App\Exceptions\CreateReceitaException;
use App\Models\Receita;
use App\Models\Upload;
use App\Modules\ConvertPDFToText;
use App\Modules\FileParser\Receita\Parser;
use App\Repositories\EmpresaRepository;
use App\Services\File\FileService;
use App\Services\ReceitaService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ParseReceitasService
{
    private $empresaRepository;
    private $fileService;
    private $receitaService;
    private $storageS3;
    private $storageLocal;

    public function __construct(
        EmpresaRepository $empresaRepository,
        FileService $fileService,
        ReceitaService $receitaService
    )
    {
        $this->empresaRepository = $empresaRepository;
        $this->fileService = $fileService;
        $this->receitaService = $receitaService;
        $this->storageS3 = Storage::disk('s3');
        $this->storageLocal = Storage::disk('local');
    }

    public function parse(Upload $upload)
    {
        try {
            $pdf = $this->storageS3->get($upload->path);
            $this->storageLocal->put($upload->path, $pdf);
            $localPath = storage_path('app/private/') . $upload->path;

            $fileContent = (new ConvertPDFToText($localPath))->run();
            $parser = (new Parser($fileContent))->parse();
            $this->validateParser($parser, $upload);

            $data = [
                'upload' => $upload,
                'parser' => $parser,
                'empresa' => $this->identifyEmpresaFromFile($parser),
            ];
            $this->createReceita($data);
        } catch (\Exception $exception) {
            Log::channel('stack')->error('ParseReceitasService: ' . $exception->getMessage());
            $this->fileService->errorOnUpload($upload, $exception->getMessage());
        } finally {
            $this->storageLocal->delete($upload->path);
        }
    }

    private function identifyEmpresaFromFile(array $parser)
    {
        $empresa = $this->empresaRepository->getEmpresaByCnpj($parser['cnpj']);
        if (!$empresa) {
            throw new \Exception('Não encontrada empresa que corresponde a esta receita: ' . json_encode($parser));
        }
        return $empresa;
    }

    private function validateParser(array $parser, Upload $upload)
    {
        $errors = [];
        $competencia = Carbon::createFromFormat('Y-m-d', $upload->data_competencia)->format('m-Y');
        if (empty($parser['cnpj'])) {
            array_push($errors, 'Não foi possível identificar o CNPJ.');
        }
        if (empty($parser['pa'])) {
            array_push($errors, 'Não foi possível identificar o Período de Apuração.');
        }
        if ($parser['pa'] !== $competencia) {
            array_push($errors, 'Período de Apuração e Data de Competência informada não são a mesma.');
        }
        if (empty($parser['cpp'])) {
            array_push($errors, 'Não foi possível identificar o valor de INSS/CPP.');
        }
        if (empty($parser['fatorR'])) {
            array_push($errors, 'Não foi possível identificar o valor de Fator R.');
        }
        if (empty($parser['rpa'])) {
            array_push($errors, 'Não foi possível identificar o valor da Receita Bruta.');
        }
        if (!empty($errors)) {
            throw new \Exception('Erros durante o parser: ' . json_encode($errors));
        }
    }

    private function totalProlabore(array $parser, Collection $socios)
    {
        $prolaboreFixo = $socios
            ->filter(function ($cliente) {
                return $cliente->prolabore_fixo;
            })
            ->map(function ($cliente) {
                return $cliente->valor_prolabore_fixo;
            })
            ->reduce(function ($accumulator, $current) {
                return $accumulator + $current;
            }, 0);
        $totalProlabore = $this->receitaService->calcProlabore($parser) - $prolaboreFixo;
        return intval($totalProlabore);
    }

    private function createReceita(array $data)
    {
        try {
            $empresa = $data['empresa'];
            $parser = $data['parser'];
            $upload = $data['upload'];
            $socios = $empresa->socios()->select('*')->get();
            $totalProlabore = $this->totalProlabore($parser, $socios);

            foreach ($socios as $cliente) {

                if ($cliente->prolabore_fixo) {
                    $prolabore = $cliente->valor_prolabore_fixo;
                } else {
                    $prolaboreDividido = $totalProlabore * ($cliente->percentual_prolabore / 100);
                    $prolabore = $this->receitaService->roundProlaboreVariavel($prolaboreDividido, $parser['fatorR']);
                }

                $data = [
                    'cnpj' => $parser['cnpj'],
                    'inss' => $parser['cpp'],
                    'fator_r' => $parser['fatorR'],
                    'prolabore' => $prolabore,
                ];
                $receita = Receita::updateOrCreate([
                    'empresa_id' => $empresa->id,
                    'cliente_id' => $cliente->id,
                    'data_competencia' => $upload->data_competencia,
                ], $data);
                $receita
                    ->arquivo()
                    ->create(['nome_original' => $upload->name, 'caminho' => $upload->path]);
            }

            $upload->delete();
        } catch (\Exception $exception) {
            throw new CreateReceitaException($exception->getMessage());
        }
    }
}
