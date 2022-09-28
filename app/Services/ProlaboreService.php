<?php


namespace App\Services;


use App\Repositories\ProlaboreRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProlaboreService
{
    /**
     * @var ProlaboreRepository
     */
    private $prolaboreRepository;

    /**
     * ProlaboreService constructor.
     * @param ProlaboreRepository $prolaboreRepository
     */
    public function __construct(ProlaboreRepository $prolaboreRepository)
    {
        $this->prolaboreRepository = $prolaboreRepository;
    }

    public function liberarProlaboreEmpresa(int $empresa_id, array $request)
    {
        return DB::transaction(function () use ($request, $empresa_id) {
            foreach ($request['prolabores'] as $prolabore) {
                $created = $this->prolaboreRepository->createProlabore($empresa_id, $request['competencia'], $prolabore);
                abort_if(!$created, 400, 'Erro ao liberar empresa prolabore do cliente ' . $prolabore['cliente_id']);
            }
            return true;
        });
    }

    public function estornarLiberacao(int $empresa_id, string $data_competencia)
    {
        return $this->prolaboreRepository->estornaLiberacaoProlabore($empresa_id, $data_competencia);
    }

    public function getListaLiberacao(Request $request)
    {
        return $this->prolaboreRepository->getListaLiberacao($request);
    }
}
