<?php

namespace App\Services;

use App\Mail\SendFilesMail;
use App\Models\Arquivo;
use App\Models\Empresa;
use App\Models\Upload;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ArquivoService
{

    public function getAll(array $data)
    {
        $modelType = $data['model_type'];
        $modelId = $data['model_id'];
        $type = $data['type'] ?? '';

        $arquivos = Arquivo::query()
            ->where('model_type', $modelType)
            ->where('model_id', $modelId)
            ->get();

        if ($modelType === 'empresa' && $type !== '' && $type !== 'empresa') {
            $arquivosDaEmpresa = $this->getArquivosByEmpresa($modelId, $type);

            if ($type !== 'all') {
                return $arquivosDaEmpresa;
            }

            $arquivos = $arquivos->concat($arquivosDaEmpresa);
        }

        return $arquivos;
    }

    private function getArquivosByEmpresa(int $modelId, string $type)
    {
        $empresa = Empresa::query()->find($modelId);

        if (!$empresa) {
            return [];
        }

        $arquivos = collect([]);
        $types = [
            'alvara' => $empresa->alvara(),
            'residencia_medica' => $empresa->residencia_medica(),
            'contrato' => $empresa->contrato(),
        ];

        if ($type === 'all') {
            foreach ($types as $item) {
                $arquivos = $arquivos->concat($this->getArquivosOnCollection($item));
            }
        } else {
            $item = $types[$type] ?? null;
            $arquivos = $arquivos->concat($this->getArquivosOnCollection($item));
        }

        return $arquivos;
    }

    private function getArquivosOnCollection($model)
    {
        if (!$model) {
            return collect([]);
        }

        return $model
            ->with('arquivo')
            ->get()
            ->filter(function ($model) {
                return $model->arquivo !== null;
            })
            ->map(function ($model) {
                return $model->arquivo;
            });
    }

    public function sendFilesByEmail(array $files, string $email)
    {
        $arquivos = Arquivo
            ::query()
            ->whereIn('id', $files)
            ->get();

        Mail::send(new SendFilesMail($email, $arquivos));
    }

    public function addClassFile(int $model_id, $model_class, $file_id, string $name = null)
    {
        $arquivo = Arquivo::find($file_id);
        $model = new $model_class;

        $arquivo->fill([
            'model_type' => $model->getMorphClass(),
            'model_id' => $model_id,
            'nome' => $name
        ]);
        $arquivo->save();

        return $arquivo;
    }

    public function create(array $data)
    {
        $uploadedFile = $data['arquivo'];
        $data['nome_original'] = $uploadedFile->getClientOriginalName();
        $data['caminho'] = $uploadedFile->store(null);
        $data['tamanho'] = $uploadedFile->getSize();
        $data['mime_type'] = $uploadedFile->getMimetype();
        return Arquivo::create($data);
    }

    public function createToUploadList(array $data)
    {
        $files = [];
        foreach ($data['files'] as $item) {
            $path = Storage::disk('s3')->put(null, $item);
            $files[] = Upload::query()->create([
                'label' => $data['label'],
                'name' => $item->getClientOriginalName(),
                'path' => $path,
            ]);
        }
        return $files;
    }
}
