<?php

namespace Modules\Irpf\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Irpf\Entities\DeclaracaoIrpf;
use Modules\Irpf\Entities\IrpfInputPendencia;
use Modules\Irpf\Entities\IrpfQuestionario;

class IrpfQuestionService
{
    private IrpfService $irpfService;

    public function __construct(IrpfService $irpfService)
    {
        $this->irpfService = $irpfService;
    }

    public function getAll()
    {
        return IrpfQuestionario::query()
            ->with([
                'pendencia' => fn($pendencia) => $pendencia->with('inputs')
            ])
           
            ->orderBy('order')
            ->get();
    }

    public function getAll2($ano)
    {
        return IrpfQuestionario::query()
            ->with([
                'pendencia' => fn($pendencia) => $pendencia->with('inputs')
            ])
            ->where('ano',$ano)
            ->orderBy('order')
            ->get();
    }

    public function create(array $data)
    {
        return $this->save(new IrpfQuestionario, $data);
    }

    public function update($id, array $data)
    {
        $questionario = IrpfQuestionario::query()->find($id);
        return $this->save($questionario, $data);
    }

    public function delete($id)
    {
        return IrpfQuestionario::destroy($id);
    }

    private function save(IrpfQuestionario $model, array $data)
    {
        $inputs = $data['pendencia']['inputs'] ?? null;
        $pendencia = $data['pendencia'] ?? null;
        unset($data['pendencia']['inputs']);
        unset($data['pendencia']);

        try {
            DB::beginTransaction();
            $model->fill($data);
            $model->save();

            if ($pendencia && isset($pendencia['id'])) {
                $pendenciaModel = $model->pendencia()->where('id', $pendencia['id'])->first();
                $pendenciaModel->update($pendencia);
            }
            if ($pendencia && !isset($pendencia['id'])) {
                $pendenciaModel = $model->pendencia()->create($pendencia);
            }

            if (isset($pendenciaModel) && $inputs) {
                foreach ($inputs as $input) {
                    if (isset($input['id'])) {
                        unset($input['created_at']);
                        unset($input['updated_at']);
                        $pendenciaModel->inputs()->where('id', $input['id'])->update($input);
                        continue;
                    }
                    $pendenciaModel->inputs()->create($input);
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception('Erro ao salvar os registros. | ' . $exception->getMessage(), 400);
        }

        return $model;
    }

    public function deletePendenciaInput(int $input_id)
    {
        return IrpfInputPendencia::destroy($input_id);
    }

    public function getQuestionsForCustomer($customer_id, ?array $filters = [])
    {
        $declaracao = DeclaracaoIrpf::query()->firstOrCreate([
            'cliente_id' => $customer_id,
            'ano' => 2021,
        ]);
        return IrpfQuestionario::query()
        ->where('ano', 2021)
            ->when(!isset($filters['all']), function ($builder, $value) {
                $builder->where('visivel_cliente', true);
                

            })
            ->with(['resposta' => fn($res) => $res->where('declaracao_irpf_id', $declaracao->id)])
            ->orderBy('order')
         
            ->get();
    }

    public function responderQuestionario(int $customer_id, array $data)
    {
        try {
            DB::beginTransaction();
            $declaracao = $this->irpfService->changeIrpfStep($customer_id, 'pendencia');

            foreach ($data as $resposta) {
                $irpfRespostaModel = $declaracao->resposta()->updateOrCreate(
                    [
                        'irpf_questionario_id' => $resposta['id']
                    ],
                    [
                        'resposta' => $resposta['resposta'],
                        'quantidade' => $resposta['quantidade'],
                    ]
                );

                Collection::times($resposta['quantidade'], function () use ($irpfRespostaModel) {
                    foreach ($irpfRespostaModel->pendencia->inputs as $input) {
                        $irpfRespostaModel->inputs()->updateOrCreate([
                            'irpf_pendencia_id' => $irpfRespostaModel->pendencia->id,
                            'irpf_pendencia_input_id' => $input->id
                        ]);
                    }
                });
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function getPendenciesForCustomer($customer_id, ?array $filters = [])
    {
        $irpf = DeclaracaoIrpf
            ::with([
                'pendencias' => function ($pendencia) {
                    $pendencia
                        ->select(
                            'irpf_cliente_pendencia.id',
                            'irpf_cliente_pendencia.declaracao_irpf_id',
                            'irpf_cliente_pendencia.inputs',
                            'irpf_cliente_pendencia.irpf_pendencia_id',
                            'irpf_pendencia.irpf_questionario_id',
                            'nome',
                            'descricao',
                            'irpf_cliente_resposta.resposta'
                        )
                        ->join('irpf_pendencia', 'irpf_pendencia.id', '=', 'irpf_cliente_pendencia.irpf_pendencia_id')
                        ->join('irpf_cliente_resposta', function ($join) {
                            $join
                                ->on('irpf_cliente_resposta.declaracao_irpf_id', '=', 'irpf_cliente_pendencia.declaracao_irpf_id')
                                ->on('irpf_cliente_resposta.irpf_questionario_id', '=', 'irpf_pendencia.irpf_questionario_id');
                        });
                }
            ])
            ->where('cliente_id', $customer_id)
            ->where('ano', today()->subYear()->year)
            ->first();

        if (!$irpf) {
            return [];
        }

        return $irpf
            ->pendencias
            ->map(function ($pendencia) {
                $pendencia->temPendencia = collect($pendencia->inputs)->contains(fn($item) => !array_key_exists('value', $item) || !$item['value']);
                return $pendencia;
            })
            ->filter(fn($pendencia) => $pendencia->resposta)
            ->groupBy('irpf_pendencia_id');
    }
}
