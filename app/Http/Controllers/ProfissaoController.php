<?php

namespace App\Http\Controllers;

use App\Models\Profissao;
use Illuminate\Http\Request;

class ProfissaoController extends Controller
{
    public function __invoke()
    {
        return Profissao::all();
    }
}
