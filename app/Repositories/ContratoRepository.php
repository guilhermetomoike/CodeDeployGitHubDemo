<?php

namespace App\Repositories;

use App\Models\Contrato;

class ContratoRepository
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    private $model;

    public function __construct()
    {
        $this->model = Contrato::query();
    }

    public function findByDocumentKey(string $documentKey): Contrato
    {
        return $this->model->where('extra', 'like', "%{$documentKey}%")->first();
    }
}
