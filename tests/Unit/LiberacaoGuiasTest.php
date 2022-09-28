<?php

namespace Tests\Unit;

use App\Models\Empresa;
use App\Repositories\GuialiberacaoRepository;
use App\Services\GuiaService;
use Carbon\Carbon;
use Tests\TestCase;

class LiberacaoGuiasTest extends TestCase
{
    public function testPresumidaTrimestralFaltandoRHForaDoMesDeTributacao()
    {
        Carbon::setTestNow('2020-11-01');

        $competencia = '2020-10-01';

        $empresa = Empresa::find(74);
        $empresa->trimestral = true;
        $empresa->regime_tributario = "Presumido";
        $empresa->save();

        $guiaService = new GuiaService(new GuialiberacaoRepository);
        $requiredTypes = ['ISS', 'PIS/COFINS', 'IRPJ/CSLL', 'INSS', 'IRRF'];
        $required_presumido = Empresa\RequiredGuide::query()->whereIn('name', $requiredTypes)->get();
        $empresa->required_guide()->saveMany($required_presumido);

        $dataSet = [];
        foreach ($requiredTypes as $requiredType) {
            if ($requiredType === 'INSS') continue;
            $dataSet[] = ['tipo' => $requiredType, 'data_competencia' => $competencia];
        }
        $empresa->guias()->createMany($dataSet);

        $guiaService->eligesToSendByEmpresa($empresa, $competencia);
        $guia_liberacao = $empresa->guia_liberacao()->where('competencia', $competencia)->first();

        $this->assertTrue(!!$guia_liberacao && $guia_liberacao->contabilidade_departamento_liberacao);
        $this->assertTrue(!!$guia_liberacao && $guia_liberacao->rh_departamento_liberacao);
    }

    public function testPresumidaTrimestralFaltandoRHForaDoMesDeTributacao2()
    {
        Carbon::setTestNow('2020-12-01');

        $competencia = '2020-11-01';

        $empresa = Empresa::find(74);
        $empresa->trimestral = true;
        $empresa->regime_tributario = "Presumido";
        $empresa->save();

        $guiaService = new GuiaService(new GuialiberacaoRepository);
        $requiredTypes = ['ISS', 'PIS/COFINS', 'IRPJ/CSLL', 'INSS', 'IRRF'];
        $required_presumido = Empresa\RequiredGuide::query()->whereIn('name', $requiredTypes)->get();
        $empresa->required_guide()->saveMany($required_presumido);

        $dataSet = [];
        foreach ($requiredTypes as $requiredType) {
            if ($requiredType === 'INSS') continue;
            $dataSet[] = ['tipo' => $requiredType, 'data_competencia' => $competencia];
        }
        $empresa->guias()->createMany($dataSet);

        $guiaService->eligesToSendByEmpresa($empresa, $competencia);
        $guia_liberacao = $empresa->guia_liberacao()->where('competencia', $competencia)->first();

        $this->assertTrue(!!$guia_liberacao && $guia_liberacao->contabilidade_departamento_liberacao);
        $this->assertTrue(!!$guia_liberacao && $guia_liberacao->rh_departamento_liberacao);
    }

    public function testLiberaComRhFaltandoPresumidasComTributacaoTrimestralNoMesDeTributacao()
    {
        Carbon::setTestNow('2020-10-01');
        $competencia = '2020-09-01';
        $empresa = Empresa::find(74);
        $empresa->trimestral = true;
        $empresa->regime_tributario = 'Presumido';
        $empresa->save();

        $guiaService = new GuiaService(new GuialiberacaoRepository);
        $requiredTypes = ['ISS', 'PIS/COFINS', 'IRPJ/CSLL', 'INSS', 'IRRF'];
        $required_presumido = Empresa\RequiredGuide::query()->whereIn('name', $requiredTypes)->get();
        $empresa->required_guide()->saveMany($required_presumido);

        $dataSet = [];
        foreach ($requiredTypes as $requiredType) {
            if ($requiredType === 'INSS') continue;
            $dataSet[] = ['tipo' => $requiredType, 'data_competencia' => $competencia];
        }
        $empresa->guias()->createMany($dataSet);

        $guiaService->eligesToSendByEmpresa($empresa, $competencia);
        $guia_liberacao = $empresa->guia_liberacao()->where('competencia', $competencia)->first();

        $this->assertTrue(!!$guia_liberacao && $guia_liberacao->contabilidade_departamento_liberacao);
        $this->assertFalse(!!$guia_liberacao && $guia_liberacao->rh_departamento_liberacao);
    }

    public function testLiberaPresumidasComTributacaoTrimestralNoMesDeTributacaoComTodasAsGuias()
    {
        Carbon::setTestNow('2020-10-01');
        $competencia = '2020-09-01';
        $empresa = Empresa::find(74);
        $empresa->trimestral = true;
        $empresa->regime_tributario = 'Presumido';
        $empresa->save();

        $guiaService = new GuiaService(new GuialiberacaoRepository);
        $requiredTypes = ['ISS', 'PIS/COFINS', 'IRPJ/CSLL', 'INSS', 'IRRF'];
        $required_presumido = Empresa\RequiredGuide::query()->whereIn('name', $requiredTypes)->get();
        $empresa->required_guide()->saveMany($required_presumido);

        $dataSet = [];
        foreach ($requiredTypes as $requiredType) {
            $dataSet[] = ['tipo' => $requiredType, 'data_competencia' => $competencia];
        }
        $empresa->guias()->createMany($dataSet);

        $guiaService->eligesToSendByEmpresa($empresa, $competencia);
        $guia_liberacao = $empresa->guia_liberacao()->where('competencia', $competencia)->first();

        $this->assertTrue(!!$guia_liberacao && $guia_liberacao->contabilidade_departamento_liberacao);
        $this->assertTrue(!!$guia_liberacao && $guia_liberacao->rh_departamento_liberacao);
    }

