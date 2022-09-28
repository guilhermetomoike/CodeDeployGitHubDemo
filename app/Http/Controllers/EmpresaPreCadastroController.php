<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpresaPreCadastroStoreRequest;
use App\Http\Requests\EmpresaPreCadastroUpdateRequest;
use App\Jobs\RegisterFromWebhookJob;
use App\Models\Contato;
use App\Models\Contrato;
use App\Models\Empresa;
use App\Models\EmpresaPreCadastro;
use App\Models\Endereco;
use App\Services\ArquivoService;
use App\Services\PloomesIntegration\ApiPloomes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\File\FileService;
use Illuminate\Support\Facades\Storage;

class EmpresaPreCadastroController extends Controller
{
    private $fileService;
    private ArquivoService $arquivoService;

    private $storageS3;
    private $storageLocal;



    public function __construct(FileService $fileService, ArquivoService $arquivoService)
    {
        $this->arquivoService = $arquivoService;

        $this->fileService = $fileService;


        $this->storageS3 = Storage::disk('s3');
        $this->storageLocal = Storage::disk('local');
    }
    public function index()
    {
        $empresaPreCadastros = EmpresaPreCadastro::all();

        return response($empresaPreCadastros);
    }

    public function store(EmpresaPreCadastroStoreRequest $request)
    {
        $data = [
            'usuario_id' => auth('api_usuarios')->id(),
            'status_id' => 1,
        ];
        $data = array_merge($request->validated(), $data);

        $empresaPreCadastro = EmpresaPreCadastro::create($data);

        $empresaPreCadastro->addArquivo($data['comprovante_residencia_id'], 'comprovante_residencia');

        return $empresaPreCadastro;
    }

    public function show(EmpresaPreCadastro $empresaPreCadastro)
    {
        return $empresaPreCadastro;
    }

    public function update(EmpresaPreCadastroUpdateRequest $request, int $empresa_id)
    {
        $data = $request->validated();

        $empresa = Empresa::find($empresa_id);

        if (isset($data['precadastro'])) {
            $empresa->precadastro()->update($data['precadastro']);
        }

        if (isset($data['empresa'])) {
            $data['empresa']['status_id'] = 3;
            $empresa->update($data['empresa']);
        }
        if (isset($data['arquivo_contrato_id'])) {

            $contrato = Contrato::where('empresas_id', $empresa_id)->first();
            // $file = $this->fileService->uploadFile($data['contrato'], 'contrato');
        
            if(!isset($contrato->id)){
                $contrato =    Contato::create(['dia_vencimento'=>20,'empresas_id'=>$empresa_id,'forma_pagamento_id'=>1,'extra'=>[]]);
            }

         
                $this->arquivoService->addClassFile($contrato->id, Contrato::class, $data['arquivo_contrato_id'], 'contrato');
            

            if ($empresa->status_id == 2) {
                $empresa->status_id = 3;
                $empresa->save();
            }
            $contrato->signed_at = now();
            $contrato->save();
        }

        if (isset($data['endereco'])) {
            if (isset($data['endereco']['id'])) {
                Endereco::find($data['endereco']['id'])->update($data['endereco']);
                return;
            }

            $empresa->endereco()->create($data['endereco']);
        }

        if (isset($data['contatos'])) {
            foreach ($data['contatos'] as $contato) {
                if (!empty($contato['id'])) {
                    Contato::find($contato['id'])->update($contato);
                    continue;
                }
                $empresa->contatos()->create($contato);
            }
        }

        if (isset($data['socios'])) {
            $socios = collect($data['socios'])->mapWithKeys(function ($item, $key) {
                $clienteId = $item['cliente_id'];
                unset($item['cliente_id']);
                return [$clienteId => $item];
            });
            $empresa->socios()->sync($socios);
        }

        if (isset($data['plan_id'])) {
            $empresa->plans()->sync($request['plan_id']);
        }

        return new JsonResponse();
    }

    public function destroy(EmpresaPreCadastro $empresaPreCadastro)
    {
        $empresaPreCadastro->delete();

        return response()->noContent();
    }

    public function webhookPloomes(Request $request, ApiPloomes $apiPloomes)
    {
        $data = $request->post();
        RegisterFromWebhookJob::dispatch($data['New']['Id']);
        activity('webhook_ploomes')->log(json_encode($data));
        return new JsonResponse();
    }
}
