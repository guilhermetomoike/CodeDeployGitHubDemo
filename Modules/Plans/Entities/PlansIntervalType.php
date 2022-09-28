<?php


namespace Modules\Plans\Entities;


use InvalidArgumentException;
use Stringable;

class PlansIntervalType implements Stringable
{
    const DAILY = 'daily';
    const WEEKLY = 'weekly';
    const MONTHLY = 'monthly';

    protected array $types = [
        self::DAILY => 'Calculada por dia',
        self::WEEKLY => 'Semanal',
        self::MONTHLY => 'Mensal',
    ];

    protected ?string $value = null;

    public function __construct(?string $type)
    {
        if (!array_key_exists($type, $this->types)) {
            throw new InvalidArgumentException('Intervalo de cobrança inválido inválida.');
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
