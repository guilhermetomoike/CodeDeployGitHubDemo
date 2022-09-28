<?php

namespace Modules\Evaluation\Services;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Model;
use Modules\Evaluation\Entities\Evaluation;
use Modules\Evaluation\Entities\EvaluationEntity;

class EvaluationEntityService
{
    public function register(array $data): Model
    {
        $evaluate = new EvaluationEntity();
        $evaluate->answer = $data['answer'] ?? null;
        $evaluate->evaluable_type = $data['evaluable_type'];
        $evaluate->evaluable_id = $data['evaluable_id'];
        $evaluate->evaluation_id = $data['evaluation_id'];
        $evaluate->customer_id = $data['customer_id'];
        $evaluate->observation = $data['observation'] ?? null;
        $evaluate->user_id = $this->validateSlug($data);

        $evaluate->save();

        return $evaluate;
    }

    public function getEvaluationsByEntity($evaluation_id, $evaluable_type, $evaluable_id)
    {
        return EvaluationEntity::evaluation($evaluation_id, $evaluable_type, $evaluable_id)->first();
    }

    private function validateSlug(array $data)
    {
        $evaluation = Evaluation::query()->find($data['evaluation_id']);
        $empresa = Empresa::find($data['evaluable_id']);

        $user = null;
        switch ($evaluation->slug) {
            case 'onboard':
                $user = $empresa->precadastro->usuarioOnboarding ?? null;
                if (!$user) throw new \Exception('Não está na fase de onboarding.');
                break;
            case 'sale':
                $user = $empresa->precadastro->usuario ?? null;
                if (!$user) throw new \Exception('Não está vinculado a um consultor.');
                break;
        }

        return $user->id ?? 0;
    }
}
