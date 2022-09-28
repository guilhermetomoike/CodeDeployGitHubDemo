<?php

namespace App\Services;

use App\Models\Contato;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;

class ContatoService
{
    public function getAllByMorph($contactable_type, $contactable_id)
    {
        return Contato::contactable($contactable_type, $contactable_id)->get();
    }

    public function create(array $data)
    {
        return Contato::create($data);
    }

    public function update(int $id, array $data)
    {
        $contato = Contato::find($id);
        $contato->fill($data)->save();
        return $contato;
    }

    public function delete(int $id)
    {
        $contato = Contato::find($id);
        return $contato->delete();
    }

    public function confirm(string $model_type, int $model_id, array $data)
    {
        try {
            DB::beginTransaction();
            $model = Relation::getMorphedModel($model_type)::find($model_id);
            $model->contatos()->delete();
            foreach ($data as $contact) {
                $model->contatos()->create($contact);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return false;
        }
        return $model->contatos;
    }

    public function getByValue(string $value)
    {
        return Contato
            ::query()
            ->where('contactable_type', 'empresa')
            ->where('value', $value)
            ->first();
    }

}
