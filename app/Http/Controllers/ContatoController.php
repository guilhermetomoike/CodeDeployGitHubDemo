<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmContactsRequest;
use App\Http\Requests\ContatoStoreRequest;
use App\Http\Requests\ContatoUpdateRequest;
use App\Models\Contato;
use App\Services\AppSettingsService;
use App\Services\ContatoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContatoController extends Controller
{
    private ContatoService $contatoService;
    private AppSettingsService $appSettingsService;

    public function __construct(ContatoService $contatoService, AppSettingsService $appSettingsService)
    {
        $this->contatoService = $contatoService;
        $this->appSettingsService = $appSettingsService;
    }

    public function index($contactable_type, $contactable_id)
    {
        $data = $this->contatoService->getAllByMorph($contactable_type, $contactable_id);
        return new JsonResponse($data);
    }

    public function store(ContatoStoreRequest $request)
    {
        $data = $this->contatoService->create($request->validated());
        return new JsonResponse($data);
    }

    public function update(ContatoUpdateRequest $request, int $id)
    {
        $data = $this->contatoService->update($id, $request->validated());
        return new JsonResponse($data);
    }

    public function destroy(int $id)
    {
        $deleted = $this->contatoService->delete($id);
        if (!$deleted) {
            return new JsonResponse(['message' => 'Não foi possível realizar a operação!'], 400);
        }
        return new JsonResponse(['message' => 'Operação realizada com sucesso!']);
    }

    public function confirm(ConfirmContactsRequest $request, string $contactable_type, int $contactable_id)
    {
        $data = $request->validated();
        $result = $this->contatoService->confirm($contactable_type, $contactable_id, $data);
        if (!$result) {
            return new JsonResponse(['message' => 'Não foi possível realizar a operação!'], 400);
        }
        $this->appSettingsService->createOrUpdatedAccess($contactable_type, $contactable_id,'contact', 'contato');
        return new JsonResponse(['message' => 'Operação realizada com sucesso!']);
    }
}
