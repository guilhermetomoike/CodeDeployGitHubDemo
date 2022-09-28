<?php

namespace Modules\Invoice\Services;

use App\Models\Empresa;
use Modules\Invoice\Entities\Fatura;
use App\Services\Recebimento\RecebimentoService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Invoice\Entities\FaturaItem;
use Modules\Invoice\Entities\MovimentoContasReceber;

class FaturaService
{
    public function getFaturas(string $from, string $to, ?string $status, ?string $tipo)
    {

        if ($tipo == "") {

            return Fatura::query()
                ->whereNotNull('payer_id')
                ->whereBetween('data_vencimento', [$from, $to])
                ->with(['payer' => function ($payer) {
                    $payer->withTrashed();
                }])
                //    ->whereHas('items' , function ($items)  use ($tipo){


                //     $items->where('descricao', 'like', "%{$tipo}%");

                // })


                ->when($status, function (Builder $faturas, $status) {
                    $faturas->where('status', $status);
                })->get();
        } else {

            return    Fatura::query()
                ->whereNotNull('payer_id')
                ->whereBetween('data_vencimento', [$from, $to])
                ->with(['payer' => function ($payer) {
                    $payer->withTrashed();
                }])
                ->whereHas('items', function ($items)  use ($tipo) {
                    $items->where('descricao', 'like', "%{$tipo}%");
                })


                ->when($status, function (Builder $faturas, $status) {
                    $faturas->where('status', $status);
                })->get();
        }
    }

    public function resumoFaturas(Collection $faturas)
    {
        $atrasado = $faturas
        ->where('data_vencimento', '<=', today())
            ->where('status','atrasado');

        $pago = $faturas
            ->where('status', 'pago');

        $pendente = $faturas
            ->where('status', 'pendente')
            ->where('data_vencimento', '>=', today());

        $total = $faturas
            ->whereNotIn('status', ['cancelado', 'estornado']);

        $data['atrasado'] = [
            'valor' => $atrasado->sum('subtotal'),
            'quantidade' => $atrasado->count()
        ];
        $data['pago'] = [
            'valor' => $pago->sum('subtotal'),
            'quantidade' => $pago->count()
        ];
        $data['pendente'] = [
            'valor' => $pendente->sum('subtotal'),
            'quantidade' => $pendente->count()
        ];
        $data['total'] = [
            'valor' => $total->sum('subtotal'),
            'quantidade' => $total->count()
        ];

        return $data;
    }

    public function cancelarFatura($fatura, string $movito = null)
    {
        if (!($fatura instanceof Fatura)) {
            $fatura = Fatura::find($fatura);
        }
        $recebimentoService = (new RecebimentoService())->initialize('iugu');
        return $recebimentoService->cancelarFatura($fatura);
    }

    public function estornarFatura($fatura, string $motivo = null)
    {
        if (!($fatura instanceof Fatura)) {
            $fatura = Fatura::find($fatura);
        }
        $recebimentoService = (new RecebimentoService())->initialize('iugu');
        return $recebimentoService->reembolsarFatura($fatura);
    }

    public function calculaJuros($fatura, bool $shouldPersist = false)
    {
        if (!($fatura instanceof Fatura) && is_numeric($fatura)) {
            $fatura = Fatura::find($fatura);
        }

        $multa = config('services.iugu.multa');
        $juros = config('services.iugu.juros');
        $dias_atraso = today()->diff($fatura->data_vencimento)->days;
        $valor_multa = 0;
        $valor_juros = 0;

        if ($fatura->data_vencimento < today()->toDateString()) {
            $valor_multa = ($multa * $fatura->subtotal) / 100;
            $valor_juros = ((($juros / 30) / 100) * $dias_atraso) * $fatura->subtotal;
        }

        if ($shouldPersist) {
            if (!$valor_juros && !$valor_multa) {
                return $fatura;
            }
            $fatura->juros = $valor_juros;
            $fatura->multa = $valor_multa;
            $fatura->save();
            return $fatura;
        }

        return (object)['juros' => $valor_juros, 'multa' => $valor_multa];
    }

