<?php

namespace Modules\Onboarding\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Onboarding\Entities\EmpresaPosCadastroOnboarding;
use Modules\Onboarding\Entities\Onboarding;

class EmpresaPosCadastroOnboardingController extends Controller
{
    public function index(Empresa $empresa)
    {
        return $empresa->poscadastro_onboardings;
    }

    public function store(Request $request, Empresa $empresa)
    {
        $data = $request->validate([
            'onboarding_id' => 'required|numeric|exists:onboardings,id',
        ]);

        $onboarding = Onboarding::find($data['onboarding_id']);
        $items = $onboarding->items->map(function ($item) {
            return [
                'nome' => $item->nome,
                'completo' => false,
            ];
        });

        return $empresa->poscadastro_onboardings()->createMany($items);
    }

    public function update(Request $request, EmpresaPosCadastroOnboarding $empresaPosCadastroOnboarding)
    {
        $data = $request->validate([
            'completo' => 'boolean',
        ]);

        $empresaPosCadastroOnboarding->update($data);

        return $empresaPosCadastroOnboarding;
    }

    public function destroy(Empresa $empresa)
    {
        $empresa->poscadastro_onboardings()->delete();

        return response()->noContent();
    }
}
