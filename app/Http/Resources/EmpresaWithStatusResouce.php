<?php

namespace App\Http\Resources;

use App\Models\Empresa;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Evaluation\Services\EvaluationEntityService;

/**
 * Class EmpresaWithStatusResouce
 *
 * Retorna o json das empresas de um cliente com o status de cada uma para selecao na aplicacao cliente
 */
class EmpresaWithStatusResouce extends JsonResource
{
    public function toArray($request)
    {
        $forma_pagamento = $this->contrato ? $this->contrato->forma_pagamento() : null;
        $faturas = $this->fatura()->whereIn('status', ['atrasado', 'expirado'])->get();

        if (!$this->razao_social && $this->status < 100) {
            $this->razao_social = $this->precadastro->empresa['razao_social'][0] ?? null;
        }

        $response = [
            'id' => $this->id,
            'razao_social' => $this->razao_social,
            'cnpj' => $this->cnpj,
            'regime_tributario' => $this->regime_tributario,
            'tipo_societario' => $this->tipo_societario,
            'status' => $this->status_label,
            'type' => $this->type,
            'codigo_acesso_simples' => $this->codigo_acesso_simples,
            'congelada' => (bool)$this->congelada,
            'motivoCongelamento' => $this->motivoCongelamento,
            'precas'=> $this->precadastro->empresa['razao_social']?? null,
            'forma_pagamento' => $forma_pagamento,
            'fatura' => $faturas->transform(fn($fatura) => [
                'id' => $fatura->id,
                'subtotal' => $fatura->subtotal,
                'status' => $fatura->status,
                'data_vencimento' => $fatura->data_vencimento,
                'mes' => $fatura->data_competencia->format('m/Y'),
                'pix_qrcode_text' => $fatura->pix_qrcode_text,]),
            'inscricao_municipal' => $this->inscricao_municipal,
            'data_sn' => $this->data_sn,
            'inicio_atividades' => $this->inicio_atividades,
            'nire' => $this->nire,
            'residencia' => $this->residencia_medica,
            'residencia_medica_arquivo'=>$this->residencia_medica_arquivo,
            'carteiras' => $this->carteiras,
            'alvara' => $this->alvara,
            'alvara_sanitario' => $this->alvara_sanitario,
            'bombeiro' => $this->bombeiro,
            'coworking' => $this->coworking,
            'endereco' => $this->endereco,
            'socios' => $this->socios,
            'socioAdministrador' => $this->socioAdministrador[0],
            'email' => $this->socioAdministrador[0]->emails,

            
            'label' => $this->label,
            'contrato_assinado' => boolval($this->contrato && $this->contrato->signed_at),
            'files' => $this->getArquivosEmpresaByName('Carta-de-trasferencia'),
            'data_encerramento' => $this->motivo_desativacao->data_encerramento ?? null,
            'autor' => $this->motivo_desativacao ? ($this->motivo_desativacao->responsavel ?
                $this->motivo_desativacao->responsavel->nome_completo : null) : null,
            'app_info' => [
                'updated_contact' => $this->appSettings ? $this->appSettings->updated_contact : null,
            ],
            'evaluations' => [
                'onboarding' => $this->getEvaluationInfo(1),
                'geral' => $this->getEvaluationInfo(3)
            ],
            'canChat' => !!($this->carteiras[0]->responsavel ?? false),
        ];

        if ($forma_pagamento == 'cartao') {
            $response['tem_cartao'] = (bool)$this->cartao_credito;
        }

        return $response;
    }

    private function getEvaluationInfo($evalationId)
    {
        $evaluation = (new EvaluationEntityService())->getEvaluationsByEntity($evalationId, 'empresa', $this->id);
        return $evaluation ? $evaluation->created_at : null;
    }
}
