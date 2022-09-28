<?php

namespace Modules\EmpresaAlteracao\Services;

use Illuminate\Support\Facades\DB;
use Modules\EmpresaAlteracao\Entities\EmpresaAlteracao;

class FinalizarEmpresaAlteracaoService
{
    private $empresa;

    private $empresaAlteracao;

    private $alteracao;

    public function __construct(EmpresaAlteracao $empresaAlteracao)
    {
        $this->empresaAlteracao = $empresaAlteracao;

        $this->empresa = $empresaAlteracao->empresa;

        $this->alteracao = $empresaAlteracao->alteracao;
    }

    public function finalizar()
    {
        try {
            DB::beginTransaction();

            $this->updateEmpresa();
            $this->updateSocios();
            $this->updateContatos();
            $this->updateEndereco();

            $this->empresaAlteracao->updateStatus(EmpresaAlteracao::STATUS_FINALIZADO);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    private function updateEmpresa()
    {
        $this->empresa->update($this->alteracao['empresa']);
    }

    private function updateSocios()
    {
        $socios = collect($this->alteracao['socios'])->mapWithKeys(function ($socio) {
            $pivot = [];

            if ($socio['id'] == $this->alteracao['socio_administrador']) {
                $pivot = ['socio_administrador' => 1];
            }

            return [$socio['id'] => $pivot];
        });

        $this->empresa->socios()->sync($socios);
    }

    private function updateContatos()
    {
        $this->empresa->contatos()->delete();
        $this->empresa->contatos()->createMany($this->alteracao['contatos']);
    }

    private function updateEndereco()
    {
        $this->empresa->endereco->update($this->alteracao['endereco']);
    }
}
