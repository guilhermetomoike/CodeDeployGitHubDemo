<?php

namespace App\Http\Controllers;

use App\Http\Requests\JuntaComercialStoreRequest;
use App\Http\Requests\JuntaComercialUpdateRequest;
use App\Http\Resources\JuntaComercial as JuntaComercialResource;
use App\Http\Resources\JuntaComercialCollection;
use App\Models\JuntaComercial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JuntaComercialController extends Controller
{
    public function index(Request $request)
    {
        $juntaComercials = JuntaComercial::all();
        if (!$juntaComercials) return new JsonResponse();
        return new JuntaComercialCollection($juntaComercials);
    }

    public function store(JuntaComercialStoreRequest $request)
    {
        $juntaComercial = JuntaComercial::create($request->all());
        return new JuntaComercialResource($juntaComercial);
    }

    public function show(Request $request, JuntaComercial $juntaComercial)
    {
        if (!$juntaComercial) return new JsonResponse();
        return new JuntaComercialResource($juntaComercial);
    }

    public function update(JuntaComercialUpdateRequest $request, JuntaComercial $juntaComercial)
    {
        $juntaComercial->update($request->all());

        return new JuntaComercialResource($juntaComercial);
    }

    public function destroy(Request $request, JuntaComercial $juntaComercial)
    {
        $juntaComercial->delete();

        return response()->noContent(200);
    }
}
