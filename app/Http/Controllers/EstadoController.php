<?php

namespace App\Http\Controllers;

use App\Models\Estado;

class EstadoController extends Controller
{
    public function index()
    {
        $estados = Estado::orderBy('nome')->get();

        return response($estados);
    }

    public function show($id)
    {
        $estado = Estado::with('cidades')->find($id);

        return response($estado);
    }
}
