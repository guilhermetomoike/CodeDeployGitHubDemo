<?php

namespace App\Http\Controllers;

use App\Models\Qualificacao;
use Illuminate\Http\Request;

class QualificacaoController extends Controller
{
    public function __invoke()
    {
        return Qualificacao::all();
    }
}