    public function create(array $data)
    {
        $items = ($data['items'] instanceof Collection) ? $data['items'] : new Collection($data['items']);
        $data['subtotal'] = $items->sum('valor');
        $data['data_competencia'] ??= date('Y-m-01', strtotime('- 1 month'));

        try {
            DB::beginTransaction();
            $fatura = Fatura::create($data);
            $fatura->items()->createMany($items->toArray());
            DB::commit();
        } catch (Exception $e) {
            throw new Exception('Erro na criação da fatura. ' . $e->getMessage());
        }

        return $fatura;
    }
    public function update(array $data)
    {
        $fat = [];
        $items = ($data['items'] instanceof Collection) ? $data['items'] : new Collection($data['items']);
        $fat['subtotal'] = $items->sum('valor');
        $fat['data_competencia'] ??= date('Y-m-01', strtotime('- 1 month'));
        $fat['data_vencimento'] = date('Y-m-d', strtotime($data['data_vencimento']));
        $fat['payer_id'] = $data['payer_id'];
        $fat['payer_type']  = $data['payer_type'];
        $fat['tipo_cobrancas_id'] = $data['tipo_cobrancas_id'];
        $fat['id'] = $data['id'];

        try {
            DB::beginTransaction();

            Fatura::where('id', $fat['id'])->update($fat);
            $fatura = Fatura::where('id', $fat['id'])->first();

            if (isset($items[0]['contas_receber_id'])) {

                foreach ($items->toArray() as $post) {
                    $post['created_at'] = date('Y-m-d H:i:s', strtotime(Carbon::now()));
                    $post['updated_at'] = date('Y-m-d H:i:s', strtotime(Carbon::now()));

                    if (isset($post['contas_receber_id'])) {
                        MovimentoContasReceber::where('id', $post['id'])->update(['valor' => $post['valor'], 'descricao' => $post['descricao']]);
                    } else { // not id
                        $fatura->movimento()->create($post);
                    }
                }
            } else {
            

                foreach ($items->toArray() as $post) {

                    $post['created_at'] = date('Y-m-d H:i:s', strtotime(Carbon::now()));
                    $post['updated_at'] = date('Y-m-d H:i:s', strtotime(Carbon::now()));
                    if (isset($post['id'])) {
                        
                        $fatura->items()->where('id',$post['id'])->update(['valor' => $post['valor'], 'descricao' => $post['descricao']]);
                    } else { // not id
                        $fatura->items()->create($post);
                    }
                }
            }
            // $fatura->items()->associate($items->toArray());
            DB::commit();
        } catch (Exception $e) {
            throw new Exception('Erro na Atualizacao da fatura. ' . $e->getMessage());
        }

        return $fatura;
    }

    public function destroy($invoice_id)
    {
        return Fatura::destroy($invoice_id);
    }

    public function updateFaturaStatus($request)
    {
        try {
            DB::beginTransaction();
            $fatura = Fatura::find($request->id);


            $fatura->update(['status' => $request->status]);

            DB::commit();
        } catch (Exception $e) {
            return response()->json($e, 200);
        }
        return 'status  ' . $request->status . ' salvo com sucesso';
    }

    public function  anticipacaoFatura(array $data){

        $emp = Empresa::where('id',$data['payer_id'])->first();
        $data['tipo_cobrancas_id'] = 1;
        $data['data_vencimento'] = Carbon::now()->addDays(2)->format('Y-m-d');
       $data['items'][0]['descricao'] ="antecipação do honorario ".$data['data_competencia'];
       $data['items'][0]['valor'] =  (float)$emp->plansubscription->plan->price;
    
       $items = ($data['items'] instanceof Collection) ? $data['items'] : new Collection($data['items']);
       $data['subtotal'] = $items->sum('valor');
       try {
           DB::beginTransaction();
           $fatura = Fatura::create($data);
           $fatura->items()->createMany($items->toArray());
           DB::commit();
       } catch (Exception $e) {
           throw new Exception('Erro na criação da fatura. ' . $e->getMessage());
       }

       return $fatura; 
       
    }
   
}
