<?php


namespace App\Services\Recebimento\Gatway\Iugu\Common;


use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class IuguSubscription
{
    public $plan_identifier;
    public $customer_id;
    public $expires_at;
    public $only_on_charge_success = false;
    public $payable_with; // all, credit_card ou bank_slip
    public $subitems = [];

    public static function build()
    {
        return new static();
    }

    /**
     * @param mixed $plan_identifier
     * @return IuguSubscription
     */
    public function setPlanIdentifier(string $plan_identifier): IuguSubscription
    {
        $this->plan_identifier = $plan_identifier;
        return $this;
    }

    /**
     * @param mixed $customer_id
     * @return IuguSubscription
     */
    public function setCustomerId(string $customer_id): IuguSubscription
    {
        $this->customer_id = $customer_id;
        return $this;
    }

    /**
     * @param mixed $expires_at
     * @return IuguSubscription
     */
    public function setExpiresAt(string $expires_at): IuguSubscription
    {
        $this->expires_at = $expires_at;
        return $this;
    }

    public function resolveExpiresAt()
    {
        $hoje = today();
        if ($hoje->day > 10) {
            $expires_at = $hoje->addMonth()->format('10-m-Y');
        } elseif ($hoje->day <= 10) {
            $expires_at = $hoje->format('10-m-Y');
        }

        return $this->setExpiresAt($expires_at);
    }

    /**
     * @param bool $only_on_charge_success
     * @return IuguSubscription
     */
    public function setOnlyOnChargeSuccess(bool $only_on_charge_success): IuguSubscription
    {
        $this->only_on_charge_success = $only_on_charge_success;
        return $this;
    }

    /**
     * @param mixed $payable_with
     * @return IuguSubscription
     */
    public function setPayableWith(string $payable_with): IuguSubscription
    {
        $this->payable_with = $payable_with;
        return $this;
    }

    /**
     * @param Collection $subitems
     * @return IuguSubscription
     */
    public function setSubitems(Collection $subitems): IuguSubscription
    {
        $this->subitems = $subitems->toArray();
        return $this;
    }

    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }


}