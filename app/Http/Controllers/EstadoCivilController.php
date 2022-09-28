<?php

namespace App\Http\Controllers;

use App\Models\EstadoCivil;
use Illuminate\Http\Request;

class EstadoCivilController extends Controller
{
    public function __invoke()
    {
        return EstadoCivil::all();
    }
}
