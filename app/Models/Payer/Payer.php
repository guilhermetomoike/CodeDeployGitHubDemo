<?php

namespace App\Models\Payer;

use App\Models\Crm;
use App\Models\Nfse\Nfse;
use Carbon\Carbon;
use Modules\Invoice\Entities\ContasReceber;
use Modules\Invoice\Entities\Fatura;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Modules\Invoice\Entities\FaturaSaldo;
use Modules\Plans\Entities\Plan;

trait Payer
{
    public function getName(): ?string
    {
        return $this->{self::$payer_name_column ?? 'name'} ?? $this->nome_completo;
    }

    public function getModelAlias(): string
    {
        return Str::singular($this->getTable());
    }

    public function fatura()
    {
        return $this->morphMany(Fatura::class, 'payer');
    }

    public function invoice()
    {
        return $this->morphMany(Fatura::class, 'payer');
    }

    public function plans(): BelongsToMany
    {
        return $this->morphToMany(Plan::class, 'payer', 'plan_subscriptions')
            ->wherePivotNull('deleted_at');
    }

    public function saldo()
    {
        return $this->morphMany(FaturaSaldo::class, 'payer');
    }

    public function nfse()
    {
        $key = $this->getModelAlias() === 'empresa' ? 'cnpj' : 'cpf';

        return $this->hasMany(Nfse::class, 'tomador', $key);
    }

    public function contasReceber()
    {    $mes= Carbon::now()->setDay(20)->format('Y-m-d');
        return $this->morphMany(ContasReceber::class, 'payer')->where('vencimento',$mes);
    }

    public function contasRecebern()
    {
  
        return $this->morphMany(ContasReceber::class, 'payer')
        ->where('vencimento', '>=', '2022-05-20')
        ->where('vencimento', '<=', '2022-08-20')
            ->whereNull('consumed_at');;
    }


    public function crm()
    {
        return $this->morphOne(Crm::class, 'owner');
    }
}
