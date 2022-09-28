<?php

namespace App\Http\Controllers;

use App\Models\DocumentosViabilidadeBase;

class DocumentosViabilidadeBaseController extends Controller
{
    public function __invoke()
    {
        return response()->json(DocumentosViabilidadeBase::all());
    }
}
