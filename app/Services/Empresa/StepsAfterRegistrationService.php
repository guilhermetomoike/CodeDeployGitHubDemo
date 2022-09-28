<?php


namespace App\Services\Empresa;


use App\Models\Empresa;

class StepsAfterRegistrationService
{

    public function getDataByStep(int $empresa_id, $step)
    {
        $empresa = Empresa::findOrFail($empresa_id);

        switch ($step) {
            case 'cnpj';
                return $this->getStepsCNPJ($empresa);
            case 'alvara';
                return $this->getStepsAlvara($empresa);
            case 'nf';
                return $this->getStepsNF($empresa);
            case 'finish';
                return $this->getStepsFinish();
        }
    }

    public function getStepsCNPJ(Empresa $empresa)
    {
        return [
            'protocolo' => $empresa->precadastro->empresa['protocolo'] ?? null,
            'razao_social' => $empresa->razao_social ?? null,
            'cnpj' => $empresa->cnpj ?? null,
            'cnae' => $empresa->cnae->codigo ?? null,
            'files-cartao-cnpj' => $empresa->getArquivosEmpresaByName('cartao_cnpj') ?? null,
            'files-contrato_social' => $empresa->getArquivosEmpresaByName('contrato_social') ?? null,
            'files-enquadramento' => $empresa->getArquivosEmpresaByName('enquadramento') ?? null,
            'files-guia' => $empresa->getArquivosEmpresaByName('guia') ?? null,
        ];
    }

    public function getStepsAlvara(Empresa $empresa)
    {
        return [
            'data_vencimento' => $empresa->alvara->data_vencimento ?? null,
            'inscricao_municipal' => $empresa->inscricao_municipal ?? null,
            'protocolo' => $empresa->precadastro->empresa['protocolo'] ?? null,
            'codigo_acesso' => $empresa->codigo_acesso_simples ?? null,
            'data_do_enquadramento' => $empresa->data_sn ?? null,
            'files' => $empresa->alvara->arquivos ?? null,
        ];
    }

    public function getStepsNF(Empresa $empresa)
    {
        return [
            'protocolo' => $empresa->precadastro->empresa['protocolo'] ?? null,
            'site' => $empresa->acessos_prefeituras->first()->site ?? null,
            'login' => $empresa->acessos_prefeituras->first()->login ?? null,
            'senha' => $empresa->acessos_prefeituras->first()->senha ?? null,
            'files' => $empresa->acessos_prefeituras->first()->arquivos ?? null
        ];
    }

    public function getStepsFinish()
    {
        return [
            'message' => 'Cadastro Finalizado'
        ];
    }
}
