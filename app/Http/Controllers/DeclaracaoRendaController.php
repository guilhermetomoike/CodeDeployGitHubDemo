<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeclaracaoRendaController extends Controller
{
    public function store(Request $request)
    {
        $empresaId = $request->get('empresa_id');
        $email     = $request->get('email');

        if (!$this->onlyCliente()->empresa->pluck('id')->contains($empresaId)) {
            $this->ClienteSemAcesso();
        }

        $mediaFaturamento = $this->getValor($empresaId);

        // NECESSARIO COLOCAR ENIVO DE EMAIL

        return response(null, Response::HTTP_OK);
    }

    public function valorEmpresa(int $idEmpresa)
    {
        return response()->json($this->getValor($idEmpresa));
    }

    private function getValor(int $empresaId): string
    {
        $faturamentos = Empresa::findOrFail($empresaId)->getUltimosFaturamentos();

        if($faturamentos->count() === 0) {
            return response(json_encode('Empresa sem faturamentos'), Response::HTTP_METHOD_NOT_ALLOWED);
        }

        return number_format($faturamentos->take(3)->pluck('faturamento')->sum()*0.8, 2, ',', '.');
    }
}
