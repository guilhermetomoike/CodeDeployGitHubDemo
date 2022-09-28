<?php

namespace Modules\Invoice\Http\Controllers;

use Illuminate\Http\JsonResponse;

use AsyncAws\Core\Result;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Invoice\Entities\TipoCobranca;

class TipoCobrancaController
{

     public function index()
    {
        return TipoCobranca::where('id','>',3)->get();
    }
    public function index2()
    {
        return TipoCobranca::get();
    }

    public function store(Request $request)
    {
        // return $request->all();
        TipoCobranca::create($request->all());
        return response()->json('salvo com sucesso',200);
    }
    
    public function update(Request $request,$id)
    {
        TipoCobranca::where('id',$id)->update($request->all());
        return response()->json('salvo com sucesso',200);
    }

    public function destroy($id)
    {
        TipoCobranca::find($id)->delete();
        return response()->json("Deletado com Sucesso", 200);
    }
}
  