<?php

namespace App\Http\Controllers;

use App\Models\JuntaComercial;
use App\Http\Resources\JuntaComercial as JuntaComercialResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JuntaComercialByUfController extends Controller
{
    public function __invoke($uf)
    {
        $juntaComercial = JuntaComercial::whereHas('estado', function (Builder $query) use ($uf) {
            $query->where('uf', 'like', $uf);
        })->first();
        if (!$juntaComercial) return new JsonResponse([], JsonResponse::HTTP_NO_CONTENT);
        return new JuntaComercialResource($juntaComercial);
    }
}
