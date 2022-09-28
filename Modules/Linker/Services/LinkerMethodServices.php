<?php

namespace Modules\Linker\Services;



class LinkerMethodServices
{

    private  $iLinkerMethodServices;

    public function __construct(ILinkerMethodServices $iLinkerMethodServices)
    {
        $this->iLinkerMethodServices = $iLinkerMethodServices;
    }



    public function aprovarTokenPayments($id,  $data)
    {
        return  $this->iLinkerMethodServices->aprovarTokenPayments($id,  $data);
    }

    public function requestTokenPayments($id,  $data)
    {
       return $this->iLinkerMethodServices->requestTokenPayments($id,  $data);
    }

    public function aprovarTokenExtrato($id,  $data)
    {
        return  $this->iLinkerMethodServices->aprovarTokenPayments($id,  $data);
    }

    public function requestTokenExtrato($id,  $data)
    {
       return $this->iLinkerMethodServices->requestTokenPayments($id,  $data);
    }

    public function verifToken()
    {
        return  $this->iLinkerMethodServices->verifToken();
    }
    public function login()
    {
        return  $this->iLinkerMethodServices->login();
    }
}
