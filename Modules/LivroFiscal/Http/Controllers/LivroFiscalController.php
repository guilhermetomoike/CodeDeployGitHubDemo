<?php

namespace Modules\LivroFiscal\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LivroFiscal\Services\LivroFiscalService;

class LivroFiscalController
{
    private LivroFiscalService $livroFiscalService;

    public function __construct(LivroFiscalService $livroFiscalService)
    {
        $this->livroFiscalService = $livroFiscalService;
    }

    public function index(Request $request)
    {
        $data = $this->livroFiscalService->getAll($request->status);
        return new JsonResponse($data);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->all();
        try {
            $item = $this->livroFiscalService->update($id, $data);
        } catch (\Exception $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], 400);
        }
        return new JsonResponse($item);
    }

    public function destroy(int $id)
    {
        $deleted = $this->livroFiscalService->delete($id);
        if (!$deleted) {
            return new JsonResponse(['message' => 'Deletado com sucesso.']);
        }
        return new JsonResponse([]);
    }
}
