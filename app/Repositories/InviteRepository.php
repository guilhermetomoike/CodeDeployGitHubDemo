<?php

namespace App\Repositories;

use App\Models\Invite;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class InviteRepository
{
    public function create(array $array)
    {
        return Invite::query()->create($array);
    }

    public function getAll($request)
    {

        $from= $request->get('data_inicio');
       $to = $request->get('data_fim');

        return Invite::with([
            'customer' => fn($customer) => $customer
                ->select('id', 'nome_completo', 'cpf')
                ->with('empresa:id')
        ])
        ->whereBetween('created_at', [$from, $to])
        ->get();
    }

    public function delete(int $id)
    {
        return Invite::destroy($id);
    }

    public function getInviteByPloomesDealId(int $id): ?Invite
    {
        return Invite::where('ploomes_deal_id', $id)->first();
    }

    public function getInviteByCustomerId(int $customerId): Collection
    {
        return Invite
            ::query()
            ->where('customer_id', $customerId)
            ->get();
    }

    public function getAllConfirmedInvites()
    {
        return Invite
            ::query()
            ->where('status', 'confirmado')
            ->get();
    }
}
