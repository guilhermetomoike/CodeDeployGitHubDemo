<?php

namespace App\Services\Empresa;

use App\Models\Empresa\Coworking;

use App\Modules\ConvertBase64ToFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

class CoworkingService
{
    public function getAllCoworkings()
    {
        return Coworking
            ::with('empresa')
            ->whereHas('empresa')
            ->get();
    }

    public function storeCoworking(array $data)
    {
        if (Coworking::query()->firstWhere('empresa_id', $data['empresa_id'])) {
            throw new InvalidArgumentException('O alvará Coworking ja foi cadastrado para esta empresa', 422);
        }
        $alvara = Coworking::query()->create($data);
        $this->uploadFile($alvara, $data['file']);
        return $alvara;
    }

    public function updateCoworking(array $data, Coworking $alvara)
    {
        $alvara->update($data);
        if (isset($data['file']) && !empty(($data['file']))) {
            $this->uploadFile($alvara, $data['file']);
        }
        return $alvara;
    }

    public function deleteCoworking(Coworking $alvara)
    {
        $alvara->delete();
    }

    public function getCoworking(int $id)
    {
        return Coworking::with('arquivo')->firstWhere('id', $id);
    }

    private function uploadFile($alvara, $file): void
    {
        $uploadedFile = ConvertBase64ToFile::run($file['base64']);
        $fileName = Str::random().'.pdf';
        Storage::disk('s3')->put($fileName, $uploadedFile);
        $alvara->arquivo()->updateOrCreate([
            'caminho' => $fileName,
            'nome_original' => $file['name'],
            'nome' => 'Coworking'
        ]);
    }
}
