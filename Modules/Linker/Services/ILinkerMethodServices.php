<?php

namespace Modules\Linker\Services;



interface ILinkerMethodServices
{
    // public function getAll(): iterable;

    public function aprovarTokenPayments($id,$data);

    public function requestTokenPayments($id,$data);

    public function aprovarTokenExtrato($id,$data);

    public function requestTokenExtrato($id,$data);

    public function login();

    public function verifToken();


    // public function update(array $data);

    // public function getByPayer(string $payer_type, int $payer_id): iterable;

    // public function delete(int $payment_method_id): bool;
}
