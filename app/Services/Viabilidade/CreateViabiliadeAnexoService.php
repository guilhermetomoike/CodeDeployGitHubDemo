<?php

namespace App\Services\Viabilidade;

use App\Models\ViabilidadeMunicipal;

class CreateViabilidadeAnexoService
{
    public function execute(ViabilidadeMunicipal $viabilidade, ?array $anexos) 
    {
        if ($anexos) {
            foreach ($anexos as $arquivo) {
                $viabilidade->addArquivo($arquivo['arquivo_id'], $arquivo['nome']);
            }
        }
    }
}