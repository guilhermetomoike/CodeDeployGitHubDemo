<?php


namespace App\Services\Nfse\Contracts;

use App\Services\Nfse\Plugnotas\Common\Nfse;

interface ApiNfse
{
    public function emitir(Nfse $nfse);

    /**
     * Informar o id da nota na integração
     * @param string $nfse_id
     * @return mixed
     */
    public function cancelar(string $nfse_id);
}