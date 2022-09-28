<?php

namespace App\Services\Viabilidade;

use App\Models\DocumentosViabilidadeBase;

class SyncDocumentosBaseViabilidadeService
{
    public function execute(array $data)
    {
        $documentos = DocumentosViabilidadeBase::all();

        foreach ($data as $documento) {
            if (!$documentos->contains('name', strtoupper($documento))) {
                DocumentosViabilidadeBase::create(['name' => $documento]);
            }
        }
    }
}
