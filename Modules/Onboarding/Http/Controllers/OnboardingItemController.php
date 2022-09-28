<?php

namespace Modules\Onboarding\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Onboarding\Entities\Onboarding;
use Modules\Onboarding\Entities\OnboardingItem;

class OnboardingItemController extends Controller
{
    public function index(Onboarding $onboarding)
    {
        return $onboarding->items;
    }

    public function store(Request $request, Onboarding $onboarding)
    {
        $data = $request->validate([
            'nome' => 'required|string'
        ]);

        return $onboarding->items()->create($data);
    }

    public function update(Request $request, OnboardingItem $onboardingItem)
    {
        $data = $request->validate([
            'nome' => 'required|string'
        ]);
        $onboardingItem->update($data);

        return $onboardingItem;
    }

    public function destroy(OnboardingItem $onboardingItem)
    {
        $onboardingItem->delete();

        return response()->noContent();
    }
}
