<?php

namespace App\Services;

use App\Jobs\SendEmailGuiaJob;
use App\Notifications\GuiasPushNotification;
use Faker\Provider\DateTime;
use App\Models\{Guia, GuiaLiberacao, Upload, Empresa};
use App\Notifications\Whatsapp\GuiaDisponivelWhatsApp;
use App\Repositories\{EmpresaRepository, GuialiberacaoRepository};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GuiaService
{
    private GuialiberacaoRepository $guialiberacaoRepository;

    public function __construct(GuialiberacaoRepository $guialiberacaoRepository)
    {
        $this->guialiberacaoRepository = $guialiberacaoRepository;
    }

    public function create(array $request)
    {
        $tipoGuia = $request['tipo'];
        $empresaId = $request['empresa'];

        $empresa = (new EmpresaRepository)->getEmpresaById($empresaId);
        $competencia = Carbon::createFromFormat('Y-m-d', $request['competencia']);
        $vencimento = $this->getDataPadraoByTipo($tipoGuia)->data_vencimento;
        $file = Upload::find($request['file_id']);

        $dataGuia = [
            'usuarios_id' => auth('api_usuarios')->id(),
            'empresas_id' => $empresa->id,
            'nome_guia' => $file->path,
            'tipo' => $tipoGuia,
            'valor' => [strtolower($tipoGuia) => $request['valor']],
            'data_competencia' => $request['competencia'],
            'data_vencimento' => $vencimento,
        ];

        $guia = Guia::query()->updateOrCreate([
            'empresas_id' => $empresa['empresas_id'],
            'data_competencia' => $dataGuia['data_competencia'],
            'tipo' => $dataGuia['tipo'],
        ], $dataGuia);

        $guia->arquivo()->create([
            'nome_original' => $file->name,
            'caminho' => $file->path
        ]);
        $file->delete();

        return $guia;
    }

    public function estornar(int $id): ?int
    {
        return Guia::destroy($id);
    }

    public function getGuiasByEmpresa(int $empresa_id, string $competencia = null)
    {
        $competencia = $competencia ?? today()->subMonth()->format('Y-m-01');
        return $this->guialiberacaoRepository->getByEmpresaIdWithGuias($empresa_id, $competencia);
    }

    public function getDataPadrao()
    {
        return DB::table('guias_datas_padrao')->get();
    }

    public function getDataPadraoByTipo(string $tipo)
    {
        if (count($tipos = explode('/', $tipo)) > 1) {
            $tipo = $tipos[0];
        }
        return DB::table('guias_datas_padrao')->where('tipo', $tipo)->first();
    }

    public function getEmpresasWithGuias($competencia = null, $data_envio = null)
    {
        $competencia ??= competencia_atual();
        return $this->guialiberacaoRepository->getListEmpresasGuiasAndLiberacao($competencia, $data_envio);
    }

    public function changeLiberacao($liberado, int $empresaId, string $dataCompetencia)
    {
        $liberacao = remove_null_recursive($liberado);
        $guiasLiberacao = $this->guialiberacaoRepository->updateLiberacao($empresaId, $dataCompetencia, $liberacao);
        if (auth('api_usuarios')->user()) {
            $event = array_values($liberacao)[0] ? 'liberacao' : 'desliberacao';
            activity('guias')->on($guiasLiberacao)->log($event . '_manual:' . array_keys($liberacao)[0]);
        }
        return $guiasLiberacao;
    }

    public function sendEmail(int $guiasLiberacaoId)
    {
        $guiasLiberacao = GuiaLiberacao::find($guiasLiberacaoId);

        if (!$guiasLiberacao->rh_departamento_liberacao) {
            throw new \Exception('Por favor aguarde a liberação do RH.');
        }
        if (!$guiasLiberacao->contabilidade_departamento_liberacao) {
            throw new \Exception('Por favor aguarde a liberação da Contabilidade.');
        }
        if (!$guiasLiberacao->financeiro_departamento_liberacao) {
            throw new \Exception('Por favor aguarde a liberação de Honorário.');
        }

        $guiasLiberacao->empresa->notify(new GuiaDisponivelWhatsApp());
        SendEmailGuiaJob::dispatchNow($guiasLiberacao);
        activity('guias')->on($guiasLiberacao)->log('Envio de email manual.');
    }

    public function createOrUpdateHonorario($arquivo,$fatura)
    {
        // $arquivo = $fatura->arquivo()->first();
        $guia = Guia::query()->updateOrCreate([
            'empresas_id' => $fatura->payer_id,
            'tipo' => 'HONORARIOS',
            'data_competencia' => $fatura->data_competencia,
        ], [
            'data_vencimento' => $fatura->data_vencimento,
            'nome_guia' => $arquivo->nome_original,
        ]);

        if ($guia->arquivo) {
            $guia->arquivo->delete();
        }

        $guia->arquivo()->create([
            'nome_original' => $arquivo->nome_original,
            'caminho' => $arquivo->nome_original,
            'tags' => [
                'fatura_id' => $fatura->id,
                'data_competencia' => $fatura->data_competencia,
                'empresas_id' => $fatura->payer_id,
            ]
        ]);

        return $guia;
    }

    public function sendAllGuiasEligibles(string $data_competencia = null, bool $shouldRetry = false): void
    {
        $data_competencia ??= competencia_anterior();
        $guiasLiberacao = $this->guialiberacaoRepository->getGuiaLiberacaoDisponivelEnvio($data_competencia, $shouldRetry);

        $guiasLiberacao->each(function (GuiaLiberacao $guiaLiberacao) {
            $empresa = $guiaLiberacao->empresa;

            SendEmailGuiaJob::dispatch($guiaLiberacao);
            $empresa->notify(new GuiaDisponivelWhatsApp());

            $empresa->socios()->get()->each(function ($cliente) use ($empresa) {
                $cliente->notify(new GuiasPushNotification($empresa));
            });
        });

    }

    public function eligesToSend(string $data_competencia = null)
    {
        $data_competencia ??= competencia_anterior();

        $empresas = $this->guialiberacaoRepository->getEmpresasGuiasWithouEligibility($data_competencia);

        $empresas->each(function (Empresa $empresa) use ($data_competencia) {
            $this->eligesToSendByEmpresa($empresa, $data_competencia);
        });
    }

    public function validateGuides(array $guides, array $required)
    {
        foreach ($required as $value) {
            if (!in_array($value, $guides)) {

                if (strpos($value, "/") !== false && $this->validateExplodeString($value, $guides)) {
                    continue;
                }

                return false;
            }
        }

        return true;
    }

    public function validateExplodeString($value, $guides)
    {
        $data = explode("/", $value);

        foreach ($data as $value) {
            if (in_array($value, $guides)) {
                return true;
            }
        }
        return false;
    }

    public function validateRequiredType(Empresa $empresa, $data_competencia)
    {
        $month = date("Y-m", strtotime(trimestre()['fim']));

        $data_competencia = date("Y-m", strtotime($data_competencia));

        $paymentDate = $month <> $data_competencia;

        if ($empresa->regime_tributario == 'Presumido' && $empresa->trimestral && $paymentDate) {
            return Empresa\RequiredGuide::query()->whereIn('name', ['PIS/COFINS', 'ISS', 'INSS'])->get();
        }

        return $empresa->required_guide;
    }

    public function eligesToSendByEmpresa(Empresa $empresa, ?string $data_competencia): void
    {
        $requiredType = $this->validateRequiredType($empresa, $data_competencia);

        $tipos = $empresa->guias->pluck('tipo')->toArray();

        if ($this->validateGuides($tipos, $requiredType->where('type', 'contabilidade')->pluck('name')->toArray())) {
            $liberacao['contabilidade_departamento_liberacao'] = true;
        }

        if ($this->validateGuides($tipos, $requiredType->where('type', 'rh')->pluck('name')->toArray())) {
            $liberacao['rh_departamento_liberacao'] = true;
        }

        if (isset($liberacao)) {
            $this->changeLiberacao($liberacao, $empresa->id, $data_competencia);
        }
    }

    public function getUploadReport()
    {
        $uploads = Upload::query()
            ->where('label', 'guia')
            ->get();

        return [
            'total' => $uploads->where('there_is_error', false)->count(),
            'withError' => $uploads->where('there_is_error', true)->count(),
        ];
    }

    public function eligesWithouTaxes(string $data_competencia = null)
    {
        $data_competencia ??= competencia_anterior();
        return $this->guialiberacaoRepository->updateLiberationWithouTaxes($data_competencia);
    }
}
