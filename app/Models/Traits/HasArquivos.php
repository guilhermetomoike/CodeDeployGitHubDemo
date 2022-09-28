<?php

namespace App\Models\Traits;

use App\Models\Arquivo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasArquivos
{
    public function arquivos(): MorphMany
    {
        return $this->morphMany(Arquivo::class, 'model');
    }

    public function arquivo(): MorphOne
    {
        return $this->morphOne(Arquivo::class, 'model');
    }

    public function addArquivo(int $arquivoId, string $nome = null, array $tags = []): void
    {
        $arquivo = Arquivo::query()->find($arquivoId);
        if (!is_null($nome)) {
            $arquivo->nome = $nome;
        }
        if (!is_null($nome)) {
            $arquivo->tags = array_merge((array)$arquivo->tags ?? [], $tags);
        }
        $arquivo->save();
        $this->arquivos()->save($arquivo);
    }

    public function updateArquivo(int $newArquivoId, string $arquivoNome, array $tags = []): void
    {
        $this->deleteArquivo($arquivoNome);

        $this->addArquivo($newArquivoId, $arquivoNome, $tags);
    }

    public function deleteArquivo(string $arquivoNome): void
    {
        try {
            $this->arquivos()->byNome($arquivoNome)->delete();
        } catch (\Exception $e) { }
    }
}
