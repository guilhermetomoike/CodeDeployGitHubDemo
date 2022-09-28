<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarteiraRequest;
use App\Services\CarteiraService;
use Illuminate\Http\Request;

class CarteiraController extends Controller
{
    private $carteiraService;

    public function __construct(CarteiraService $carteiraService)
    {
        $this->carteiraService = $carteiraService;
    }

    public function index(Request $request)
    {
        $searchNome = $request->get('nome', null);
        $carteiras = $this->carteiraService->getAllCarteiras();
        if ($searchNome) {
            $carteiras = $this->carteiraService->searchCarteirasByName($searchNome);
        }
        return response()->json(['data' => $carteiras], 200);
    }

    public function store(CarteiraRequest $request)
    {
        try {
            $this->carteiraService->createCarteira($request->all());
            return response()->json(['message' => 'Carteira criada com sucesso.'], 201);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Erro ao criar Carteira.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $carteira = $this->carteiraService->getCarteiraById($id);
            return response()->json(['data' => $carteira], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Carteira não encontrada.'], 404);
        }
    }

    public function update(CarteiraRequest $request, $id)
    {
        try {
            $this->carteiraService->editCarteira($request->all(), $id);
            return response()->json(['message' => 'Carteira alterada com sucesso.'], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Erro ao alterar Carteira.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->carteiraService->deleteCarteira($id);
            return response()->json([], 204);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Não foi possível excluir essa Carteira.'], 500);
        }
    }

    public function getBySetor(string $setor)
    {
        return response()->json($this->carteiraService->getCarteiraByType($setor));
    }
    public function getByLikeSetor(string $setor)
    {
        return response()->json($this->carteiraService->getCarteiraLike($setor));
    }
}
