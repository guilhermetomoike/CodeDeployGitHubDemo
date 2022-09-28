<?php


namespace Modules\Invoice\Services\PaymentMethod;


use Illuminate\Database\Eloquent\Model;

interface IPaymentMethodService
{
    public function getAll(): iterable;

    public function create(array $data);
    
    public function update(array $data);

    public function getByPayer(string $payer_type, int $payer_id): iterable;

    public function delete(int $payment_method_id): bool;
}
