<?php

namespace App\Http\Controllers;

use App\Services\CpfCnpjService;
use Illuminate\Http\Request;

class CpfCnpjController extends Controller
{
    /**
     * @var CpfCnpjService
     */
    private CpfCnpjService $cpfCnpjService;

    public function __construct(CpfCnpjService $cpfCnpjService)
    {
        $this->cpfCnpjService = $cpfCnpjService;
    }

    public function getByCpf($document)
    {
      return response($this->cpfCnpjService->getCpf($document));
    }

    public function getByCnpj($document)
    {
        return response($this->cpfCnpjService->getCnpj($document));
    }
}
