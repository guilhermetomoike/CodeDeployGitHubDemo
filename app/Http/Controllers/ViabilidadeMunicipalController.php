<?php

namespace App\Http\Controllers;

use App\Http\Requests\ViabilidadeMunicipalRequest;
use App\Http\Resources\ViabilidadeMunicipalResource;
use App\Models\ViabilidadeMunicipal;
use App\Services\Viabilidade\CreateViabilidadeService;
use App\Services\Viabilidade\UpdateViabilidadeService;
use InvalidArgumentException;

class ViabilidadeMunicipalController extends Controller
{
    public function index()
    {
        $viabilidades = ViabilidadeMunicipal::all();
        return response(ViabilidadeMunicipalResource::collection($viabilidades));
    }

    public function store(ViabilidadeMunicipalRequest $request, CreateViabilidadeService $createViabilidadeService)
    {
        $data = $request->validated();

        try {
            $viabilidade = $createViabilidadeService->execute($data);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }

        return response($viabilidade);
    }

    public function show($id)
    {
        $viabilidade = ViabilidadeMunicipal::where('id', $id)->with(['cidade' => function($query) {
            $query->with('estado');
        }, 'arquivos'])->first();
        return $viabilidade;
    }

    public function update(ViabilidadeMunicipalRequest $request, $id, UpdateViabilidadeService $updateViabilidadeService)
    {
        $data = $request->validated();

        $viabilidade = $updateViabilidadeService->execute($id, $data);

        return response($viabilidade);
    }

    public function destroy($id)
    {
        ViabilidadeMunicipal::find($id)->delete();
        return $this->successResponse();
    }
}
