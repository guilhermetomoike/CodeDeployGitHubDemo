<?php

namespace App\Services\Empresa;

use App\Models\Empresa\AlvaraSanitario;

use App\Modules\ConvertBase64ToFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

class AlvarasSanitarioService
{
    public function getAllAlvaraSanitarios()
    {
        return AlvaraSanitario
            ::with('empresa')
            ->whereHas('empresa')
            ->get();
    }

    public function storeAlvaraSanitario(array $data)
    {
        if (AlvaraSanitario::query()->firstWhere('empresa_id', $data['empresa_id'])) {
            throw new InvalidArgumentException('O alvará Sanitario ja foi cadastrado para esta empresa', 422);
        }
        $alvara = AlvaraSanitario::query()->create($data);
        $this->uploadFile($alvara, $data['file']);
        return $alvara;
    }

    public function updateAlvaraSanitario(array $data, AlvaraSanitario $alvara)
    {
        $alvara->update($data);
        if (isset($data['file']) && !empty(($data['file']))) {
            $this->uploadFile($alvara, $data['file']);
        }
        return $alvara;
    }
    

    public function deleteAlvaraSanitario(AlvaraSanitario $alvara)
    {
        $alvara->delete();
    }

    public function getAlvaraSanitario(int $id)
    {
        return AlvaraSanitario::with('arquivo')->firstWhere('id', $id);
    }

    private function uploadFile($alvara, $file): void
    {
        $uploadedFile = ConvertBase64ToFile::run($file['base64']);
        $fileName = Str::random().'.pdf';
        Storage::disk('s3')->put($fileName, $uploadedFile);
        $alvara->arquivo()->updateOrCreate([
            'caminho' => $fileName,
            'nome_original' => $file['name'],
            'nome' => 'AlvaraSanitario'
        ]);
    }
}
