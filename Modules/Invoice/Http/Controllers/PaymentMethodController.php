<?php

namespace Modules\Invoice\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Invoice\Http\Middleware\OnlyBackoffice;
use Modules\Invoice\Http\Requests\StorePaymentMethodRequest;
use Modules\Invoice\Services\PaymentMethod\IPaymentMethodService;
use Modules\Invoice\Transformers\PaymentMethodsResources;
use Modules\Invoice\Transformers\PaymentMethodsShowResource;

class PaymentMethodController extends Controller
{
    private IPaymentMethodService $paymentMethodService;

    public function __construct(IPaymentMethodService $paymentMethodService)
    {
        $this->middleware(OnlyBackoffice::class)->only('index');
        $this->paymentMethodService = $paymentMethodService;
    }

    public function index()
    {
        $data = $this->paymentMethodService->getAll();
        return PaymentMethodsResources::collection($data);
    }

    public function store(StorePaymentMethodRequest $request)
    {
        $data = $request->validated();
        try {
            $paymentMethod = $this->paymentMethodService->create($data);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => 'Falha no cadastramento do cartão. (' . $e->getMessage() . ')',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
        return new JsonResponse([
            'message' => 'Operação realizada com sucesso.',
            'data' => $paymentMethod
        ], JsonResponse::HTTP_CREATED);
    }

    public function show(string $payer_type, int $payer_id)
    {
        // todo validar caso $payer_type seja empresa
//        $authenticated = auth('api_clientes');
//        if ($authenticated && $authenticated->user() instanceof Cliente) {
//            abort_if($authenticated->id() !== $payer_id, '401', 'Não autorizado!');
//        }
        $paymentMethods = $this->paymentMethodService->getByPayer($payer_type, $payer_id);
        return PaymentMethodsShowResource::collection($paymentMethods);
    }

    public function destroy($id)
    {
        $deleted = $this->paymentMethodService->delete($id);
        if (!$deleted) {
            return new JsonResponse(
                ['message' => 'Não foi possível realizar a operação.'],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
        return new JsonResponse(['message' => 'Operação realizada com sucesso.']);
    }
}
