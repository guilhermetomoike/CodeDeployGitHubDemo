<?php

namespace Modules\Invoice\Http\Controllers;

use Illuminate\Http\JsonResponse;

use AsyncAws\Core\Result;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Invoice\Entities\FaturaMotivoCancelamento;

class FaturaMotivoCancelamentoController
{

    public function index()
    {
        return FaturaMotivoCancelamento::get();
    }

    public function store(Request $request)
    {
        // return $request->all();
        FaturaMotivoCancelamento::create($request->all());
        return response()->json('salvo com sucesso',200);
    }
    
    public function update(Request $request,$id)
    {
        FaturaMotivoCancelamento::where('id',$id)->update($request->all());
        return response()->json('salvo com sucesso',200);
    }

    
    public function destroy($id)
    {
        FaturaMotivoCancelamento::find($id)->delete();
        return response()->json("Deletado com Sucesso", 200);
    }
}
  