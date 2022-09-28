<?php

namespace App\Services;

use App\Models\Empresa;
use App\Services\Empresa\StepsAfterRegistrationService;

class EmpresaPosCadastroStatusService
{
    protected array $steps = [];

    private EmpresaPosCadastroService $posCadastroService;

    private Empresa $empresa;
    /**
     * @var StepsAfterRegistrationService
     */
    private StepsAfterRegistrationService $stepsAfterRegistrationService;

    public function __construct(StepsAfterRegistrationService $stepsAfterRegistrationService)
    {
        $this->stepsAfterRegistrationService = $stepsAfterRegistrationService;
    }

    public function execute(int $empresa_id)
    {
        $this->empresa = Empresa::find($empresa_id);
        $this->posCadastroService = new EmpresaPosCadastroService($this->empresa);
        $this->checkCnpj();
        $this->checkAlvara();
        $this->checkNfse();
        $this->checkFinalizado();
        $steps = collect($this->steps)->values();
        $carteira = $this->empresa->carteiras;
        $responsavel = $carteira[0]->responsavel ?? null;
        return [
            'steps' => $steps,
            'canChat' => !!$responsavel,
            'clerk' => $responsavel
        ];
    }

    private function checkCnpj()
    {
        $status = $this->posCadastroService->verifyStepCnpj2() ? 'completed' : 'processing';
        $data = $this->stepsAfterRegistrationService->getStepsCNPJ($this->empresa);
        $this->steps['cnpj'] = $this->buildStatus('CNPJ/Contrato Social', 'Cadastro na Junta Comercial.', $status, $data);
    }

    private function checkAlvara()
    {
        $temCnpj = $this->steps['cnpj']['status'] === 'completed';
        if ($this->posCadastroService->verifyStepAlvara2()) {
            $status = 'completed';
        } elseif (!$this->posCadastroService->verifyStepAlvara2() && $temCnpj) {
            $status = 'processing';
        } else {
            $status = 'pending';
        }
        $data = $this->stepsAfterRegistrationService->getStepsAlvara($this->empresa);

        $this->steps['alvara'] = $this->buildStatus('Alvará', 'Emissão de alvará na Prefeitura.', $status, $data);
    }

    private function checkNfse()
    {
        $temEmissor = $this->empresa->acessos_prefeituras()->firstWhere('tipo', 'emissor');
        if ($temEmissor) {
            $status = 'completed';
        } elseif ($this->steps['alvara']['status'] === 'completed' && !$temEmissor) {
            $status = 'processing';
        } else {
            $status = 'pending';
        }
        $data = $this->stepsAfterRegistrationService->getStepsNF($this->empresa);

        $this->steps['nfse'] = $this->buildStatus('Nota Fiscal', 'Autorização para Emissão de NFSE.', $status, $data);

        // caso tenha nota fisca antes de emissao do alvara troca de posicao
        if ($this->steps['alvara']['status'] !== 'completed' && $status == 'completed') {
            $alvara = array_splice($this->steps, 1, 1);
            array_splice($this->steps, 2, 0, $alvara);
        }
    }

    private function checkFinalizado()
    {
        $aguardandoFinalizar = $this->posCadastroService->verifyStepFinalizada();
        $status = 'pending';
        if ($aguardandoFinalizar) {
            $status = 'processing';
        }
        $data = $this->stepsAfterRegistrationService->getStepsFinish();

        $this->steps['finalizada'] = $this->buildStatus('Finalizada', 'Pronto para faturar.', $status, $data);
    }

    private function buildStatus(string $name, string $description, string $status, $details)
    {
        return [
            'name' => $name,
            'description' => $description,
            'status' => $status,
            'details' => $details
        ];
    }
}
