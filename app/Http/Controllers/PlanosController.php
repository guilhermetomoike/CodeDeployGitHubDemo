<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlanoResource;
use App\Models\Planos;
use Illuminate\Support\Facades\Request;

class PlanosController extends Controller
{
    public function index(Request $request)
    {
        return PlanoResource::collection(Planos::all());
    }
}
