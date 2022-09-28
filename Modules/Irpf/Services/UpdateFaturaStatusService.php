<?php


namespace Modules\Irpf\Services;

use App\Services\Recebimento\Gatway\Asas\AsasService;
use App\Services\Recebimento\Gatway\Asas\Common\AsasFatura;
use AsyncAws\Core\Exception\Http\HttpException;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Invoice\Entities\Fatura;
use Modules\Invoice\Jobs\FaturaToHonorarioAsasJob;


class UpdateFaturaStatusService
{
    public function execute(string $fatura_iugu_id, string $payment_method)
    {
        $fatura = Fatura::query()->where('gatway_fatura_id', $fatura_iugu_id)->first();
        $fatura->update([
            'status' => 'pago',
            'data_recebimento' => date('Y-m-d'),
            'forma_pagamento_id' => $this->qualifyPaymentMethod($payment_method)
        ]);
        return $fatura;
    }

    public function updateJuros($fatura, AsasService $asasService)
    {

        $texto = '';
        $totalValor = 0;
        $atualizado=[];

        $valores   =    Fatura::where('gatway_fatura_id', $fatura['id'])->where('status', '<>', 'cancelado')->first();


        if (!isset($valores->data_vencimento)) {

            $valores   =    Fatura::where('gatway_fatura_id', $fatura['id'])->where('status', '<>', 'cancelado')->first();
        }
        if (isset($valores->id)) {

            $faturaAsas = new AsasFatura;

            $data_inicial =  Carbon::parse($fatura['originalDueDate'])->format('Y-m-d');
            $data_final = Carbon::now()->format('Y-m-d');

            $diferenca = strtotime($data_final) - strtotime($data_inicial);
            $dias = floor($diferenca / (60 * 60 * 24));
            $faturaAsas->setCustomer($fatura['customer']);
            $faturaAsas->setExternalReference($fatura['externalReference']);
            $faturaAsas->setBillingType('BOLETO');
            $faturaAsas->setDueDate($data_final);

            if (isset($valores->movimento[0]['id'])) {

                foreach ($valores->movimento as $item) {
                    if ($texto == '') {
                        $texto = $item->descricao ?? ' ';
                    } else {
                        $texto  = $texto . ' + ' . $item->descricao;
                    }
                    if ($item->valor > 0) {
                        $totalValor = $item->valor + $totalValor;
                    }
                }
                // $faturaAsas->setDiscountFromMovimentoContasReceber($fatura->movimento);

            } else {

                foreach ($valores->items as $item) {
                    if ($texto == '') {
                        $texto = $item->descricao ?? ' ';
                    } else {
                        $texto  = $texto . ' + ' . $item->descricao;
                    }
                    if ($item->valor > 0) {
                        $totalValor = $item->valor + $totalValor;
                    }
                }
                // $faturaAsas->setDiscountFromMovimentoContasReceber($fatura->items);

            }


            $calc = number_format((($dias * 0.11) + ((($totalValor  / 30) * $dias) * 0.01) + ($totalValor  * 0.02) + $totalValor), 2, '.', '');



            $faturaAsas->setValue($calc);

            $faturaAsas->setDescription($texto . ' Vencimento Original Do boleto ' . $data_inicial . ' Juros : ' . number_format((($dias * 0.11) + ((($totalValor  / 30) * $dias) * 0.01) + ($totalValor  * 0.02)), 2));

          
            $atualizado =    $asasService->updateFatura($faturaAsas, $fatura['id']);

             Fatura::query()->where('gatway_fatura_id', $fatura['id'])->update(['status' => 'atrasado']);


             
          if(isset(json_decode(json_encode($atualizado))->id)){
              return $atualizado;
          }

            if (isset(json_decode($atualizado)->errors[0]->description)) {
                return  $atualizado;
                if ((mb_strpos(json_decode($atualizado)->errors[0]->description, 'Cobrança removida') !== false)) {
                    return 'excluido';
                }
            }
            return $atualizado;
        }
        return 'não existe';
    }

    // public function updateStatus(string $fatura_iugu_id)
    // {
    //     $fatura = Fatura::query()->where('gatway_fatura_id', $fatura_iugu_id)->first();

        
    //     if (isset($fatura->id)) {
           

    //         return $fatura;
    //     }

    //     return 'não existe';
    // }
    public function updatePago(string $fatura_iugu_id, $status, $payment_method, $data, $value)
    {
        $fatura = Fatura::query()->where('status','<>','pago')->where('gatway_fatura_id', $fatura_iugu_id)->first();
        if (isset($fatura->id)) {
            $fatura->update([
                // 'data_vencimento' => $data,
                'subtotal' => $value,
                'status' => $status,
                'data_recebimento' => date('Y-m-d'),
                'forma_pagamento_id' => $payment_method
            ]);


            return $fatura;
        }
        return 'não existe';
    }

    private function qualifyPaymentMethod(string $payment_method): int
    {
        if (Str::contains($payment_method, 'bank_slip')) {
            return 1;
        }
        return 2;
    }

    public function isInvalidChange(\Illuminate\Http\Request $request): bool
    {
        return !is_array($request->data) ||
            !isset($request->event) ||
            $request->event != 'invoice.status_changed' ||
            $request->data['status'] != 'paid';
    }
}
