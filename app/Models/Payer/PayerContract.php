<?php

namespace App\Models\Payer;

interface PayerContract
{
    public function getName(): ?string;

    public function getModelAlias(): string;

    public function plans();

    public function invoice();

    public function contasReceber();

    public function crm();
}
