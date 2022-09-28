<?php

namespace App\Services\Recebimento\Gatway\Asas\Common;

class PaymentSubItem
{
    // public $description;
    public string $type;
    public $value;
    public $dueDateLimitDays = 0;
    // public $recurrent = false;

    /**
     * PaymentSubItem constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if ($item) {
            $this->build($item);
        }
    }

    private function build($item)
    {
        $this->setDueDateLimitDays($item->dueDateLimitDays ?? 0)
        ->setType($item->type)
            ->setValue($item->valor);
          
    }


    /**
     * @param mixed $value
     * @return PaymentSubItem
     */
    public function setValue($value)
    {
        $this->value = (int)(abs($value));
        return $this;
    }
   

    /**
     * @param mixed $dueDateLimitDays
     * @return PaymentSubItem
     */
    public function setDueDateLimitDays(?int $dueDateLimitDays)
    {
        $this->dueDateLimitDays = $dueDateLimitDays ?? 0;
        return $this;
    }
    
  /**
     * @param mixed $type
     * @return PaymentSubItem
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'type' => $this->type,
            'dueDateLimitDays' => $this->dueDateLimitDays,
           
        ];
    }

}
