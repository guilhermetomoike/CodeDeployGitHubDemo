<?php

namespace App\Console\Commands;

use App\Models\Cliente;
use App\Notifications\IrpfPushNotification;
use Illuminate\Console\Command;

class IrpfNotificationsCommand extends Command
{
    protected $signature = 'irpf:notifications';
    protected $description = 'Send IRPF notifications to customers';

    public function handle()
    {
        $requiredPendencies = fn($customer) => $this->getRequiredPendencies($customer);
        $sentPendencies = fn($customer) => $this->getSentPendencies($customer);
        $diffPendencies = fn($requiredPendencies, $sentPendencies) => $this->getDiffPendencies($requiredPendencies, $sentPendencies);
        $checkDiffPendencies = fn($customer) => $diffPendencies($requiredPendencies($customer), $sentPendencies($customer))
            ->filter(fn($item, $key) => ($sentPendencies($customer)[$key]['quantidade'] ?? 0) < $item['quantidade']);
        $customersDidNotSendPendencies = fn($customer) => !(
            $requiredPendencies($customer)->count() <= $sentPendencies($customer)->count() &&
            !$checkDiffPendencies($customer)->count()
        );

        Cliente
            ::query()
            ->with([
                'irpf' => function($query) {
                    $query->where('ano', now()->subYear()->year);
                },
                'irpf.resposta',
                'irpf.resposta.pendencia',
                'irpf.pendencias',
            ])
            ->whereHas('irpf.resposta')
            ->get()
            ->filter(fn($customer) => $customer->irpf && $customer->irpf->resposta)
            ->filter($customersDidNotSendPendencies)
            ->each(function ($customer) {
                $customer->notify(new IrpfPushNotification());
            });
    }

    private function getRequiredPendencies($customer)
    {
        return $customer
            ->irpf
            ->resposta
            ->filter(fn($resposta) => $resposta->resposta)
            ->map(fn($resposta) => [
                'id' => $resposta->pendencia->id,
                'quantidade' => (int)$resposta->quantidade,
            ])
            ->sortBy('id')
            ->values();
    }

    private function getSentPendencies($customer)
    {
        return $customer
            ->irpf
            ->pendencias
            ->filter(fn($pendency) => collect($pendency->inputs)->contains(fn($item) => ($item['value'] ?? false)))
            ->map(fn($pendency) => $pendency->irpf_pendencia_id)
            ->groupBy(fn($value) => $value)
            ->map(fn($pendency) => [
                'id' => $pendency[0],
                'quantidade' => $pendency->count(),
            ])
            ->sortBy('id')
            ->values();
    }

    private function getDiffPendencies($requiredPendencies, $sentPendencies)
    {
        return $requiredPendencies
            ->map(fn($item) => serialize($item))
            ->diffAssoc($sentPendencies->map(fn($item) => serialize($item)))
            ->map(fn($value) => unserialize($value));
    }
}
