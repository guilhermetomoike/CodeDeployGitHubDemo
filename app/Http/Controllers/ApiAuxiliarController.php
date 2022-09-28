<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultaCnpjApiRequest;
use App\Services\ApiAuxiliar\ApiAuxiliarService;
use Illuminate\Http\Request;

class ApiAuxiliarController extends Controller
{
    //
    /**
     * @var ApiAuxiliarService
     */
    private $Service;

    /**
     * ApiAuxiliarController constructor.
     */
    public function __construct(ApiAuxiliarService $service)
    {
        $this->Service = $service;
    }

    public function consultaCnpj(ConsultaCnpjApiRequest $request)
    {
        $result = $this->Service->consultaCnpj($request->cnpj);

        return response(['data' => $result]);
    }

    public function consultaCep($cep)
    {
        $result = $this->Service->consultaCep($cep);

        return response(['data' => $result]);
    }

    public function consultaHomologacaoNfse($ibge)
    {
        $result = $this->Service->consultaHomologacao($ibge);

        return response($result);
    }
}
