<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientAccessRequest;
use App\Http\Resources\ClientAccessResource;
use App\Services\Cliente\AccessService;

class AccessController extends Controller
{
    private AccessService $accessService;

    public function __construct(AccessService $accessService)
    {
        $this->accessService = $accessService;
    }

    public function index(int $client_id)
    {
        $access = $this->accessService->getAccessByClientId($client_id);
        return ClientAccessResource::collection($access);
    }

    public function store(ClientAccessRequest $request, int $client_id)
    {
        $data = $request->all();
        $access = $this->accessService->store($data, $client_id);
        return new ClientAccessResource($access);
    }

    public function update(ClientAccessRequest $request, int $cliente_id, int $id)
    {
        $data = $request->all();
        $access = $this->accessService->update($data, $id);
        return new ClientAccessResource($access);
    }
}
