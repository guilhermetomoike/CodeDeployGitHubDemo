<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetsRequest;
use App\Repositories\AssetsRepository;
use App\Services\AssetsService;
use Illuminate\Http\Request;

class AssetsController extends Controller
{

    private AssetsRepository $assetsRepository;
    private AssetsService $assetsService;

    public function __construct(AssetsRepository $assetsRepository, AssetsService $assetsService)
    {
        $this->assetsRepository = $assetsRepository;
        $this->assetsService = $assetsService;
    }

    public function store(AssetsRequest $request)
    {
        return $this->assetsService->store($request->all());
    }

    public function show($client_id)
    {
        return $this->assetsRepository->getAssetsByClient($client_id);
    }


    public function update(Request $request, $id)
    {
        return $this->assetsService->update($request->all(), $id);
    }


    public function destroy($id)
    {
        return response($this->assetsService->destroy($id));
    }
}
