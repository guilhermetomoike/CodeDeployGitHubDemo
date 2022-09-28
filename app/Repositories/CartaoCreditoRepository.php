<?php


namespace App\Repositories;


use App\Models\CartaoCredito;

class CartaoCreditoRepository
{
    /**
     * @var CartaoCredito
     */
    private $Model;

    /**
     * CartaoCreditoRepository constructor.
     */
    public function __construct()
    {
        $this->Model = CartaoCredito::query();
    }

    public function storeToken(array $data)
    {
        return $this->Model->create(
            ['cliente_id' => auth('api_clientes')->id(),] + $data
        );
    }
}
