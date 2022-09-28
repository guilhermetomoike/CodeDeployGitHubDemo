<?php


namespace Modules\Irpf\Services;

use App\Models\Cliente;
use Modules\Irpf\Entities\DeclaracaoIrpf;
use Modules\Irpf\Entities\IrpfClienteResposta;
use Modules\Irpf\Entities\IrpfItemEnviado;
use Modules\Irpf\Jobs\CreateChargeJob;
use Modules\Irpf\Notifications\NaoAceiteIrpfNotification;
use Modules\Irpf\Repositories\IrpfRepository;
use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class IrpfService
{
    /**
     * @var IrpfRepository
     */
    private $irpfRepository;

    /**
     * IrpfService constructor.
     * @param IrpfRepository $irpfRepository
     */
    public function __construct(IrpfRepository $irpfRepository)
    {
        $this->irpfRepository = $irpfRepository;
    }

    public function storeIrpfResposta(array $data, $cliente_id)
    {
        validator($data + ['cliente_id' => $cliente_id], [
            'cliente_id' => Rule::exists('declaracao_irpf')->where(function ($query) {
                $query->where('ano', today()->subYear()->year);
            }),
            'respostas.*.resposta' => 'required_with:*.pergunta',
        ])->validate();

        return $this->irpfRepository->storeRespostas($data, $cliente_id);
    }

    public function getPendenciasByClienteId(int $cliente_id)
    {
        $pendencia = $this->irpfRepository->getPendenciaByClienteId($cliente_id);

        return $pendencia;
    }

    public function storePendenciaItems(int $cliente_id, int $resposta_id, array $items)
    {
        // pega id da empresa apenas para concaatenar numero no nome do arquivo caso encontrado
        $empresa_id = null;
        try {
            $empresa_id = Cliente::find($cliente_id)->empresa[0]->id;
        } catch (\Throwable $e) {
            // nothing happen
        }

        $items_enviados = IrpfClienteResposta::find($resposta_id)->enviados();
        $ano = today()->subYear()->year;
        foreach ($items as $key => $item) {
            if ($item instanceof UploadedFile) {

                $file_name = $key . '_' . str_random(5) . '.' . $item->extension();
                if ($empresa_id) $file_name = $empresa_id . '-' . $file_name;

                $path = $item->storeAs("grupobfiles/clientes/{$cliente_id}/irpf/$ano/comprovantes", $file_name);
                $items_enviados->create([
                    'name' => $key,
                    'value' => $path,
                    'type' => 'file',
                    'irpf_pendencia_id' => $resposta_id,
                    'ano' => $ano
                ]);

            } else {
                $items_enviados->create([
                    'name' => $key,
                    'value' => $item,
                    'type' => 'text',
                    'cliente_id' => $cliente_id,
                    'irpf_pendencia_id' => $resposta_id,
                    'ano' => $ano
                ]);
            }
        }

        return true;
    }

    public function finalizaDeclaracao(int $cliente_id, array $data)
    {
        try {
            DB::beginTransaction();
            $irpf = $this->irpfRepository->finalizaDeclaracao($cliente_id, $data);
            $irpf->addArquivo($data['declaracao_id'], 'declaracao', ['cliente_id' => $cliente_id, 'ano' => $irpf->ano]);
            $irpf->addArquivo($data['recibo_id'], 'recibo', ['cliente_id' => $cliente_id, 'ano' => $irpf->ano]);
            dispatch_now(new CreateChargeJob($irpf));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Erro ao atualizar os registros. '. $e->getMessage());
        }
        return $irpf->load('arquivos');
    }

    public function getClientesList(string $ano)
    {
        return $this
            ->irpfRepository
            ->getClientesList($ano)
            ->map(function($customer) {
                if ($customer->irpf) {
                    $pendenciesStatus = $this->pendenciesStatus($customer->irpf);

                    unset($customer->irpf->pendencias);
                    unset($customer->irpf->resposta);

                    $customer->irpf->pendencias = [
                        'required' => $pendenciesStatus['required']->count(),
                        'sent' => $pendenciesStatus['sent']->count(),
                        'diff' => $pendenciesStatus['diff']->count(),
                    ];
                }

                return $customer;
            });
    }

    public function changeIrpfStep(int $customerId, string $step)
    {
        return DeclaracaoIrpf
            ::query()
            ->updateOrCreate([
                'cliente_id' => $customerId,
                'ano' => today()->subYear()->year,
            ],
            [
                'step' => $step
            ]);
    }

    public function changeIrpfToAceito(int $customerId, bool $aceitou)
    {
        // if (!$aceitou) {
        //     $customer = Cliente::query()->find($customerId);
        //     $customer->notify(new NaoAceiteIrpfNotification());
        // }

        return DeclaracaoIrpf
            ::query()
            ->updateOrCreate([
                'cliente_id' => $customerId,
                'ano' => today()->subYear()->year,
            ],
            [
                'aceitou' => $aceitou,
                'cancelado' => !$aceitou
            ]);
    }

    public function changeIrpfToCancelado(int $customerId, bool $cancelado)
    {
        // if (!$aceitou) {
        //     $customer = Cliente::query()->find($customerId);
        //     $customer->notify(new NaoAceiteIrpfNotification());
        // }

        return DeclaracaoIrpf
            ::query()
            ->updateOrCreate([
                'cliente_id' => $customerId,
                'ano' => today()->subYear()->year,
            ],
            [
                'cancelado' => $cancelado,
                'aceitou' => !$cancelado
            ]);
    }


    public function changeIrpfToIsento(int $customerId, bool $isento)
    {
        return DeclaracaoIrpf
            ::query()
            ->updateOrCreate([
                'cliente_id' => $customerId,
                'ano' => today()->subYear()->year,
            ],
            [
                'isento' => $isento
            ]);
    }

    public function pendenciesStatus($irpf)
    {
        $requiredPendencias = $irpf
            ->resposta
            ->filter(fn($resposta) => $resposta->resposta)
            ->map(fn($resposta) => [
                'id' => $resposta->pendencia->id ?? null,
                'quantidade' => (int)$resposta->quantidade ?? null,
            ])
            ->sortBy('id')
            ->values();
        $sentPendencias = $irpf
            ->pendencias
            ->filter(fn($pendencia) => collect($pendencia->inputs)->contains(fn($item) => ($item['value'] ?? false)))
            ->map(fn($pendencia) => $pendencia->irpf_pendencia_id)
            ->groupBy(fn($value) => $value)
            ->map(fn($pendencia) => [
                'id' => $pendencia[0],
                'quantidade' => $pendencia->count(),
            ])
            ->sortBy('id')
            ->values();

        $diffPendencias = $requiredPendencias
            ->map(fn($item) => serialize($item))
            ->diffAssoc($sentPendencias->map(fn($item) => serialize($item)))
            ->map(fn($value) => unserialize($value));
        $checkDiffPendencias = $diffPendencias->filter(fn($item, $key) => ($sentPendencias[$key]['quantidade'] ?? 0) < $item['quantidade']);

        return [
            'required' => $requiredPendencias,
            'sent' => $sentPendencias,
            'diff' => $checkDiffPendencias,
        ];
    }
}
