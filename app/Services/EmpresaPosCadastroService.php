<?php

namespace App\Services;

use App\Events\PosCadastroDocumentationEvent;
use App\Events\PosCadastroNfseEvent;
use App\Events\PosCadastroAlvaraEvent;
use App\Events\PosCadastroCertificadoEvent;
use App\Events\PosCadastroCnpjEvent;
use App\Events\PosCadastroFinalizadaEvent;
use App\Events\PosCadastroSimplesNacionalEvent;
use App\Models\Empresa;

class EmpresaPosCadastroService
{
    private $empresa;
    private array $certificadoWithCustomer = [];
    private array $certificadoWithPartner = [];


    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
    }

    public function update(array $data)
    {
        $data = $this->cleanData($data);

        if (!empty($data['precadastro']['protocolo'])) {
            $this->empresa->precadastro->fill([
                'empresa->protocolo' => $data['precadastro']['protocolo']
            ]);
            $this->empresa->precadastro->save();
        }

        if (!empty($data['empresa'])) {
            $this->empresa->fill($data['empresa']);
            $this->empresa->save();
        }

        if (!empty($data['empresa']['arquivos'])) {
            foreach ($data['empresa']['arquivos'] as $nome => $id) {
                $this->empresa->updateArquivo($id, $nome);
            }
        }

        if (!empty($data['cnae']['codigo'])) {
            $this->empresa->cnae()->updateOrCreate([], [
                'codigo' => $data['cnae']['codigo'],
                'principal' => 'SIM',
            ]);
        }

        // ALVARA
        if (!empty($data['alvara']['data_vencimento'])) {
            $this->empresa->alvara()->updateOrCreate([], [
                'data_vencimento' => $data['alvara']['data_vencimento'],
            ]);
        }

        if (!empty($data['alvara']['definitivo'])) {
            $this->empresa->alvara()->updateOrCreate([], [
                'definitivo' => $data['alvara']['definitivo'],
            ]);
        }
    
        if (!empty($data['alvara']['arquivos'])) {
            foreach ($data['alvara']['arquivos'] as $nome => $id) {
                $this->empresa->alvara->updateArquivo($id, $nome, ["empresa:{$this->empresa->id}"]);
            }
        }

        // Alvara Sanitario
        if (!empty($data['alvara_sanitario']['data_vencimento'])) {
            $this->empresa->alvara_sanitario()->updateOrCreate([], [
                'data_vencimento' => $data['alvara_sanitario']['data_vencimento'],
            ]);
        }

        if (!empty($data['alvara_sanitario']['arquivos'])) {
            foreach ($data['alvara_sanitario']['arquivos'] as $nome => $id) {
                $this->empresa->alvara_sanitario->updateArquivo($id, $nome, ["empresa:{$this->empresa->id}"]);
            }
        }
        // Alvara bombeiro
        if (!empty($data['bombeiro']['data_vencimento'])) {
            $this->empresa->bombeiro()->updateOrCreate([], [
                'data_vencimento' => $data['bombeiro']['data_vencimento'],
            ]);
        }

        if (!empty($data['bombeiro']['arquivos'])) {
            foreach ($data['bombeiro']['arquivos'] as $nome => $id) {
                $this->empresa->bombeiro->updateArquivo($id, $nome, ["empresa:{$this->empresa->id}"]);
            }
        }
         // Procuracao pf
         if (!empty($data['procuracaopf']['data_vencimento'])) {
            $this->empresa->procuracaopf()->updateOrCreate([], [
                'data_vencimento' => $data['procuracaopf']['data_vencimento'],
                'tipo' => 'pf',

            ]);
        }

        if (!empty($data['procuracaopf']['arquivos'])) {
            foreach ($data['procuracaopf']['arquivos'] as $nome => $id) {
                $this->empresa->procuracaopf->updateArquivo($id, $nome, ["empresa:{$this->empresa->id}"]);
            }
        }
             // Procuracao pj
             if (!empty($data['procuracaopj']['data_vencimento'])) {
                $this->empresa->procuracaopj()->updateOrCreate([], [
                    'data_vencimento' => $data['procuracaopj']['data_vencimento'],
                    'tipo' => 'pj',

                ]);
            }
    
            if (!empty($data['procuracaopj']['arquivos'])) {
                foreach ($data['procuracaopj']['arquivos'] as $nome => $id) {
                    $this->empresa->procuracaopj->updateArquivo($id, $nome, ["empresa:{$this->empresa->id}"]);
                }
            }

        if (!empty($data['acessos_deiss'])) {
            $this->empresa->acessos_deiss()->updateOrCreate([
                'tipo' => $data['acessos_deiss']['tipo']
            ], $data['acessos_deiss']);
        }

        if (!empty($data['acessos_prefeituras'])) {
            $this->empresa->acessos_prefeituras()->updateOrCreate([
                'tipo' => $data['acessos_prefeituras']['tipo']
            ], $data['acessos_prefeituras']);
        }

        if (!empty($data['acessos_prefeituras']['arquivos'])) {
            foreach ($data['acessos_prefeituras']['arquivos'] as $nome => $id) {
                $this->empresa->acessos_prefeituras->updateArquivo($id, $nome, ["empresa:{$this->empresa->id}"]);
            }
        }

        if (!empty($data['certificado_digital_cliente'])) {
            foreach ($data['certificado_digital_cliente'] as $certificado) {
                $cliente = $this->empresa->socios->find($certificado['cliente_id']);
                $cliente->certificado_digital()->updateOrCreate([], $certificado);

                if (isset($certificado['isWithCustomer']) && $certificado['isWithCustomer'] === true) {
                    $this->certificadoWithCustomer[$certificado['cliente_id']] = $certificado['isWithCustomer'];
                    continue;
                }
                if (isset($certificado['isWithPartner']) && $certificado['isWithPartner'] === true) {
                    $this->certificadoWithPartner[$certificado['cliente_id']] = $certificado['isWithPartner'];
                    continue;
                }

                if (isset($certificado['arquivo'])) {
                    $cliente->certificado_digital->addArquivo($certificado['arquivo'], 'certificado_digital');
                }

                if (isset($certificado['comprovante'])) {
                    $cliente->certificado_digital->addArquivo($certificado['comprovante'], 'comprovante_certificado');
                }
            }
        }

        if (!empty($data['certificado_digital_empresa'])) {
            $this->empresa->certificado_digital()->updateOrCreate([], $data['certificado_digital_empresa']);
            if (isset($data['certificado_digital_empresa']['arquivo'])) {
                $this->empresa->certificado_digital->addArquivo($data['certificado_digital_empresa']['arquivo'], 'arquivo_certificado');
            }
            if (isset($data['certificado_digital_empresa']['comprovante'])) {
                $this->empresa->certificado_digital->addArquivo($data['certificado_digital_empresa']['comprovante'], 'comprovante_certificado');
            }
        }

        if (!empty($data['carteira'])) {
            $this->empresa->carteiras()->sync($data['carteira']);
        }

        if (!empty($data['socios'])) {
            foreach ($data['socios'] as $socio) {
                $cliente = $this->empresa->socios()->find($socio['id']);

                if (!empty($socio['attachmentRg'])) {
                    $cliente->addArquivo($socio['attachmentRg'], 'rg');
                }

                if (!empty($socio['attachmentCpf'])) {
                    $cliente->addArquivo($socio['attachmentCpf'], 'cpf');
                }

                if (!empty($socio['attachmentRgCpf'])) {
                    $cliente->addArquivo($socio['attachmentRgCpf'], 'rg_cpf');
                }

                if (!empty($socio['attachmentComprovanteResidencia'])) {
                    $cliente->addArquivo($socio['attachmentComprovanteResidencia'], 'comprovante_de_residencia');
                }

                if (!empty($socio['crm']['data_emissao'])) {
                    $crm = $cliente->crm()->updateOrCreate([], $socio['crm']);

                    if (isset($socio['crm']['attachmentCrm'])) {
                        $crm->addArquivo($socio['crm']['attachmentCrm'], 'crm');
                    }
                }

                if (!empty($socio['irpf']['realizacao'])) {
                    $irpf = $cliente
                        ->irpf()
                        ->updateOrCreate(
                            $socio['irpf'] + ['ano' => today()->subYear()->year]
                        );

                    if (isset($socio['irpf']['attachmentRecibo'])) {
                        $irpf->addArquivo($socio['irpf']['attachmentRecibo'], 'recibo');
                    }

                    if (isset($socio['irpf']['attachmentDeclaracao'])) {
                        $irpf->addArquivo($socio['irpf']['attachmentDeclaracao'], 'declaracao');
                    }
                }
            }
        }
    }

    private function cleanData(array $data)
    {
        return array_filter(array_map('array_filter', $data));
    }

    public function fireEvents()
    {
        if ($this->verifyStepFinalizada()) {
            event(new PosCadastroFinalizadaEvent($this->empresa));
            return;
        }

        if ($this->verifyStepCertificado()) {
            event(new PosCadastroCertificadoEvent($this->empresa));
            return;
        }

        if ($this->verifyStepDocumentation()) {
            event(new PosCadastroDocumentationEvent($this->empresa));
            return;
        }

        if ($this->verifyStepCnpj()) {
            event(new PosCadastroCnpjEvent($this->empresa));
            return;
        }

        if ($this->verifyStepAlvara()) {
            event(new PosCadastroAlvaraEvent($this->empresa));
            return;
        }

        if ($this->verifyStepNfse()) {
            event(new PosCadastroNfseEvent($this->empresa));
            return;
        }

        if ($this->verifyStepSimplesNacional()) {
            event(new PosCadastroSimplesNacionalEvent($this->empresa));
            return;
        }
    }

    private function verifyStepCertificado()
    {
        $sociosSemCertificado = $this->validateExistCertificado();

        return $this->empresa->status_id == 3 && (
            ($sociosSemCertificado->isEmpty() && $this->verifyStepDocumentation()) ||
            $this->empresa->precadastro->tipo === 'transferencia'
        );
    }

    private function validateExistCertificado()
    {
        return $this->empresa->socios->filter(function ($socio) {
            return !empty($socio->certificado_digital) ||
                (isset($this->certificadoWithCustomer[$socio->id]) && $this->certificadoWithCustomer[$socio->id] === true) ||
                (isset($this->certificadoWithPartner[$socio->id]) && $this->certificadoWithPartner[$socio->id] === true) ||
                $this->empresa->precadastro->tipo === 'transferencia';
        });
    }

    private function verifyStepDocumentation()
    {
        foreach ($this->empresa->socios as $socio) {
            $rg = $socio->arquivos()->where('nome', 'rg')->count();
            $cpf = $socio->arquivos()->where('nome', 'cpf')->count();
            $rgCpf = $socio->arquivos()->where('nome', 'rg_cpf')->count();
            $sociosSemCertificado = $this->validateExistCertificado();

            $certificado = $this->empresa->status_id == 3 && !$sociosSemCertificado->isEmpty();

            if (($rgCpf > 0 && $certificado) || ($rg > 0 && $cpf > 0 && $certificado)) {
                continue;
            }

            return false;
        }
        return true;
    }

    public function verifyStepCnpj()
    {
        $arquivos = $this->empresa->arquivos()
            ->whereIn('nome', ['cartao_cnpj', 'contrato_social'])
            ->get();

        return ($this->empresa->status_id == 4)
            && !empty($this->empresa->cnpj)
            && !empty($this->empresa->razao_social)
            && $arquivos->count() >= 2;
    }

    public function verifyStepAlvara()
    {
        $arquivoCount = 0;

        if (!empty($this->empresa->alvara)) {
            $arquivoCount = $this->empresa->alvara->arquivos()
                ->where('nome', 'alvara')
                ->get()
                ->count();
        }

        return ($this->empresa->status_id == 5)
            && $arquivoCount >= 1;
    }

    public function verifyStepNfse()
    {
        $emissor = $this->empresa->acessos_prefeituras()->firstWhere('tipo', 'emissor');
        return ($this->empresa->status_id == 6)
            && $emissor
            && !empty($emissor->site)
            && !empty($emissor->login)
            && !empty($emissor->senha);
    }

    private function verifyStepSimplesNacional()
    {
        $arquivo = $this->empresa->arquivos()
            ->where('nome', 'comprovante_do_enquadramento_simples_nacional')
            ->get();

        return ($this->empresa->status_id == 7)
            && !empty($this->empresa->codigo_acesso_simples)
            && !empty($this->empresa->data_sn)
            && $arquivo->count() == 1;
    }

    public function verifyStepFinalizada()
    {
        return $this->empresa->status_id == 99 &&
            $this->empresa
            ->carteiras()
            ->whereIn('setor', ['contabilidade', 'rh'])
            ->count() === 2;
    }

    public function verifyStepCnpj2()
    {
        $arquivos = $this->empresa->arquivos()
            ->whereIn('nome', ['cartao_cnpj', 'contrato_social'])
            ->get();

        return ($this->empresa->status_id >= 4)
            && !empty($this->empresa->cnpj)
            && !empty($this->empresa->razao_social)
            && $arquivos->count() >= 2;
    }

    public function verifyStepAlvara2()
    {
        $arquivoCount = 0;

        if (!empty($this->empresa->alvara)) {
            $arquivoCount = $this->empresa->alvara->arquivos()
                ->where('nome', 'alvara')
                ->get()
                ->count();
        }

        return ($this->empresa->status_id >= 5)
            && !empty($this->empresa->alvara->data_vencimento)
            && $arquivoCount >= 1;
    }
}
