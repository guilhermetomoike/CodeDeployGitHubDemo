<?php

namespace Modules\Plans\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Plans\Http\Requests\ServiceTableRequest;
use Modules\Plans\Repositories\ServiceTableRepository;

class ServiceTableController
{
    private ServiceTableRepository $repository;

    public function __construct(ServiceTableRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $serviceTables = $this->repository->all();
        return response()->json($serviceTables);
    }

    public function store(ServiceTableRequest $request)
    {
        $data = $request->validated();
        $serviceTable = $this->repository->create($data);
        return response()->json($serviceTable, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $serviceTable = $this->repository->findById($id);
        return response()->json($serviceTable);
    }

    public function update(ServiceTableRequest $request, $id)
    {
        $data = $request->validated();
        $serviceTable = $this->repository->update($id, $data);
        return response()->json([
            'message' => 'Operação realizada com sucesso.',
            'data' => $serviceTable
        ]);
    }

    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Operação não pode ser realizada. ' . $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['message' => 'Operação realizada com sucesso.']);
    }
}
