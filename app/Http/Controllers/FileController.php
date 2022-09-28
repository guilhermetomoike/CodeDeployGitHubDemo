<?php

namespace App\Http\Controllers;

use App\Models\EmpresaArquivo;
use App\Services\FileService;
use Illuminate\Http\Request;

class FileController extends Controller
{
    private $service;

    public function __construct(FileService $fileService)
    {
        $this->service = $fileService;
    }

    // DIRETORY
    public function index(Request $request)
    {
        $directory = $request->get('directory');

        return response($this->service->getDirectories($directory), 200);
    }

    public function show($empresa_id)
    {
        $arquivosEmpresa = EmpresaArquivo::whereEmpresa_id($empresa_id)->get();

        return response(['data' => $arquivosEmpresa], 200);
    }

    public function deleteDiretory(Request $request)
    {
        $directory = $request->get('diretory');

        $this->service->deleteDiretory($directory);

        return response('', 204);
    }

    public function createDiretory(Request $request)
    {
        $directory = $request->get('diretory');
        $nome      = $request->get('nome');

        $this->service->createDiretory($directory, $nome);

        return response('', 201);
    }

    // FILE
    public function download($file_id)
    {
        $empresaArquivo = EmpresaArquivo::find($file_id);

        $file = $this->service->getFile($empresaArquivo);

        return response()->file($file);
    }

    public function deleteFile(Request $request)
    {
        $fileCaminho = $request->get('file');

        if (!$this->service->deleteFile($fileCaminho)) {
            return $this->badRequest('Arquivo não existe');
        }

        return response('', 204);
    }

    public function updateFile(Request $request)
    {
        $file         = $request->file('file');
        $directory    = $request->get('directory');
        $nomeOrigianl = $file->getClientOriginalName();

        if (!$this->service->saveFile($directory, $file, $nomeOrigianl)) {
            return $this->badRequest('Não foi possível salvar o arquivo');
        }

        return response('', 201);
    }
}
