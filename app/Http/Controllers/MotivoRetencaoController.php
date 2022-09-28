<?php

namespace App\Http\Controllers;

use App\Models\MotivoRetencao;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class MotivoRetencaoController extends Controller
{
    public function index()
    {
        return response()->json(MotivoRetencao::get(),200);
    }
    public function store(Request $request)
    {
        $data = $request->all();
      $conteudo =  MotivoRetencao::create($data);
        
        return response()->json(['msg'=>'Motivo retenção criada com sucesso', 'conteudo'=>$conteudo],200);

    }
    
    public function update(Request $request,$id){

      
        $data = $request->all();
        $conteudo =   MotivoRetencao::findOrFail($id)->update($data);

    
        return response()->json(['msg'=>'Motivo retenção atualizado com sucesso', 'conteudo'=>$conteudo],200);

    }

    public function destroy($id)
    {
        MotivoRetencao::findOrFail($id)->delete();
        return response()->json(['msg'=>'Motivo retenção deletado com sucesso'],200);
        

    }

 
}
