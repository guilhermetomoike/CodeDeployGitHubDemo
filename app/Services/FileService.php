<?php

namespace App\Services;

use App\Models\EmpresaArquivo;
use App\Models\FileDB;
use App\Models\OrdemServico\OrdemServicoAtividade;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FileService extends Service
{
    private $local;

    public function __construct()
    {
        $this->local = env('LOCAL_SAVE_FILES', 'grupobfiles');
    }

    // DIRETORIES
    public function getDirectories($directory = ''): array
    {
        $caminhoComp = $this->local . '/' . $directory;
        $directories = collect(Storage::disk()->directories($caminhoComp));
        $files = collect(Storage::disk()->files($caminhoComp));

        $map = [
            'directories' => $directories,
            'files' => [],
        ];

        $directories->each(function ($item) use (&$map) {
            $map['directories'][] = substr(strrchr($item, "/"), 1);
        });

        $files->each(function ($item) use (&$map) {
            $caminho = substr(strrchr($item, "/"), 1);

            $map['files'][] = $caminho;
        });

        return $map;
    }

    public function deleteDiretory($diretory)
    {
        $caminhoComp = (string)$this->local . '/' . $diretory;

        FileDB::where('caminho', "{$caminhoComp}%")->delete();

        Storage::deleteDirectory($caminhoComp);
    }

    public function createDiretory($diretory, $nome)
    {
        $caminhoComp = (string)$this->local . '/' . $diretory . '/' . $nome;

        Storage::makeDirectory($caminhoComp);
    }

    // FILES
    public function getFile(EmpresaArquivo $empresaArquivo)
    {
        $path = "grupobfiles/empresas/{$empresaArquivo->empresa_id}/{$empresaArquivo->pasta}/{$empresaArquivo->nome}";

        if (!Storage::disk()->exists($path)) {
            throw new HttpException(404, 'Arquivo não encontrado!');
        }

        return new File(base_path($path));
    }

    public function deleteFile($fileCaminho): bool
    {
        return Storage::disk()->delete($fileCaminho);
    }

    public function saveFile($diretory, UploadedFile $file, $nome): bool
    {
        $caminhoComp = $this->local . '/' . $diretory;

        return $file->storeAs($caminhoComp, $nome);
    }

    public function storeResidenciaMedica(UploadedFile $file, int $empresa_id, int $cliente_id)
    {
        $pasta_cliente = "{$this->local}/clientes/{$cliente_id}/comprovante-residencia-medica";
        $pasta_empresa = "{$this->local}/empresas/{$empresa_id}/comprovante-residencia-medica";
        $nome_arquivo = str_random(10). '.'. $file->extension();

        $file->storeAs($pasta_empresa, $nome_arquivo);

        return $file->storeAs($pasta_cliente, $nome_arquivo);
    }

}
