<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartamentoResource;
use App\Models\Departamento;

class DepartamentoController extends Controller
{
    public function index()
    {
        return DepartamentoResource::collection(Departamento::all());
    }
}
