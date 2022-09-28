<?php


namespace Modules\Invoice\Entities;


use InvalidArgumentException;

class InvoiceStatus
{
    const PAID = 'paid';
    const PARTIALLY_PAID = 'partially_paid';
    const PENDING = 'pending';
    const CANCELED = 'canceled';
    const REFUNDED = 'refunded';
    const EXPIRED = 'expired';

    protected array $types = [
        self::PAID => 'Pago',
        self::PARTIALLY_PAID => 'Pago',
        self::PENDING => 'Pendente',
        self::CANCELED => 'Cancelado',
        self::REFUNDED => 'Reembolsado',
        self::EXPIRED => 'Expirado',
    ];

    protected ?string $value = null;

    public function __construct(?string $type)
    {
        if (!array_key_exists($type, $this->types)) {
            throw new InvalidArgumentException('Status inválido.');
        }
        $this->value = $type;
    }

    public function value()
    {
        return $this->value;
    }

    public function valueType()
    {
        return strtolower($this->types[$this->value]);
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
        return $this->types[$this->value];
    }
}
