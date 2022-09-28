<?php

namespace Modules\Invoice\Console;


use Illuminate\Console\Command;
use Modules\Invoice\Repositories\RotinasFinanRepository;

class GenerateAddcionaisCommand extends Command
{
    protected $name = 'financeiro:addionais-generate';

    protected $description = 'Command for generate all recurrent invoices for the month.';

    public function handle(RotinasFinanRepository $rotinasFinanRepository)
    {
           $rotinasFinanRepository->createAdicionaisContasReceber();
    }
}
