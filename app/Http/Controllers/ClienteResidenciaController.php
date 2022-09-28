<?php

namespace App\Http\Controllers;

use App\Models\Cliente\ResidenciaMedica;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteResidenciaController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'data_inicio' => 'required|date',
            'especialidade' => 'required',
            'data_conclusao' => 'required|date',
            'cliente_id' => 'required|exists:clientes,id',
            'empresa_id' => 'required|exists:empresas,id',
            'comprovante_id' => 'required|integer|exists:arquivos,id'
        ]);

        $data['usuario_id'] = auth('api_usuarios')->id();

        $clienteResidencia = ResidenciaMedica::create($data);

        $clienteResidencia->addArquivo(
            $data['comprovante_id'],
            'comprovante',
            [
                'empresa_id' => $data['empresa_id'],
                'cliente_id' => $data['cliente_id'],
                'tipo' => 'comprovante_residencia'
            ]
        );

        $empresa = Empresa::find($data['empresa_id']);
        $empresa->plans()->sync(2);

        return $clienteResidencia;
    }
    public function update($id,Request $request)
    {
        $data = $request->validate([
            'data_inicio' => 'required|date',
            'especialidade' => 'required',
            'data_conclusao' => 'required|date',
            'cliente_id' => 'required|exists:clientes,id',
            'empresa_id' => 'required|exists:empresas,id',
         
   
        ]);

        $data['usuario_id'] = auth('api_usuarios')->id();

        $clienteResidencia = ResidenciaMedica::where('id',$id)->update($data);
        $clienteResidencia =  ResidenciaMedica::where('id',$id)->first();


        if( isset($request['comprovante_id'])){
        $clienteResidencia->addArquivo(
            $request['comprovante_id'],
            'comprovante',
            [
                'empresa_id' => $data['empresa_id'],
                'cliente_id' => $data['cliente_id'],
                'tipo' => 'comprovante_residencia'
            ]
        );
    }

        $empresa = Empresa::find($data['empresa_id']);
        $empresa->plans()->sync(2);

        return $clienteResidencia;
        
    }


    public function especialidades()
    {
        return DB::table('especialidade_medica')->orderBy('nome','asc')->get('*');
    }
}
