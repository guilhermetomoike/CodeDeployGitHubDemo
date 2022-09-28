<?php

namespace App\Http\Controllers;

use App\Events\ContratoAssinado;
use App\_old_Model\PreCadastro\PrecadastrosModel;
use App\Http\Resources\EmpresaWithContratoResource;
use App\Jobs\MakeContratoEmpresaJob;
use App\Models\Contrato;
use App\Models\Empresa;
use App\Services\ContratoService;
use App\Services\ESignService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContratoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'empresa_id' => ['required', 'exists:empresas,id']
        ]);
        $sendEmail = $request->get('sendEmail');
        $empresaId = $request->get('empresa_id');
        $empresa = Empresa::find($empresaId);
        try {
            MakeContratoEmpresaJob::dispatchNow($empresa, $sendEmail);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erro ' . $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return new EmpresaWithContratoResource($empresa);
    }

    public function check($id)
    {
        $contrato = Contrato::query()->firstWhere('empresas_id', $id);
        if (!$contrato) {
            return response()->json([], JsonResponse::HTTP_BAD_REQUEST);
        }
        $document = ContratoService::checkDocument($contrato['extra']['clicksign']['documentos']['contrato_prestacao_servico']);
        return response()->json($document);
    }
}
