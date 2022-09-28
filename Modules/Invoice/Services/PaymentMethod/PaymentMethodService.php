<?php


namespace Modules\Invoice\Services\PaymentMethod;


use App\Models\CartaoCredito;
use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Invoice\Events\CreditCardWasCreated;
use Modules\Invoice\Events\PaymentMethodWasDeleted;

class PaymentMethodService implements IPaymentMethodService
{
    public function getAll(): iterable
    {
        $empresas = Empresa::with('cartao_credito')->whereHas('cartao_credito')->get();
        $clientes = Cliente::with('cartao_credito')->whereHas('cartao_credito', function ($cartao_credito) use ($empresas) {
            if ($empresas->count() > 0 && $cc = $empresas->pluck('cartao_credito')) {
                $cartao_credito->whereNotIn('id', $cc->flatten()->pluck('id'));
            }
        })->get();
        return $empresas->merge($clientes);
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            if (isset($data['empresa_id']) && !empty($data['empresa_id'])) {
                $empresa = Empresa::query()->find($data['empresa_id']);
                $cartao_credito = $empresa->cartao_credito()->create($data);
            } else {
                $cliente = Cliente::query()->find($data['cliente_id']);
                $cartao_credito = $cliente->cartao_credito()->create($data);
            }
            // event(new CreditCardWasCreated($cartao_credito));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $cartao_credito;
    }
    public function update(array $data)
    {
        try {
            DB::beginTransaction();
            if (isset($data['empresa_id']) && !empty($data['empresa_id'])) {
                $empresa = Empresa::query()->find($data['empresa_id']);
                 $cartao_credito = $empresa->cartao_credito()->update($data);
                
            } else {
                $cliente = Cliente::query()->find($data['cliente_id']);
                $cartao_credito = $cliente->cartao_credito()->create($data);
            }
            // event(new CreditCardWasCreated($cartao_credito));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $cartao_credito;
    }


    public function getByPayer(string $payer_type, int $payer_id): iterable
    {
        $payer = Relation::$morphMap[$payer_type]::find($payer_id);
        return $payer->cartao_credito;
    }

    public function delete(int $payment_method_id): bool
    {
        try {
            DB::beginTransaction();
            $paymentMethod = CartaoCredito::query()->find($payment_method_id);
            $paymentMethod->delete();
            event(new PaymentMethodWasDeleted($paymentMethod));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('stack')->emergency($e->getMessage());
            return false;
        }
        return true;
    }
}
