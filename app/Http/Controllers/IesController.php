<?php

namespace App\Http\Controllers;

use App\Models\Ies;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class IesController extends Controller
{
    public function index()
    {
        return Ies::all();
    }

    public function store(Request $request)
    {
        $insert = DB::table('ies')->insertGetId(
            ['nome' => $request->nome, 'cidade' => $request->cidade]
        );

        if (!$insert) {
            return response('eita, não deu pra cadastrar.<br> Avisa a Mari!', 400);
        }

        return response(['message' => 'Cadastrado com sucesso!', 'id' => $insert], 201);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
