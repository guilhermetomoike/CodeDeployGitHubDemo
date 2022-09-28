<?php

namespace App\Http\Controllers;

use App\Http\Requests\CertidaoNegativaRequest;
use App\Http\Requests\UploadCertidaoNegativaRequest;
use App\Http\Resources\CertidoesNegativasNaoProcessadasResource;
use App\Http\Resources\CertidoesNegativasResource;
use App\Jobs\ParseCertidaoNegativaJob;
use App\Services\CertidaoNegativaService;
use App\Services\File\FileService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CertidaoNegativaController extends Controller
{
    private $fileService;
    private $certidaoNegativaService;

    public function __construct(FileService $fileService, CertidaoNegativaService $certidaoNegativaService)
    {
        $this->fileService = $fileService;
        $this->certidaoNegativaService = $certidaoNegativaService;
    }

    public function index()
    {
        $data = $this->certidaoNegativaService->getAll();
        return CertidoesNegativasResource::collection($data);
    }

    public function store(CertidaoNegativaRequest $request)
    {
        try {
            $this->certidaoNegativaService->create($request->all());
            return response(['message' => 'Certidão Negativa de Débito criada com sucesso.'], 200);
        } catch (ModelNotFoundException $exception) {
            return response(['message' => 'Empresa informada não existe.'], 422);
        } catch (\Exception $exception) {
            return response(['message' => $exception->getMessage()], 422);
        }
    }

    public function upload(UploadCertidaoNegativaRequest $request)
    {
        $certidoes = $request->get('certidoes');
        foreach ($certidoes as $certidao) {
            $file = $this->fileService->uploadFile($certidao, 'certidao-negativa');
            ParseCertidaoNegativaJob::dispatch($file);
        }
        return response(['message' => 'Arquivos enviados com sucesso.'], 200);
    }

    public function naoProcessadas()
    {
        $certidoes = $this->fileService->getUploadFilesWithError('certidao-negativa');
        return CertidoesNegativasNaoProcessadasResource::collection($certidoes);
    }

    public function deleteNaoProcessada(int $id)
    {
        $this->fileService->deleteUploadFileWithError($id);
        return response([], 204);
    }

    public function getCertidoesByEmpresa(int $id)
    {
        $data = $this->certidaoNegativaService->getCertidoesByEmpresa($id);
        return CertidoesNegativasResource::collection($data);
    }
}
