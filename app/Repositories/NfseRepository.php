<?php

namespace App\Repositories;

use App\Models\Nfse\EmpresaServicoNfse;
use App\Models\Nfse\Nfse;
use Illuminate\Database\Eloquent\Collection;

class NfseRepository
{

    public function storeNfseEmitida($data, $response, $jsonSentWithoutNull, $empresa_id)
    {
        $nfse = Nfse::query()->create([
            'empresas_id' => $empresa_id,
            'status' => 'PROCESSANDO',
            'protocol' => $response->protocol,
            'mensagem_retorno' => $response->message,
            'id_tecnospeed' => $response->documents[0]->id,
            'valor_nota' => $jsonSentWithoutNull['servico']['valor']['servico'],
            'prestador' => $jsonSentWithoutNull['prestador']['cpfCnpj'],
            'tomador' => $jsonSentWithoutNull['tomador']['cpfCnpj'],
            'payload' => json_encode($jsonSentWithoutNull),
            'discriminacao' => $jsonSentWithoutNull['servico']['discriminacao'] ?? '',
            'email_envio' => $jsonSentWithoutNull['tomador']['email'],
        ]);

        $this->storeServicoVinculado($data, $empresa_id);

        return $nfse ?? [];
    }

    public function storeServicoVinculado($data, $empresa_id)
    {
        EmpresaServicoNfse::query()->updateOrCreate([
            'empresa_id' => $empresa_id,
            'servico_nfse_id' => $data['servico_id'],
            'tomador_id' => $data['tomador_id'],
        ], [
            'retencao' => $data['retencao'] ?? null,
            'discriminacao' => $data['discriminacao'],
            'aliquota' => $data['aliquota'],
            'valor' => $data['valor'],
            'email_envio' => $data['email_envio'],
            'iss_retido' => $data['iss_retido']
        ]);
    }

    public function findById(int $id)
    {
        return Nfse::query()->findOrFail($id);
    }

    public function saveWebhook($nfse)
    {
        return \App\Models\Nfse\Nfse::query()->updateOrCreate([
            'id_tecnospeed' => $nfse['id']
        ], [
            'empresas_id' => $nfse['empresas_id'],
            'status' => $nfse['situacao'] ?? 'PROCESSANDO',
            'emissao' => $nfse['emissao'] ?? null,
            'valor_nota' => $nfse['valorServico'] ?? null,
            'mensagem_retorno' => $nfse['mensagem'] ?? '',
            'lote' => $nfse['lote'] ?? null,
            'serie' => $nfse['serie'] ?? null,
            'tomador' => $nfse['tomador'] ?? null,
            'prestador' => $nfse['prestador'] ?? null,
            'pdf_externo' => $nfse['pdf'] ?? null,
        ]);
    }

    public function getNfses(array $filter = []): Collection
    {
        $filter['date'] ??= today()->toDateString();

        return Nfse
            ::query()
            ->with('arquivo_nfse')
            ->select([
                'empresas_nfse.id',
                'empresas_nfse.fatura_id',
                'empresas_nfse.id_tecnospeed',
                'empresas_nfse.valor_nota',
                'empresas_nfse.tomador',
                'empresas_nfse.status',
                'empresas_nfse.arquivo',
                'empresas_nfse.emissao',
                'empresas_nfse.mensagem_retorno',
                'empresas_nfse.created_at',
                'empresas.razao_social',
            ])
            ->leftJoin('empresas', 'empresas.cnpj', 'empresas_nfse.tomador')
            ->where('empresas_id', 200)
            ->whereYear('empresas_nfse.created_at', explode('-', $filter['date'])[0])
            ->whereMonth('empresas_nfse.created_at', explode('-', $filter['date'])[1])
            ->get();
    }
}
