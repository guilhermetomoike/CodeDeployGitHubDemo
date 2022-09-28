<?php

namespace App\Services\File\Parse;

use App\Models\Upload;
use App\Modules\ConvertPDFToText;
use App\Modules\FileParser\CertidaoNegativa\Parser;
use App\Repositories\EmpresaRepository;
use App\Services\CertidaoNegativaService;
use App\Services\File\FileService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ParseCertidaoNegativaService
{
    private $empresaRepository;
    private $fileService;
    private $certidaoNegativaService;
    private $storageS3;
    private $storageLocal;

    public function __construct(
        EmpresaRepository $empresaRepository,
        FileService $fileService,
        CertidaoNegativaService $certidaoNegativaService
    )
    {
        $this->empresaRepository = $empresaRepository;
        $this->fileService = $fileService;
        $this->certidaoNegativaService = $certidaoNegativaService;
        $this->storageS3 = Storage::disk('s3');
        $this->storageLocal = Storage::disk('local');
    }

    public function parseCertidao(Upload $upload)
    {
        try {
            $pdf = $this->storageS3->get($upload->path);
            $this->storageLocal->put($upload->path, $pdf);
            $localPath = storage_path('app/private/') . $upload->path;

            $content = (new ConvertPDFToText($localPath))->run();
            $parser = (new Parser($content))->parse();

            $data = [
                'empresa' => $this->identifyEmpresaFromCnpj($parser['cnpj']),
                'file' => $upload,
                'tipo' => $parser['tipo'],
                'data_emissao' => $parser['data_emissao'],
                'data_validade' => $parser['data_validade'],
            ];
            $this->certidaoNegativaService->create($data);
        } catch (\Exception $exception) {
            Log::error('ParseCertidaoNegativaService: ' . $exception->getMessage());
            $this->fileService->errorOnUpload($upload, $exception->getMessage());
        } finally {
            $this->storageLocal->delete($upload->path);
        }
    }

    private function identifyEmpresaFromCnpj(string $cnpj)
    {
        $foundEmpresa = $this->empresaRepository->getEmpresaByCnpj($cnpj);
        if (!$foundEmpresa) {
            throw new \Exception('Não encontrada empresa que corresponde a este CNPJ: ' . json_encode($cnpj));
        }
        return $foundEmpresa;
    }
}
