<?php


namespace App\Services\Cliente;


use App\Models\Cliente;

class AccessService
{
    public function getAccessByClientId(int $client_id)
    {
        $client = Cliente::find($client_id);

        return $client->access()->get();
    }

    public function store(array $data, int $client_id)
    {
        $client = Cliente::find($client_id);

        $client
            ->access()
            ->create([
                'login' => $data['login'],
                'url' => $data['url'],
                'password' => $data['password'],
                'type' => $data['type']
            ]);

        return $client;
    }

    public function update(array $data, int $id)
    {
        $access = Cliente\ClientAccess::find($id);

        $access->fill($data)->save();

        return $access;
    }
}
