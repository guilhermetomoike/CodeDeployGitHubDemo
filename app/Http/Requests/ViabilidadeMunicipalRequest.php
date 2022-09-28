<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ViabilidadeMunicipalRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cidade_id' => ['required', 'exists:cidades,id', 'size:6'],
            'alvara_endereco_fiscal' => ['required', 'boolean'],
            'cnae_exigido' => ['nullable', 'string'],
            'vigilancia' => ['required', 'boolean'],
            'modelo_solicitacao' => ['required', 'in:presencial,email,site'],
            'modelo_solicitacao_site' => ['nullable', 'url'],
            'tempo_emissao_alvara' => ['required', 'integer'],
            'tempo_emissao_licenca_sanitaria' => ['nullable', 'integer'],
            'valor_licenca_sanitaria' => ['nullable', 'numeric'],
            'mes_renovacao_alvara' => ['required', 'numeric', 'between:1,12'],
            'valor_alvara' => ['required', 'numeric'],
            'percentual_iss' => ['required', 'numeric', 'between:0,100'],
            'nfs_eletronica_manual' => ['required', 'in:eletronica,manual'],
            'crm_juridico' => ['required', 'boolean'],
            'documentos_necessarios' => ['nullable', 'array'],
            'abertura_area_rual' => ['required', 'boolean'],
            'anexos' => ['nullable', 'array'],
            'anexos.*.nome' => ['required', 'string'],
            'anexos.*.arquivo_id' => ['required', 'integer', 'exists:arquivos,id'],
            'observacoes' => ['nullable'],
            'modelo_solicitacao_email' => ['nullable', 'email'],
            'nfs_eletronica_manual_site' => ['nullable', 'url'],
        ];
    }
}
