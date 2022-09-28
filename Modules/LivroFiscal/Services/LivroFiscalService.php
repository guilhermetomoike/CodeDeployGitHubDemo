<?php


namespace Modules\LivroFiscal\Services;


use App\Modules\ConvertBase64ToFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\LivroFiscal\Repositories\LivroFiscalRepository;

class LivroFiscalService
{
    private LivroFiscalRepository $livroFiscalRepository;

    public function __construct(LivroFiscalRepository $livroFiscalRepository)
    {
        $this->livroFiscalRepository = $livroFiscalRepository;
    }

    public function getAll(?string $status = null)
    {
        return $this->livroFiscalRepository->getAll($status);
    }

    public function update(int $id, array $data)
    {
        $arquivos = [];

        foreach ($data['arquivos'] as $arquivo) {
            if (!isset($arquivo['file']) || !isset($arquivo['file']['base64'])) continue;
            $file = ConvertBase64ToFile::run($arquivo['file']['base64']);
            $path = Str::random(40) . '.pdf';
            Storage::disk('s3')->put($path, $file);
            $arquivos[] = [
                'nome_original' => $arquivo['file']['name'],
                'caminho' => $path,
                'nome' => $arquivo['numero'] . '_' . $arquivo['tipo'] . '_' . $data['ano'],
            ];
        }

        $data['arquivos'] = $arquivos;

        return $this->livroFiscalRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->livroFiscalRepository->delete($id);
    }
}
