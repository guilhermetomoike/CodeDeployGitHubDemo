<?php

namespace App\Services\Empresa;

use App\Models\Empresa\Taxas;

use App\Modules\ConvertBase64ToFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

class TaxasService
{
    public function getAllTaxas()
    {
        return Taxas
            ::with('empresa')
            ->whereHas('empresa')
            ->get();
    }

    public function storeTaxas(array $data)
    {
     
        foreach ($data as $key => $value) {
      
            $taxas[] = Taxas::query()->create($value);
            // $this->uploadFile($taxas, $value['file']);
        }
    
        return $taxas;
    }

    public function updateTaxas(array $data, Taxas $taxas)
    {
        foreach ($data as $key => $value) {
           
        $taxas->update($value);
        if (isset($data[$key]['file']) && !empty(($data[$key]['file']))) {
            // $this->uploadFile($taxas, $data[$key]['file']);
        }
        }
        return $taxas;
    }
    

    // public function deleteTaxas(Taxas $taxas)
    // {

    //     $taxas->delete();
    // }

    public function getTaxas(int $id)
    {
        return Taxas::with('arquivo')->where('document_id', $id)->get();
    }

    private function uploadFile($taxas, $file): void
    {
        $uploadedFile = ConvertBase64ToFile::run($file['base64']);
        $fileName = Str::random().'.pdf';
        Storage::disk('s3')->put($fileName, $uploadedFile);
        $taxas->arquivo()->updateOrCreate([
            'caminho' => $fileName,
            'nome_original' => $file['name'],
            'nome' => 'Taxas'
        ]);
    }
}
