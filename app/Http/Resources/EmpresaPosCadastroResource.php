<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaPosCadastroResource extends JsonResource
{
    public function toArray($request)
    {
if(!isset($this->precadastro->usuario->id)){

         return ['msg'=>'usuario deletado ou com problemas, por favor verificar!!'];

        // return 'usuario deletado ou com problemas verificar';
    }
        return [
            'id' => $this->id,
            'nome_fantasia' => $this->nome_fantasia,
            'razao_social' => $this->razao_social,
            'cnpj' => $this->cnpj,
            'nire' => $this->nire,
            'inscricao_municipal' => $this->inscricao_municipal,
            'status_id' => $this->status_id,
            'status_label' => $this->status_label,
            'regime_tributario' => $this->regime_tributario,
            'tipo_societario' => $this->tipo_societario,
            'clinica_fisica' => $this->clinica_fisica,
            'codigo_acesso_simples' => $this->codigo_acesso_simples,
            'data_sn' => $this->data_sn,
            'inicio_atividades' => $this->inicio_atividades,
            'created_at' => $this->created_at,
            'tem_cadastro_dominio' => $this->tem_cadastro_dominio == 1 ? true:false,


            'contrato' => $this->contrato ? [
                'signed_at' => $this->contrato->signed_at,
                'arquivo' => $this->contrato->arquivo
            ] : [],
            'carteiras' => $this->carteiras,
            //ENDERECO
            'endereco' => $this->endereco ? [
                'id' => $this->endereco->id,
                'iptu' => $this->endereco->iptu,
                'logradouro' => $this->endereco->logradouro,
                'numero' => $this->endereco->numero,
                'bairro' => $this->endereco->bairro,
                'cidade' => $this->endereco->cidade,
                'uf' => $this->endereco->uf,
                'cep' => $this->endereco->cep,
                'complemento' => $this->endereco->complemento,
                'tipo' => $this->endereco->tipo,
            ] : [],

            //CONTATOS
            'contatos' => $this->contatos->map(fn($contato) => [
                'id' => $contato->id,
                'value' => $contato->value,
                'tipo' => $contato->tipo,
                'options' => $contato->options,
                'optin' => $contato->optin,
            ])->toArray(),

            //SOCIOS
            'socios' => $this->socios->map(fn($socio) => [
                'id' => $socio->id,
                'nome_completo' => $socio->nome_completo,
                'cpf' => $socio->cpf,
                'rg' => $socio->rg,
                'nacionalidade' => $socio->nacionalidade,
                'naturalidade' => $socio->naturalidade,
                'estado_civil' => $socio->estado_civil,
                'ies' => $socio->ies()->first(),
                'qualificacao' => $socio->qualificacao()->first(),
                'profissao' => $socio->profissao,
                'especialidade' => $socio->especialidade()->first(),
                'endereco' => $socio->endereco,
                'contatos' => $socio->contatos,
                'arquivos' => $socio->arquivos,
                'certificado_digital' => $socio->certificado_digital,
                'pivot' => $socio->pivot,
                'crm' => $socio->crm,
                'irpf' => $socio->irpf,
            ])->toArray(),

            //ARQUIVOS
            'arquivos' => $this->arquivos,

            //PRECADASTRO
            'precadastro' => [
                'tipo' => $this->precadastro->tipo,
                'empresa' => $this->precadastro->empresa,
                'usuario' => [
                    'nome_completo' => $this->precadastro->usuario->nome_completo,
                ],
                'origem' => $this->precadastro->origem,
            ],

            //CNAE
            'cnae' => [
                'codigo' => $this->cnae->codigo ?? null,
            ],

            //ALVARA
            'alvara' => [
                'data_vencimento' => $this->alvara->data_vencimento ?? null,
                'alvaraDefinitivo' => $this->alvara->definitivo ?? null,

                'arquivos' => $this->alvara->arquivos ?? null,
            ],

            //ALVARA
            'alvara_sanitario' => [
                'data_vencimento' => $this->alvara_sanitario->data_vencimento ?? null,
                'arquivos' => $this->alvara_sanitario->arquivos ?? null,
            ],

              //bombeiro
              'bombeiro' => [
                'data_vencimento' => $this->bombeiro->data_vencimento ?? null,
                'arquivos' => $this->bombeiro->arquivos ?? null,
            ],
              //procuracaopf
              'procuracaopf' => [
                'data_vencimento' => $this->procuracaopf->data_vencimento ?? null,
                'arquivos' => $this->procuracaopf->arquivos ?? null,
            ],

              //procuracaopj
              'procuracaopj' => [
                'data_vencimento' => $this->procuracaopj->data_vencimento ?? null,
                'arquivos' => $this->procuracaopj->arquivos ?? null,
            ],
            //CERTIFICADO DIGITAL
            'certificado_digital' => [
                'codigo' => $this->certificado_digital->codigo ?? null,
                'senha' => $this->certificado_digital->senha ?? null,
                'validade' => $this->certificado_digital->validade ?? null,
                'arquivos' => $this->certificado_digital->arquivos ?? null,
            ],

            //ACESSOS PREFEITURAS
            'acessos_prefeituras' => [
                'site' => $this->acessos_prefeituras[0]->site ?? null,
                'login' => $this->acessos_prefeituras[0]->login ?? null,
                'senha' => $this->acessos_prefeituras[0]->senha ?? null,
                'arquivos' => $this->acessos_prefeituras[0]->arquivos ?? null,
            ],
               //ACESSOS PREFEITURAS
               'acessos_deiss' => [
                'site' => $this->acessos_deiss[0]->site ?? null,
                'login' => $this->acessos_deiss[0]->login ?? null,
                'senha' => $this->acessos_deiss[0]->senha ?? null,
            ],
        ];
    }
}
