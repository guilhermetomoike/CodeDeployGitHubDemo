<?php


namespace App\Repositories;

use App\Models\Cliente;
use App\Models\Qualificacao;

class ClienteRepository
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    private $model;

    public function __construct()
    {
        $this->model = Cliente::query();
    }

    public function search($search)
    {
        $cliente = Cliente::query();

        $numeric = only_numbers($search);
        $numeric_length = strlen($numeric);

        // may be cpf
        if ($numeric && $numeric_length >= 4) {
            return $cliente->where('cpf', 'like', "%$search%")->get();
        }

        // is string and less 5
        if (strlen($search) < 5) {
            return [];
        }

        return $cliente->where('nome_completo', 'like', "%$search%")->get();
    }

    public function updateCliente($id, array $data)
    {
        $cliente = $this->model->find($id);
        $cliente->update($data);

        if (isset($data['ies_id'])) {
            empty($cliente->course()->first()) ?
                $cliente->course()->create(['ies_id' => $data['ies_id']]) :
                $cliente->course()->update(['ies_id' => $data['ies_id']]);
        }

        return $cliente->fresh();
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }
    public function resetSenha(int $id,array $data)
    {
        $cliente = $this->model->find($id);
        $cliente->update($data);
    }
}
