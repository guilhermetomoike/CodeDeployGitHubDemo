<?php

namespace App\Services\Empresa;

use App\Models\Empresa;
use Illuminate\Support\Facades\Validator;
use Modules\Plans\Entities\PlanSubscription;

class CongelarEmpresaService
{
    public function execute(array $data)
    {
        $this->validate($data);
        $hasCongelamento = isset($data['congelada']) && $data['congelada'] && $data['freeze_date'];
        $empresa = Empresa::query()->find($data['empresa_id']);


        
        if (!$hasCongelamento) {

            $planssubscription =     PlanSubscription::where('payer_id', $empresa->id)->where('payer_type', 'empresa')->first();
            if(isset($planssubscription->id)){
                $planssubscription->plan_id = 10;
                $planssubscription->save();
            }else{
             PlanSubscription::create(['plan_id'=>10,'payer_id' => $empresa->id,'payer_type'=>'empresa']);
        
            }
            $empresa->status_id = array_search('Congelamento Agendado', Empresa::$status);
            $empresa->save();

            $empresa->motivoCongelamento()->create([
                'usuarios_id' => auth('api_usuarios')->id(),
                'data_competencia' => $data['data_competencia'],
                'motivo_congelamento' => $data['motivo_congelamento'],
                'previsao_retorno' => $data['previsao_retorno'],
                'freeze_date' => $data['freeze_date'],
                'data_congelamento' => today(),
            ]);

            /** @var $empresa Empresa */
            $empresa->carteiras()->where('setor', 'contabilidade')->detach();
            $empresa->carteiras()->attach(7);


         
      
        } else {
            $empresa->congelada = false;
            $empresa->status_id = array_search('Ativa', Empresa::$status);
            $empresa->save();
        }

        return $empresa;
    }

    private function validate(array $data)
    {
        $validation = Validator::make($data, [
            'data_competencia' => ['required', 'date'],
            'empresa_id' => 'required',
            'motivo_congelamento' => 'required_if:congelada,0',
            'previsao_retorno' => ['required_if:congelada,0', 'date'],
            'freeze_date' => ['required_if:congelada,0', 'date']
        ]);

        if ($validation->fails()) {
            throw new \Exception($validation->errors()->first(), 422);
        }
    }
}
