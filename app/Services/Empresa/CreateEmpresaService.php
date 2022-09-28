<?php

namespace App\Services\Empresa;

use App\Models\Carteira;
use App\Models\Contato;
use App\Models\Empresa;
use App\Models\Endereco;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateEmpresaService
{
    public function execute(array $request)
    {
        $data = $request['empresa'];
        $data['status_id'] = 1;

        $contatos = Contato::find($request['contatos']);
        $endereco = Endereco::find($request['endereco_id']);

        $carteira = Carteira::query()->where('setor', 'onboarding')->first();

        $precadastro = $request['precadastro'];
        $precadastro['usuario_id'] = auth('api_usuarios')->id();
        $precadastro['responsavel_onboarding_id'] = $carteira->responsavel->id;

        $socios = $this->mapSocios($request['socios']);

        try {
            DB::beginTransaction();
            $empresa = Empresa::create($data);

            if (array_key_exists('comprovante_residencia_id', $request)) {
                $empresa->addArquivo($request['comprovante_residencia_id'], 'comprovante_residencia');
            }

            if (!empty($request['cartao_cnpj_id'])) {
                $empresa->addArquivo($request['cartao_cnpj_id'], 'cartao_cnpj');
            }

            $empresa->contatos()->saveMany($contatos);
            $empresa->endereco()->save($endereco);
            $empresa->precadastro()->create($precadastro);
            $empresa->socios()->attach($socios);
            $empresa->plans()->sync($request['plan_id']);
            $empresa->carteiras()->sync($carteira->id);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getTraceAsString());
            throw new \Exception($th->getMessage());
        }

        return $empresa;
    }

    private function mapSocios(array $sociosId): Collection
    {
        return collect($sociosId)->mapWithKeys(function ($item, $key) {
            $clienteId = $item['cliente_id'];
            unset($item['cliente_id']);

            return [$clienteId => $item];
        });
    }
}
