<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaPosCadastroUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return collect([
            $this->rulesGerais(),
            $this->rulesStepCertificado(),
            $this->rulesStepDocumentation(),
            $this->rulesStepCnpj(),
            $this->rulesStepAlvara(),
            $this->rulesStepAcesso(),
            $this->rulesStepSimplesNacional(),
        ])->collapse()->toArray();
    }

    private function rulesGerais()
    {
        return [
            'precadastro.protocolo' => ['nullable'],
            'empresa.codigo_acesso_simples' => ['nullable'],
            'empresa.data_sn' => ['nullable', 'date_format:Y-m-d'],
            'carteira' => ['nullable']
        ];
    }

    private function rulesStepCertificado()
    {
        return [
            'certificado_digital_cliente' => ['nullable', 'array'],
            'certificado_digital_cliente.*.cliente_id' => ['nullable', 'integer', 'exists:clientes,id'],
            'certificado_digital_cliente.*.senha' => ['nullable'],
            'certificado_digital_cliente.*.validade' => ['nullable', 'date'],
            'certificado_digital_cliente.*.codigo' => ['nullable'],
            'certificado_digital_cliente.*.arquivo' => ['nullable', 'integer', 'exists:arquivos,id'],
            'certificado_digital_cliente.*.comprovante' => ['nullable', 'integer', 'exists:arquivos,id'],
            'certificado_digital_cliente.*.isWithCustomer' => ['nullable', 'boolean'],
            'certificado_digital_cliente.*.isWithPartner' => ['nullable', 'boolean'],

        ];
    }

    private function rulesStepDocumentation()
    {
        return [
            'socios.*.id' => ['nullable', 'integer'],
            'socios.*.attachmentRg' => ['nullable', 'integer', 'exists:arquivos,id'],
            'socios.*.attachmentCpf' => ['nullable', 'integer', 'exists:arquivos,id'],
            'socios.*.attachmentRgCpf' => ['nullable', 'integer', 'exists:arquivos,id'],
            'socios.*.attachmentComprovanteResidencia' => ['nullable', 'integer', 'exists:arquivos,id'],

            'socios.*.crm.numero' => ['nullable'],
            'socios.*.crm.data_emissao' => ['nullable', 'date'],
            'socios.*.crm.senha' => ['nullable'],
            'socios.*.crm.estado' => ['nullable', 'string'],
            'socios.*.crm.attachmentCrm' => ['nullable', 'integer', 'exists:arquivos,id'],

            'socios.*.irpf.realizacao' => ['nullable', 'string'],
            'socios.*.irpf.attachmentRecibo' => ['nullable', 'integer', 'exists:arquivos,id'],
            'socios.*.irpf.attachmentDeclaracao' => ['nullable', 'integer', 'exists:arquivos,id'],
        ];
    }

    private function rulesStepCnpj()
    {
        return [
            'empresa.razao_social' => ['nullable'],
            'empresa.tem_cadastro_dominio' => ['nullable'],

            'empresa.cnpj' => ['nullable', 'digits:14'],
            'empresa.inicio_atividades' => ['nullable', 'date'],

            'cnae.codigo' => ['nullable'],
            'empresa.nire' => ['nullable'],

            'empresa.arquivos.cartao_cnpj' => ['nullable', 'integer', 'exists:arquivos,id'],
            'empresa.arquivos.contrato_social' => ['nullable', 'integer', 'exists:arquivos,id'],
            'empresa.arquivos.enquadramento' => ['nullable', 'integer', 'exists:arquivos,id'],
            'empresa.arquivos.guia' => ['nullable', 'integer', 'exists:arquivos,id'],
            'empresa.arquivos.comprovante' => ['nullable', 'integer', 'exists:arquivos,id'],

            'empresa.arquivos.ecpf' => ['nullable', 'integer', 'exists:arquivos,id'],

            'certificado_digital_empresa.senha' => ['nullable'],
            'certificado_digital_empresa.validade' => ['nullable', 'date_format:Y-m-d'],
            'certificado_digital_empresa.codigo' => ['nullable'],
            'certificado_digital_empresa.arquivo' => ['nullable', 'integer', 'exists:arquivos,id'],

            'procuracaopj.data_vencimento' => ['nullable', 'date_format:Y-m-d'],
            'procuracaopj.arquivos.procuracao' => ['nullable', 'integer', 'exists:arquivos,id'],

            'procuracaopf.data_vencimento' => ['nullable', 'date_format:Y-m-d'],
            'procuracaopf.arquivos.procuracao' => ['nullable', 'integer', 'exists:arquivos,id'],
        ];
    }

    private function rulesStepAlvara()
    {
        return [
            'empresa.inscricao_municipal' => ['nullable'],

            'alvara_sanitario.data_vencimento' => ['nullable', 'date_format:Y-m-d'],
            'alvara_sanitario.arquivos.alvara' => ['nullable', 'integer', 'exists:arquivos,id'],
           
            'bombeiro.data_vencimento' => ['nullable', 'date_format:Y-m-d'],
            'bombeiro.arquivos.alvara' => ['nullable', 'integer', 'exists:arquivos,id'],
            
            'alvara.data_vencimento' => ['nullable', 'date_format:Y-m-d'],
            'alvara.definitivo' => ['nullable', 'integer'],

            
            'alvara.arquivos.alvara' => ['nullable', 'integer', 'exists:arquivos,id'],
            'alvara.arquivos.requerimento' => ['nullable', 'integer', 'exists:arquivos,id'],
            'alvara.arquivos.guia_laudo' => ['nullable', 'integer', 'exists:arquivos,id'],
        ];
    }

    private function rulesStepAcesso()
    {
        return [
            'acessos_prefeituras.site' => ['nullable'],
            'acessos_prefeituras.login' => ['nullable'],
            'acessos_prefeituras.senha' => ['nullable'],
            'acessos_prefeituras.tipo' => ['nullable'],
            'acessos_prefeituras.arquivos.aidf' => ['nullable', 'integer', 'exists:arquivos,id'],

            'acessos_deiss.site' => ['nullable'],
            'acessos_deiss.login' => ['nullable'],
            'acessos_deiss.senha' => ['nullable'],
            'acessos_deiss.tipo' => ['nullable'],
        ];
    }

    private function rulesStepSimplesNacional()
    {
        return [
            'empresa.arquivos.comprovante_do_enquadramento_simples_nacional' => ['nullable', 'integer', 'exists:arquivos,id'],
        ];
    }
}
