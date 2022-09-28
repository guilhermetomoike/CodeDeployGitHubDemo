<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;

class BancoController extends Controller
{
    public function index()
    { 
        $bancos = Banco::all();
        return response($bancos);
    }

    public function search($search)
    {
        if(is_numeric($search)) {
            $banco = Banco::find($search);
            return response($banco ? [$banco] : []);
        }

        if(strlen($search) < 3) return response([]);

        $banco = Banco::query()
            ->where('nome', 'like', "%{$search}%")
            ->limit(10)
            ->get();

        return response($banco->toArray());
    }
}
