<?php

namespace App\Services\Empresa;

use App\Models\Empresa\Bombeiro;

use App\Modules\ConvertBase64ToFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

class BombeiroService
{
    public function getAllBombeiros()
    {
        return Bombeiro
            ::with('empresa')
            ->whereHas('empresa')
            ->get();
    }

    public function storeBombeiro(array $data)
    {
        if (Bombeiro::query()->firstWhere('empresa_id', $data['empresa_id'])) {
            throw new InvalidArgumentException('O alvará Bombeiro ja foi cadastrado para esta empresa', 422);
        }
        $alvara = Bombeiro::query()->create($data);
        $this->uploadFile($alvara, $data['file']);
        return $alvara;
    }

    public function updateBombeiro(array $data, Bombeiro $alvara)
    {
        $alvara->update($data);
        if (isset($data['file']) && !empty(($data['file']))) {
            $this->uploadFile($alvara, $data['file']);
        }
        return $alvara;
    }

    public function deleteBombeiro(Bombeiro $alvara)
    {
        $alvara->delete();
    }

    public function getBombeiro(int $id)
    {
        return Bombeiro::with('arquivo')->firstWhere('id', $id);
    }

    private function uploadFile($alvara, $file): void
    {
        $uploadedFile = ConvertBase64ToFile::run($file['base64']);
        $fileName = Str::random().'.pdf';
        Storage::disk('s3')->put($fileName, $uploadedFile);
        $alvara->arquivo()->updateOrCreate([
            'caminho' => $fileName,
            'nome_original' => $file['name'],
            'nome' => 'Bombeiro'
        ]);
    }
}
