<?php


namespace App\Services\Recebimento\Gatway\Asas\Common;

use App\Services\Recebimento\Gatway\Asas\Common\PaymentSubItem;
use Illuminate\Support\Collection;

class AsasFaturaCartaoCredito
{
    // public bool $ensure_workday_dueDate = true;
    // public array $items = [];
 
    // public string $payable_with = 'all';
    public string $notification_url;
    public string $customer; //: "{CUSTOMER_ID}",
    public string $billingType; // "BOLETO",
    public string $dueDate; // data vencimento
    public float  $value;  //: 100.00,
    public string $description; // "Pedido 056984",
    public string $externalReference; // $id_fatura
    public array $discount; 
    public array $creditCardHolderInfo;
    public array $creditCard;


        public array $fine;
        public array  $interest;

    public bool $postalService = false;

    public static function build()
    {
        return new static();
    }

    /**
     * @param mixed $dueDate
     * @return AsasFaturaCartaoCredito
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     * @param int $ensure_workday_dueDate
     * @return AsasFaturaCartaoCredito
     */
    public function setValue($value): AsasFaturaCartaoCredito
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param string $ensure_workday_dueDate
     * @return AsasFaturaCartaoCredito
     */
    public function setDescription($description): AsasFaturaCartaoCredito
    {
        $this->description = $description;
        return $this;
    }
    /**
     * @param string $billingType
     * @return AsasFaturaCartaoCredito
     */
    public function setBillingType($billingType): AsasFaturaCartaoCredito
    {
        $this->billingType = $billingType;
        return $this;
    }

    public function setFine(): AsasFaturaCartaoCredito
    {
        $this->fine = ['value'=>0.02];
        return $this;
    }
    public function setInterest(): AsasFaturaCartaoCredito
    {
        $this->interest = ['value'=>0.01];
        return $this;
    }






    /**
     * @param Collection $subitems
     * @return AsasFaturaCartaoCredito
     */
    public function setDiscount(Collection $discount): AsasFaturaCartaoCredito
    {
        foreach ($discount->toArray() as $item) {
            if (isset($item)) {
                $this->discount = (array)$item;
            }
        }

        return $this;
    }

    // /**
    //  * @param PaymentSubItem $subitem
    //  * @return AsasFaturaCartaoCredito
    //  */
    // public function addDiscount(PaymentSubItem $subitem): AsasFaturaCartaoCredito
    // {
    //     $this->discount[] = $subitem->toArray();
    //     return $this;
    // }

    /**
     * @param mixed $customer
     * @return AsasFaturaCartaoCredito
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }



    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }

    public function setDiscountFromFatura(Collection $items): self
    {
        $transformedItens = $items->transform(function ($item) {
            if ($item->valor < 0) {
                $item->dueDateLimitDays = 10;
                $item->value = '50%';
            }
            return new PaymentSubItem($item);
        });

        $this->setDiscount($transformedItens);
        return $this;
    }

    /**
     * @param string $externalReference
     * @return AsasFaturaCartaoCredito
     */
    public function setExternalReference($externalReference)
    {
        $this->externalReference = $externalReference;
    }

     /**
     * @param string $creditCardHolderInfo
     * @return AsasFaturaCartaoCredito
     */
    public function setCreditCardHolderInfo($creditCardHolderInfo)
    {
        $this->creditCardHolderInfo = $creditCardHolderInfo;
    }
     /**
     * @param string $creditCard
     * @return AsasFaturaCartaoCredito
     */
    public function setCreditCardToken($creditCard)
    {
        $this->creditCard = $creditCard;
    }
    
    
    
    

    public function setDiscountFromMovimentoContasReceber(Collection $items): self
    {



        $transformedItens = $items->transform(function ($item) {
            if ($item->valor < 0) {
                $item->dueDateLimitDays = 0;
                $item->value = $item->valor;
                $item->type = 'FIXED';

                return new PaymentSubItem($item);
            }
            // return new PaymentSubItem();

        });


        $this->setDiscount($transformedItens);
        return $this;
    }
}
