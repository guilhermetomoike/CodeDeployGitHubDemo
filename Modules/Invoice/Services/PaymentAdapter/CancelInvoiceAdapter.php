<?php


namespace Modules\Invoice\Services\PaymentAdapter;


use App\Models\Empresa;
use Illuminate\Support\Facades\Log;
use Modules\Invoice\Contracts\Invoice\ICancelInvoiceService;
use Modules\Invoice\Entities\Fatura;

class CancelInvoiceAdapter implements ICancelInvoiceService
{
    private IHttpAdapter $httpAdapter;

    public function __construct(IHttpAdapter $httpAdapter)
    {
        $this->httpAdapter = $httpAdapter;
    }

    public function execute(int $fatura_id)
    {
        $fatura = Fatura::find($fatura_id);
        $response = $this->httpAdapter->request('put', 'invoices/' . $fatura->gatway_fatura_id . '/cancel');
        if (isset($response['errors']) && count($response['errors'])) {
            if (!$this->isInvoiceExpired($fatura)) {
                $apiError = collect($response['errors'])->join(' | ');
                throw new \Exception('Erro integração: ' . $apiError);
            }
        }

        $fatura->update(['status' => 'cancelado']);
        $payer = $fatura->payer;

        if ($payer instanceof Empresa) {
            $this->reverseFromTaxes($payer, $fatura);
        }

        return $fatura;
    }

    private function reverseFromTaxes(Empresa $payer, $fatura)
    {
        $guia = $payer
            ->guias()
            ->firstWhere(['data_competencia' => $fatura->data_competencia, 'tipo' => 'HONORARIOS']);

        if ($guia) {
            $guia->delete();
        }
    }

    private function isInvoiceExpired($fatura)
    {
        $response = $this->httpAdapter->request('get', 'invoices/' . $fatura->gatway_fatura_id);
        return in_array($response['status'] ?? false, ['expired', 'canceled']);
    }
}
