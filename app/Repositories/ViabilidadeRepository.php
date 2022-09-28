<?php

namespace App\Repositories;

use App\Models\ViabilidadeMunicipal;

class ViabilidadeRepository
{
    public function getFromUpdatedAt(string $updated_at)
    {
        return ViabilidadeMunicipal::query()
            ->where('updated_at', '<', $updated_at)
            ->get();
    }
}
