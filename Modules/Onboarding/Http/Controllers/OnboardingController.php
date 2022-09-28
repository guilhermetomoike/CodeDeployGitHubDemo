<?php

namespace Modules\Onboarding\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Onboarding\Entities\Onboarding;

class OnboardingController extends Controller
{
    public function index(Request $request)
    {
        $onboardings = Onboarding::query();
        $tipo = $request->query('tipo');

        if ($tipo) {
            $tipoId = array_search($tipo, Onboarding::$tipos);

            $onboardings->tipo($tipoId);
        }

        return $onboardings->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'tipo' => 'required|string',
        ]);

        $data = $request->all();
        $tipoId = array_search($data['tipo'], Onboarding::$tipos);
        $data['tipo_id'] = $tipoId;

        return Onboarding::create($data);
    }

    public function update(Request $request, Onboarding $onboarding)
    {
        $request->validate([
            'nome' => 'required|string',
            'tipo' => 'required|string',
        ]);

        $data = $request->all();
        $tipoId = array_search($data['tipo'], Onboarding::$tipos);
        $data['tipo_id'] = $tipoId;

        $onboarding->update($data);

        return $onboarding;
    }

    public function destroy(Onboarding $onboarding)
    {
        $onboarding->items()->delete();
        $onboarding->delete();

        return response()->noContent();
    }
}
