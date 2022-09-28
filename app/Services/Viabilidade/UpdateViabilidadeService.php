<?php

namespace App\Services\Viabilidade;

use App\Models\ViabilidadeMunicipal;
use App\Services\Viabilidade\SyncDocumentosBaseViabilidadeService;

class UpdateViabilidadeService
{
    private SyncDocumentosBaseViabilidadeService $syncService;

    public function __construct(SyncDocumentosBaseViabilidadeService $syncService)
    {
        $this->syncService = $syncService;
    }

    public function execute(int $id, array $data)
    {
        $viabilidade = ViabilidadeMunicipal::find($id);

        if(isset($data['anexos']) && !empty($data['anexos'])) {
            (new CreateViabilidadeAnexoService)->execute($viabilidade, $data['anexos']);
        }

        $this->syncService->execute($data['documentos_necessarios']);

        $viabilidade->fill($data)->save();

        return $viabilidade;
    }
}
