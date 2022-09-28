<?php


namespace Modules\Invoice\Repositories;


use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Invoice\Entities\Fatura;

class InvoiceRepository
{
    public function findByPayer(string $payer_type, int $payer_id, ?string $status = null)
    {
        return Fatura::query()
            ->when($status, function ($builder, $status) {
                $builder->where('status', $status);
            })
            ->where('payer_type', $payer_type)
            ->where('payer_id', $payer_id)
            ->get();
    }

    public function findByPayerAtrasada(string $payer_type, int $payer_id)
    {
        return Fatura::query()
            ->where('status','atrasado')
            ->where('payer_type', $payer_type)
            ->where('payer_id', $payer_id)
            ->get();
    }

    public function deleteInvoiceCanceledBeforeThat(string $updated_at)
    {
        return Fatura::query()
            ->whereIn('status', ['cancelado'])
            ->where('updated_at', '<', $updated_at)
            ->delete();
    }
}
