<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invite extends Model
{
    use SoftDeletes;

    const STATUS_RECEBIDO = 'recebido';
    const STATUS_CONVIDADO = 'convidado';
    const STATUS_CONFIRMADO = 'confirmado';

    const STATUS = [
        self::STATUS_RECEBIDO,
        self::STATUS_CONVIDADO,
        self::STATUS_CONFIRMADO,
    ];

    protected $fillable = [
        'customer_id',
        'customer_email',
        'customer_cpf',
        'invitee_email',
        'invitee_name',
        'invitee_cpf',
        'invitee_phone',
        'ploomes_id',
        'ploomes_deal_id',
        'status',
    ];

    protected $with = [
        'customer',
    ];

    public function customer()
    {
        return $this->belongsTo(Cliente::class, 'customer_id');
    }

    public function getCustomer()
    {
        return $this->belongsTo(Cliente::class, 'customer_id')->first();
    }

    public function convidado()
    {
        $this->status = self::STATUS_CONVIDADO;
        $this->save();
    }

    public function confirmado()
    {
        $this->status = self::STATUS_CONFIRMADO;
        $this->save();
    }

    public function recebido()
    {
        $this->status = self::STATUS_RECEBIDO;
        $this->save();
    }
}
