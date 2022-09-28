<?php

namespace App\Http\Controllers;

use App\Models\Arquivo;
use finfo;
use Illuminate\Support\Facades\Storage;

class ArquivoOpenController extends Controller
{
    public function __invoke(Arquivo $arquivo)
    {
        $arquivoConteudo = Storage::disk('s3')->get($arquivo->caminho);

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($arquivoConteudo);

        return response($arquivoConteudo, 200, array(
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $arquivo->caminho . '"',
        ));
    }
}
