<?php

namespace App\Console\Commands;

use App\Models\Empresa;
use App\Notifications\ReminderSellNotification;
use App\Repositories\PosCadastroRepository;
use Illuminate\Console\Command;

class RemainderSellCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:sell';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia lembrete aos vendedores sobre vendas que nao assinaram o contrato.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(PosCadastroRepository $posCadastroRepository)
    {
        $posCadastroRepository
            ->getCompanyWithContractNotSignedBy(5)
            ->each(fn(Empresa $empresa) => $empresa->notify(new ReminderSellNotification()));

        $posCadastroRepository
            ->getCompanyWithContractNotSignedBy(7)
            ->each(function (Empresa $empresa) {
                $empresa->delete();
                $empresa->update(['status_id' => array_search('Desativada', Empresa::$status)]);
                $empresa->notify(new ReminderSellNotification('cancel'));
            });
    }
}
