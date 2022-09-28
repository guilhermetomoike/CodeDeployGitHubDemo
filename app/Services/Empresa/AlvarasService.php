<?php

namespace App\Services\Empresa;

use App\Models\Empresa\Alvara;
use App\Modules\ConvertBase64ToFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

class AlvarasService
{
    public function getAllAlvaras()
    {
        return Alvara
            ::with('empresa')
            ->whereHas('empresa')
            ->get();
    }

    public function storeAlvara(array $data)
    {
        if (Alvara::query()->firstWhere('empresa_id', $data['empresa_id'])) {
            throw new InvalidArgumentException('O alvará ja foi cadastrado para esta empresa', 422);
        }
        $alvara = Alvara::query()->create($data);
        $this->uploadFile($alvara, $data['file']);
        return $alvara;
    }

    public function updateAlvara(array $data, Alvara $alvara)
    {
        $alvara->update($data);
        if (isset($data['file']) && !empty(($data['file']))) {
            $this->uploadFile($alvara, $data['file']);
        }
        return $alvara;
    }

    public function deleteAlvara(Alvara $alvara)
    {
        $alvara->delete();
    }

    public function getAlvara(int $id)
    {
        return Alvara::with('arquivo')->firstWhere('id', $id);
    }

    private function uploadFile($alvara, $file): void
    {
        $uploadedFile = ConvertBase64ToFile::run($file['base64']);
        $fileName = Str::random().'.pdf';
        Storage::disk('s3')->put($fileName, $uploadedFile);
        $alvara->arquivo()->updateOrCreate([
            'caminho' => $fileName,
            'nome_original' => $file['name'],
            'nome' => 'Alvara'
        ]);
    }
}
