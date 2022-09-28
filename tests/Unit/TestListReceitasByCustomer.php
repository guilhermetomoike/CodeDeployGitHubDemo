<?php

namespace Tests\Unit;

use App\Services\File\FileService;
use App\Services\ReceitaService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\InteractsWithTime;
use Tests\TestCase;

class TestListReceitasByCustomer extends TestCase
{
    use InteractsWithTime;

    public function testListReceitasByCustomer()
    {
        $receitaService = new ReceitaService(new FileService());
        $receitaService->getYearlyByCustomer(74);
    }

    public function testStoreHoleriteWithFile()
    {
        Storage::fake('s3');
        $file = file_get_contents(base_path('/tests/stubs/test.png'));
        $file = ['name' => 'upload.png', 'base64' => 'data:image/png;base64,' . base64_encode($file),];
        $file = ['file' => $file,];

        $receitaService = new ReceitaService(new FileService());

        $dataSet = [
            'cnpj' => '1231231231',
            'inss' => '120',
            'irrf' => '25',
            'prolabore' => '1500',
            'cliente_id' => 74,
            'data_competencia' => competencia_anterior()
        ];
        $receita = $receitaService->storeHolerite($dataSet + $file);

        $this->assertDatabaseHas('receitas', $dataSet);

        Storage::disk('s3')->assertExists($receita->arquivo->caminho);
    }
}
