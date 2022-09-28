<?php

namespace App\Console\Commands;

use App\Jobs\GenerateInviteDiscountJob;
use App\Repositories\InviteRepository;
use App\Services\ContatoService;
use Illuminate\Console\Command;

class InviteDiscountCommand extends Command
{
    protected $name = 'invite:make-discount';

    protected $description = 'Gera descontos nas contas a receber dos clientes que indicaram.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(InviteRepository $inviteRepository, ContatoService $contatoService)
    {
        $invites = $inviteRepository->getAllConfirmedInvites();

        foreach ($invites as $invite) {
            $company = $invite->customer->empresa->first();
            $invitee = $contatoService->getByValue($invite->invitee_email) ? $contatoService->getByValue($invite->invitee_email)->responsavel : null;

            if ($company) GenerateInviteDiscountJob::dispatch($company, $invite);
            if ($invitee) GenerateInviteDiscountJob::dispatch($invitee, $invite);
        }
    }
}
