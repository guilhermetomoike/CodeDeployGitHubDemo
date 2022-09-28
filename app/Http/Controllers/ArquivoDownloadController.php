<?php

namespace App\Http\Controllers;

use App\Models\Arquivo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ArquivoDownloadController extends Controller
{
    public function __invoke(Request $request, Arquivo $arquivo)
    {
        $fileName = $arquivo->nome ?? $arquivo->nome_original;
        $extension = pathinfo($arquivo->caminho, PATHINFO_EXTENSION);
        return Storage::disk('s3')
            ->download($arquivo->caminho, $fileName . '.' . $extension);
    }
}
