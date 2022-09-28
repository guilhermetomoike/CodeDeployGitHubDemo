<?php

namespace App\Observers;

use App\Models\Nfse\TomadorNfse;
use App\Services\Nfse\Common\Tomador\Tomador;
use App\Services\Nfse\NfseService;
use App\Services\Nfse\Plugnotas\PlugnotasService;

class TomadorNfseOberserver
{
    /**
     * Handle the tomador nfse "created" event.
     *
     * @param TomadorNfse $tomadorNfse
     * @return void
     */
    public function created(TomadorNfse $tomadorNfse)
    {
        $response = (new NfseService)->cadastraTomadorApi($tomadorNfse);

        if ($response) {
            $tomadorNfse->update(['tem_cadastro_plugnotas' => 1]);
        }
    }

    /**
     * Handle the tomador nfse "updated" event.
     *
     * @param TomadorNfse $tomadorNfse
     * @return void
     */
    public function updated(TomadorNfse $tomadorNfse)
    {
        //
    }

    /**
     * Handle the tomador nfse "deleted" event.
     *
     * @param TomadorNfse $tomadorNfse
     * @return void
     */
    public function deleted(TomadorNfse $tomadorNfse)
    {
        //
    }

    /**
     * Handle the tomador nfse "restored" event.
     *
     * @param TomadorNfse $tomadorNfse
     * @return void
     */
    public function restored(TomadorNfse $tomadorNfse)
    {
        //
    }

    /**
     * Handle the tomador nfse "force deleted" event.
     *
     * @param TomadorNfse $tomadorNfse
     * @return void
     */
    public function forceDeleted(TomadorNfse $tomadorNfse)
    {
        //
    }
}