    public function testLiberaComContabilidadeFaltandoPresumidasComTributacaoTrimestralNoMesDeTributacao()
    {
        Carbon::setTestNow('2020-10-01');
        $competencia = '2020-09-01';

        $empresa = Empresa::find(74);
        $empresa->trimestral = true;
        $empresa->regime_tributario = 'Presumido';
        $empresa->save();

        $guiaService = new GuiaService(new GuialiberacaoRepository);
        $requiredTypes = ['ISS', 'PIS/COFINS', 'IRPJ/CSLL', 'INSS', 'IRRF'];
        $required_presumido = Empresa\RequiredGuide::query()->whereIn('name', $requiredTypes)->get();
        $empresa->required_guide()->saveMany($required_presumido);

        $dataSet = [];
        foreach ($requiredTypes as $requiredType) {
            if ($requiredType === 'ISS') continue;
            $dataSet[] = ['tipo' => $requiredType, 'data_competencia' => $competencia];
        }
        $empresa->guias()->createMany($dataSet);

        $guiaService->eligesToSendByEmpresa($empresa, $competencia);
        $guia_liberacao = $empresa->guia_liberacao()->where('competencia', $competencia)->first();

        $this->assertFalse(!!$guia_liberacao && $guia_liberacao->contabilidade_departamento_liberacao);
        $this->assertTrue(!!$guia_liberacao && $guia_liberacao->rh_departamento_liberacao);
    }

    public function testLiberaComTodasAsGuiasSimplesNacional()
    {
        Carbon::setTestNow('2020-10-01');
        $competencia = '2020-09-01';

        $empresa = Empresa::find(74);
        $empresa->trimestral = false;
        $empresa->regime_tributario = 'SN';
        $empresa->save();

        $guiaService = new GuiaService(new GuialiberacaoRepository);
        $requiredTypes = ['DAS', 'INSS', 'IRRF'];
        $required_presumido = Empresa\RequiredGuide::query()->whereIn('name', $requiredTypes)->get();
        $empresa->required_guide()->saveMany($required_presumido);

        $dataSet = [];
        foreach ($requiredTypes as $requiredType) {
            $dataSet[] = ['tipo' => $requiredType, 'data_competencia' => $competencia];
        }
        $empresa->guias()->createMany($dataSet);

        $guiaService->eligesToSendByEmpresa($empresa, $competencia);
        $guia_liberacao = $empresa->guia_liberacao()->where('competencia', $competencia)->first();

        $this->assertTrue(!!$guia_liberacao && $guia_liberacao->contabilidade_departamento_liberacao);
        $this->assertTrue(!!$guia_liberacao && $guia_liberacao->rh_departamento_liberacao);
    }

    public function testLiberaFaltandoGuiaContabilidadeSimplesNacional()
    {
        Carbon::setTestNow('2020-10-01');
        $competencia = '2020-09-01';

        $empresa = Empresa::find(74);
        $empresa->trimestral = false;
        $empresa->regime_tributario = 'SN';
        $empresa->save();

        $guiaService = new GuiaService(new GuialiberacaoRepository);
        $requiredTypes = ['DAS', 'INSS', 'IRRF'];
        $required_presumido = Empresa\RequiredGuide::query()->whereIn('name', $requiredTypes)->get();
        $empresa->required_guide()->saveMany($required_presumido);

        $dataSet = [];
        foreach ($requiredTypes as $requiredType) {
            if ($requiredType === 'DAS') continue;
            $dataSet[] = ['tipo' => $requiredType, 'data_competencia' => $competencia];
        }
        $empresa->guias()->createMany($dataSet);

        $guiaService->eligesToSendByEmpresa($empresa, $competencia);
        $guia_liberacao = $empresa->guia_liberacao()->where('competencia', $competencia)->first();

        $this->assertFalse(!!$guia_liberacao && $guia_liberacao->contabilidade_departamento_liberacao);
        $this->assertTrue(!!$guia_liberacao && $guia_liberacao->rh_departamento_liberacao);
    }

    public function testLiberaFaltandoGuiaRhSimplesNacional()
    {
        Carbon::setTestNow('2020-10-01');
        $competencia = '2020-09-01';

        $empresa = Empresa::find(74);
        $empresa->trimestral = false;
        $empresa->regime_tributario = 'SN';
        $empresa->save();

        $guiaService = new GuiaService(new GuialiberacaoRepository);
        $requiredTypes = ['DAS', 'INSS', 'IRRF'];
        $required_presumido = Empresa\RequiredGuide::query()->whereIn('name', $requiredTypes)->get();
        $empresa->required_guide()->saveMany($required_presumido);

        $dataSet = [];
        foreach ($requiredTypes as $requiredType) {
            if ($requiredType === 'INSS') continue;
            $dataSet[] = ['tipo' => $requiredType, 'data_competencia' => $competencia];
        }
        $empresa->guias()->createMany($dataSet);

        $guiaService->eligesToSendByEmpresa($empresa, $competencia);
        $guia_liberacao = $empresa->guia_liberacao()->where('competencia', $competencia)->first();

        $this->assertTrue(!!$guia_liberacao && $guia_liberacao->contabilidade_departamento_liberacao);
        $this->assertFalse(!!$guia_liberacao && $guia_liberacao->rh_departamento_liberacao);
    }
}
