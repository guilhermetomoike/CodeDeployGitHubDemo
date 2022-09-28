<?php

namespace Modules\Evaluation\Services;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Evaluation\Entities\Evaluation;

class EvaluationService
{
    private Builder $query;

    public function __construct()
    {
        $this->query = Evaluation::query();
    }

    public function getById(int $id): ?Model
    {
        return $this->query->find($id);
    }

    public function register(array $data): Model
    {
        $evaluation = new Evaluation();
        $evaluation->name = $data['name'];
        $evaluation->slug = $data['slug'];
        $evaluation->question = $data['question'];
        $evaluation->min = $data['min'];
        $evaluation->max = $data['max'];

        $evaluation->save();

        return $evaluation;
    }

    public function update(int $id, array $data): ?Model
    {
        $evaluation = $this->getById($id);

        if (!$evaluation) {
            return null;
        }

        return $this->edit($evaluation, $data);
    }

    private function edit(Model $evaluation, array $data): Model
    {
        $evaluation->name = $data['name'];
        $evaluation->slug = $data['slug'];
        $evaluation->question = $data['question'];
        $evaluation->min = $data['min'];
        $evaluation->max = $data['max'];
        $evaluation->save();

        return $evaluation;
    }

    public function getEvaluation(string $slug, $company_id): object
    {
        $evaluation = $this->query->firstWhere('slug', $slug);
        switch ($slug) {
            case 'onboard':
                $evaluation->question = $this->prepareQuestionForOnboarding($evaluation->question, $company_id);
                break;
        }
        return $evaluation;
    }

    public function prepareQuestionForOnboarding(string $question, $company_id)
    {
        $preCadastro = Empresa::find($company_id)->precadastro;
        $user = $preCadastro->usuarioOnboarding;
        return str_replace('{name}', strtok($user->nome_completo, ' '), $question);
    }
}
