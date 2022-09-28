<?php

namespace App\Services\Viabilidade;

use App\Models\ViabilidadeMunicipal;
use App\Services\Viabilidade\SyncDocumentosBaseViabilidadeService;
use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CreateViabilidadeService
{
    private SyncDocumentosBaseViabilidadeService $syncService;

    public function __construct(SyncDocumentosBaseViabilidadeService $syncService)
    {
        $this->syncService = $syncService;
    }

    public function execute(array $data)
    {
        if (ViabilidadeMunicipal::where('cidade_id', $data['cidade_id'])->exists()) {
            throw new InvalidArgumentException('A viabilidade já foi cadastrada para esta cidade', 422);
        }

        $viabilidade = ViabilidadeMunicipal::create($data);

        if(isset($data['anexos']) && !empty($data['anexos'])) {
            (new CreateViabilidadeAnexoService)->execute($viabilidade, $data['anexos'],);
        }

        $this->syncService->execute($data['documentos_necessarios']);

        return $viabilidade;
    }
}
