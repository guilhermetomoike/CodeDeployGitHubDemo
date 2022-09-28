<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArquivoStoreRequest;
use App\Http\Requests\SendFilesByEmailRequest;
use App\Models\Arquivo;
use App\Models\Upload;
use App\Modules\ConvertBase64ToFile;
use App\Services\ArquivoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use thiagoalessio\TesseractOCR\Command;

class ArquivoController extends Controller
{
    private ArquivoService $arquivoService;

    public function __construct(ArquivoService $arquivoService)
    {
        $this->arquivoService = $arquivoService;
    }

    public function index(Request $request)
    {
        $arquivos = $this->arquivoService->getAll($request->all());

        return $this->successResponse($arquivos);
    }

    public function store(ArquivoStoreRequest $request)
    {
        $data = $request->validated();
        $arquivo = $this->arquivoService->create($data);
        return response($arquivo);
    }

    public function update(Request $request, Arquivo $arquivo)
    {
        $nome = $request->nome;
        if (!$nome) return new JsonResponse([]);
        $arquivo->nome = $nome;
        $arquivo->save();
        return new JsonResponse($arquivo);
    }

    public function destroy(Arquivo $arquivo)
    {
        try {
            $arquivo->delete();
            return $this->successResponse();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function sendFilesByEmail(SendFilesByEmailRequest $request)
    {
        $files = $request->get('arquivos');
        $email = $request->get('email');
        $this->arquivoService->sendFilesByEmail($files, $email);
        return $this->successResponse();
    }

    public function uploadFormData(Request $request)
    {
        $data = $this->validate($request, [
            'label' => ['string', 'required'],
            'files' => ['array', 'min:1'],
        ]);
        $files = $this->arquivoService->createToUploadList($data);
        return new JsonResponse($files);
    }
}
