<?php

namespace App\Services;

use App\Models\CertidaoNegativa;
use App\Models\Empresa;
use App\Models\Upload;
use Carbon\Carbon;

class CertidaoNegativaService
{

    public function getAll()
    {
        return CertidaoNegativa
            ::query()
            ->with(['empresa' => fn($empresa) => $empresa->withTrashed(), 'arquivo'])
            ->orderBy('empresa_id')
            ->get();
    }

    public function create(array $data)
    {
        $empresa = ($data['empresa'] instanceof Empresa)
            ? $data['empresa']
            : Empresa::findOrFail($data['empresa']);
        $file = ($data['file'] instanceof Upload)
            ? $data['file']
            : Upload::find($data['file']);

        $certidaoNegativa = new CertidaoNegativa();
        $certidaoNegativa->empresa_id = $empresa->id;
        $certidaoNegativa->tipo = $data['tipo'];
        $certidaoNegativa->data_emissao = Carbon::create($data['data_emissao']);
        $certidaoNegativa->data_validade = Carbon::create($data['data_validade']);
        $certidaoNegativa->save();

        $certidaoNegativa
            ->arquivo()
            ->create(['nome_original' => $file->name, 'caminho' => $file->path]);
    }

    public function getCertidoesByEmpresa(int $id)
    {
        return CertidaoNegativa
            ::query()
            ->with(['empresa', 'arquivo'])
            ->where('empresa_id', $id)
            ->get();
    }
}
