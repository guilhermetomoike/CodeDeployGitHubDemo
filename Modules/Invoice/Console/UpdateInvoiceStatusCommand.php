<?php

namespace Modules\Invoice\Console;

use Illuminate\Console\Command;
use Modules\Invoice\Entities\Fatura;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateInvoiceStatusCommand extends Command
{
    protected $name = 'invoice:update-status';

    protected $description = 'Atualiza status das faturas.';

    public function handle()
    {
        Fatura::query()
            ->where('status', 'processando')
            ->where('updated_at', '<', now()->subDays(2))
            ->update(['status' => 'pago']);

        Fatura::query()
            ->where('status', 'pendente')
            ->where('data_vencimento', '<', today()->subDays(2))
            ->update(['status' => 'atrasado']);
    }

}
