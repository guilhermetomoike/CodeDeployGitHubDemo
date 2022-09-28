<?php


namespace App\Services\Simulador;


class SimulatorService
{
    /**
     * @var SimulatorService
     */
    public $Pgbl;

    /**
     * SimuladorService constructor.
     */
    public function __construct()
    {
        $this->Pgbl = new Pgbl();
    }
}