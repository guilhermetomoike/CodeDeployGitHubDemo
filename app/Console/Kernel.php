<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Invoice\Console\ChargeInvoiceWithCreditCardCommand;
use Modules\Invoice\Console\DeleteCanceledInvoicesCommand;
use Modules\Invoice\Console\GenerateInvoiceCartaoCommand;
use Modules\Invoice\Console\GenerateInvoiceCommand;
use Modules\Invoice\Console\MakeContasReceberCommand;
use Modules\Invoice\Console\UpdateInvoiceStatusCommand;
use Modules\Invoice\Console\UpdatePlanosCommanad;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        DeleteCanceledInvoicesCommand::class,
        GenerateInvoiceCommand::class,
        ChargeInvoiceWithCreditCardCommand::class,
        UpdateInvoiceStatusCommand::class,
        MakeContasReceberCommand::class,
        UpdatePlanosCommanad::class,
        GenerateInvoiceCartaoCommand::class
    ];

    protected function schedule(Schedule $schedule)
    {
        // libera guias que nao precisam de honorario (sem cobranca ou pag por cartao credito)
        $schedule->command('liberacao:financeiro')->dailyAt('19:45')->onOneServer()->withoutOverlapping();
        // libera para envio empresas que ja possuem pelomenos 1 guia de cada setor
        $schedule->command('liberacao:guia')->dailyAt('19:50')->onOneServer()->withoutOverlapping();
        // envia email e notifica whatsapp das empresas liberadas
        // $schedule->command('send:guias')->dailyAt('20:00')->onOneServer()->withoutOverlapping();
       

        // Ajusta planos e contas a receber ja geradas 
        $schedule->command('financeiro:update-planos')->monthlyOn(1)->onOneServer()->withoutOverlapping();
        // gera contas a receber dos clientes pagantes
        $schedule->command('financeiro:make-contas-receber')->monthlyOn(2)->onOneServer()->withoutOverlapping();
        // gera descontos por indicações para contas a receber dos clientes pagantes
        $schedule->command('invite:make-discount')->monthlyOn(3)->onOneServer()->withoutOverlapping();
        // gera adicionais socios, funcionario e faturamento  para contas a receber dos clientes pagantes
        $schedule->command('financeiro:addionais-generate')->monthlyOn(3)->onOneServer()->withoutOverlapping();
        // gera faturas dos clientes pagantes
        $schedule->command('financeiro:invoice-generate')->monthlyOn(4)->onOneServer()->withoutOverlapping();
        // gera faturas do cartao credito dos clientes pagantes
        $schedule->command('financeiro:invoice-cartao-generate')->monthlyOn(11)->onOneServer()->withoutOverlapping();

        // atualiza para 'atrasado' as faturas pendentes ou com comprovante que nao foram baixadas
        $schedule->command('invoice:update-status')->daily()->onOneServer()->withoutOverlapping();

        // libera prolabore de empresas no lucro presumido
        $schedule->command('prolabore:presumido')->monthlyOn(20)->onOneServer()->withoutOverlapping();
        // elimina nfse rejeitadas
        $schedule->command('remove-nfse-rejeitada')->monthly()->onOneServer();
        // elimina faturas canceladas a mais de 15 dias
        $schedule->command('clean:invoice')->daily()->onOneServer();

        $schedule->command('horizon:snapshot')->daily()->onOneServer();
        // cria OS de viabilidades atualizadas a mais de 1 mes
        //        $schedule->command('viabilidade:renovar')->monthlyOn(10)->onOneServer();

        $schedule->command('freeze:company')->dailyAt('01:10')->onOneServer();
        $schedule->command('block:company')->dailyAt('01:00')->onOneServer();
        $schedule->command('reminder:sell')->dailyAt('07:00')->onOneServer()->withoutOverlapping();

        // Send IRPF notifications to customers
        // $schedule->command('irpf:notifications')->dailyAt('12:00')->onOneServer();

        $schedule->command('activity:run')->cron('0 3 * * 1-5')->onOneServer();
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
