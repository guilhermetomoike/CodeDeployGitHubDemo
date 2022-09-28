<?php

namespace App\Services\Recebimento\Gatway\Iugu;

use App\Models\Payer\PayerContract;
use App\Models\Empresa;
use App\Models\Fatura;
use App\Services\Recebimento\Gatway\Iugu\Common\IuguCliente;
use App\Services\Recebimento\Gatway\Iugu\Common\IuguSubscription;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Api extends IuguConfig
{
    public function cadastrarCliente(PayerContract $payer)
    {
        try {
            $payable = new IuguCliente($payer);
            $response = $this->request('post', 'customers', $payable->toArray());
        } catch (BadResponseException $e) {
            $response = $e->getResponse()->getBody()->getContents();
            $decoded_response = json_decode($response, true);
            $messageResponse = $this->handleValidationError($decoded_response['errors']);
            abort(400, "Erro ao realizar o cadastro. [$messageResponse]");
        }
        return $response;
    }

    public function criarFormaPagamento($custom_id, $token, $default = true)
    {
        try {
            $data['description'] = 'Pagamento por recorrencia com cartao de credito.';
            $data['token'] = $token;
            $data['set_as_default'] = $default;
            $response = $this->request('post', 'customers/' . $custom_id . '/payment_methods', $data);
        } catch (BadResponseException $e) {
            $error_message = $e->getResponse()->getBody()->getContents();
            throw new HttpException(400, $error_message);
        }
        return $response;
    }

    /**
     * Cria uma assinatura vinculando plan_identifier com customer_id
     * @param IuguSubscription $iuguSubscription
     * @return mixed
     */
    public function criarAssinatura(IuguSubscription $iuguSubscription)
    {
        try {
            $response = $this->request('post', 'subscriptions', $iuguSubscription->toArray());
        } catch (BadResponseException $e) {
            $error_message = $e->getResponse()->getBody()->getContents();
            throw new HttpException(400, 'erro inesperado ao criar forma de pagamento. ' . $error_message);
        }
        return $response;
    }

    /**
     * Atualiza uma assinatura de cartao de credito
     * @param IuguSubscription $iuguSubscription
     * @return mixed
     */
    public function updateAssinatura(IuguSubscription $iuguSubscription)
    {
        try {
            $response = $this->request('post', 'subscriptions', $iuguSubscription->toArray());
        } catch (BadResponseException $e) {
            $error_message = $e->getResponse()->getBody()->getContents();
            throw new HttpException(400, 'erro inesperado ao criar forma de pagamento. ' . $error_message);
        }
        return $response;
    }

    /**
     * Realiza uma cobranca direta com token de cartao de credito
     * @return mixed
     */
    public function receber(Empresa $empresa, $token_cartao, $valor, $descricao = null)
    {
        try {
            $data = [
                'token' => $token_cartao,
                'customer_id' => $empresa->iugo_id,
                'email' => $empresa->getEmaildeEnvio->cliente,
                'items' => [
                    [
                        'description' => $descricao ?? 'ServicosSeeder Medb',
                        'price_cents' => $valor * 100,
                        'quantity' => 1,
                        'recurrent' => false,
                    ],
                ]
            ];
            $response = $this->request('post', 'charge', $data);
        } catch (BadResponseException $e) {
            $response = $e->getResponse()->getBody()->getContents();
            $decoded_response = json_decode($response);
            if (is_object($decoded_response->errors)) {
                foreach ($decoded_response->errors as $key => $error) {
                    throw new HttpException(400, "Erro ao realizara cobrança. [$key $error[0]]");
                }
            }
            throw new HttpException(400, "Erro ao realizara cobrança. [$decoded_response->errors]");
        }
        return $response;
    }

    public function criarFatura(Common\IuguFatura $faturaIugu)
    {
        try {
            $response = $this->request('post', 'invoices', $faturaIugu->toArray());
        } catch (BadResponseException $e) {
            $error_message = $e->getResponse()->getBody()->getContents();
            throw new HttpException(400, 'Erro ao montar a fatura na api. ' . $error_message);
        }
        return $response;
    }

    public function downloadPdf(\Modules\Invoice\Entities\Fatura $fatura)
    {
        $data_vencimento = $fatura->data_vencimento->format('Y-m-d');
        $fileName = storage_path("app/public/{$fatura->id}_{$fatura->payer_id}_{$data_vencimento}.pdf");
        try {
            (new Client())->get($fatura->fatura_url . '.pdf', ['sink' => $fileName]);
            $uploadedFile = Storage::disk()->putFile(null, $fileName);
            Storage::disk('public')->delete(basename($fileName));
        } catch (\Exception $e) {
            throw new HttpException(500, 'Erro no download do boleto - ' . $e->getMessage());
        }
        return $uploadedFile;
    }

    public function cancelarFatura($gatway_fatura_id)
    {
        try {
            $response = $this->request('put', "invoices/{$gatway_fatura_id}/cancel");
        } catch (BadResponseException $e) {
            $error = $e->getResponse()->getBody()->getContents();
            throw new HttpException(500, "Erro ao cancelar a fatura no IUGU [{$error}]");
        }
        return $response;
    }

    public function reembolsarFatura($gatway_fatura_id)
    {
        try {
            $response = $this->request('post', "invoices/{$gatway_fatura_id}/refund");
        } catch (BadResponseException $e) {
            $error = $e->getResponse()->getBody()->getContents();
            throw new HttpException(500, "Erro ao Estornar a fatura no IUGU [{$error}]");
        }
        return $response;
    }

    private function request(string $method, string $uri, array $data = [])
    {
        $response = $this->api->{$method}($uri, ['json' => $data])
            ->getBody()
            ->getContents();
        return json_decode($response);
    }

    private function handleValidationError(array $errors): ?string
    {
        $errors = collect($errors)->map(function ($message, $error) {
            if (is_array($message)) {
                return $error . ': ' . implode(', ', $message);
            }
            return $message;
        })->toArray();

        return implode(' | ', $errors);
    }
}
