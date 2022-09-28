<?php


namespace App\Services\Recebimento\Gatway\Iugu\Common;


use Illuminate\Support\Collection;

class IuguFatura
{
    public string $email;
    public string $due_date;
    public bool $ensure_workday_due_date = true;
    public array $items = [];
    public string $customer_id;
    public string $payable_with = 'all';
    public bool $fines = true; // multas por atraso
    public string $notification_url;

    public static function build()
    {
        return new static();
    }

    /**
     * @param $email
     * @return IuguFatura
     */
    public function setEmail($email)
    {
        abort_if((is_countable($email) && !count($email)) || !$email,
            400,
            'Nenhum email cadastrado para este cliente.'
        );
        if (is_countable($email)) {
            $this->email = $email[0];
        } else {
            $this->email = $email;
        }
        return $this;
    }

    /**
     * @param mixed $due_date
     * @return IuguFatura
     */
    public function setDueDate($due_date)
    {
        $this->due_date = $due_date;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnsureWorkdayDueDate(): bool
    {
        return $this->ensure_workday_due_date;
    }

    /**
     * @param bool $ensure_workday_due_date
     * @return IuguFatura
     */
    public function setEnsureWorkdayDueDate(bool $ensure_workday_due_date): IuguFatura
    {
        $this->ensure_workday_due_date = $ensure_workday_due_date;
        return $this;
    }

    /**
     * @param Collection $subitems
     * @return IuguFatura
     */
    public function setItems(Collection $subitems): IuguFatura
    {
        $this->items = $subitems->toArray();
        return $this;
    }

    /**
     * @param PaymentSubItem $subitem
     * @return IuguFatura
     */
    public function addItem(PaymentSubItem $subitem): IuguFatura
    {
        $this->items[] = $subitem->toArray();
        return $this;
    }

    /**
     * @param mixed $customer_id
     * @return IuguFatura
     */
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
        return $this;
    }

    /**
     * @param string $payable_with
     * @return IuguFatura
     */
    public function setPayableWith(string $payable_with): IuguFatura
    {
        $this->payable_with = $payable_with;
        return $this;
    }

    /**
     * @param bool $fines
     * @return IuguFatura
     */
    public function setFines(bool $fines): IuguFatura
    {
        $this->fines = $fines;
        return $this;
    }

    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }

    public function setItemsFromFatura(Collection $items): self
    {
        $transformedItens = $items->transform(function ($item) {
            $item->recurrent = false;
            $item->preco = $item->valor;
            return new PaymentSubItem($item);
        });

        $this->setItems($transformedItens);
        return $this;
    }

    public function setItemsFromMovimentoContasReceber(Collection $items): self
    {
        $transformedItens = $items->transform(function ($item) {
            $item->recurrent = false;
            $item->preco = $item->valor;
            return new PaymentSubItem($item);
        });

        $this->setItems($transformedItens);
        return $this;
    }

    /**
     * @param string $notification_url
     * @return IuguFatura
     */
    public function setNotificationUrl(string $notification_url): IuguFatura
    {
        $this->notification_url = $notification_url;
        return $this;
    }


}
