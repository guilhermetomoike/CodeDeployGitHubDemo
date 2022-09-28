<?php


namespace Modules\Plans\Entities;


use InvalidArgumentException;
use Stringable;

class PlansPayableWith implements Stringable
{
    const ALL = 'all';
    const CREDIT_CARD = 'credit_card';
    const BANK_SLIP = 'bank_slip';

    protected array $types = [
        self::ALL => 'Cartão/Boleto',
        self::CREDIT_CARD => 'Cartão de Crédito',
        self::BANK_SLIP => 'Boleto Bancário',
    ];

    protected ?string $value = null;

    public function __construct(?string $type)
    {
        if (!array_key_exists($type, $this->types)) {
            throw new InvalidArgumentException('Forma de pagamento inválida.');
        }
        $this->value = $type;
    }

    public function value()
    {
        return $this->value;
    }

    public function is(string $status)
    {
        return $this->value === $status;
    }

    public static function all()
    {
        return (new \ReflectionClass(self::class))->getConstants();
    }

    public function __toString()
    {
        return $this->types[$this->value()];
    }
}
