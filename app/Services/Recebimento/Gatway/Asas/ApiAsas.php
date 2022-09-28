<?php

namespace App\Services\Recebimento\Gatway\Asas;

use App\Models\Payer\PayerContract;
use App\Models\Empresa;
use App\Models\Fatura;
use App\Services\Recebimento\Gatway\Asas\AsasConfig;


use App\Services\Recebimento\Gatway\Asas\Common\AsasCliente;
use App\Services\Recebimento\Gatway\Asas\Common\AsasFatura;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiAsas extends AsasConfig
{
    public function cadastrarCliente(PayerContract $payer)
    {
        try {
            $payable = new AsasCliente($payer);
            $response = $this->request('post', 'customers', $payable->toArray());
        } catch (BadResponseException $e) {
            return $e;
            // $response = $e->getResponse()->getBody()->getContents();
            // $decoded_response = json_decode($response, true);
            // $messageResponse = $this->handleValidationError($decoded_response['errors']);
            // abort(400, "Erro ao realizar o cadastro. [$messageResponse]");
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

    public function criarFatura(AsasFatura $faturaAsas)
    {
        try {
            $response = $this->request('post', 'payments', $faturaAsas->toArray());
        } catch (BadResponseException $e) {
            $error_message = $e->getResponse()->getBody()->getContents();
            throw new HttpException(400, 'Erro ao montar a fatura na api. ' . $error_message);
        }
        return $response;
    }
    public function updateFatura(AsasFatura $faturaAsas, $gatway_fatura_id)
    {
        try {
            $response = $this->request('post', 'payments/' . $gatway_fatura_id, $faturaAsas->toArray());
        } catch (BadResponseException $e) {
            $error_message = $e->getResponse()->getBody()->getContents();
            $response= $error_message;
        }
        return $response;
    }
    public function listaFaturasAtrasadas()
    {
        try {
            // $response = $this->request('get', 'payments?status=OVERDUE');
            $response = $this->request('get', 'payments?status=PENDING&dueDate%5Ble%5D=2021-12-15');
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
            (new Client())->get($fatura->fatura_url_boleto, ['sink' => $fileName]);
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
            $data = [
                "deleted" => true,
                "id" => $gatway_fatura_id
            ];
            $response = $this->request('delete', "payments/{$gatway_fatura_id}", $data);
        } catch (BadResponseException $e) {
            $error = $e->getResponse()->getBody()->getContents();
            throw new HttpException(500, "Erro ao cancelar a fatura no ASAAS [{$error}]");
        }
        return $response;
    }



    public function reembolsarFatura($gatway_fatura_id)
    {
        return 'pronto';
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
