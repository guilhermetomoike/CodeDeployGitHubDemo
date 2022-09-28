<?php


namespace App\Services\Nfse;

use App\Jobs\EmitirNfseJob;
use App\Models\Empresa;
use App\Models\Nfse\TomadorNfse;
use App\Notifications\ErrorInNfseNotification;
use App\Repositories\NfseRepository;
use App\Services\Nfse\Common\Prestador\Prestador;
use App\Services\Nfse\Common\Servico\Servico;
use App\Services\Nfse\Common\Tomador\Tomador;
use App\Services\Nfse\Plugnotas\Common\Nfse;
use App\Services\Nfse\Plugnotas\PlugnotasService;
use Modules\Invoice\Entities\Fatura;
use Symfony\Component\HttpKernel\Exception\HttpException;

class NfseService
{
    private PlugnotasService $Plugnotas;

    private NfseRepository $NfseRepository;

    public function __construct()
    {
        $this->Plugnotas = new PlugnotasService();
        $this->NfseRepository = new NfseRepository();
    }

    public function emitir(array $data, int $empresa_id)
    {
        $empresa = Empresa::query()->find($empresa_id);
        $prestador = new Prestador($empresa);

        $tomador = TomadorNfse::find($data['tomador_id']);
        $tomador = new Tomador($tomador);
        $tomador->setEmail($data['email_envio']);

        $servico = new Servico($data);

        $nfse = new Nfse($prestador, $tomador, $servico);

        $response = $this->Plugnotas->emitir($nfse);

        if (isset($response->statusCode) && $response->statusCode != 200) {
            throw new HttpException(500, $response->body->error->message);
        }

        $jsonSentWithoutNull = array_filter_recursive($nfse->toArray());

        return $this->NfseRepository
            ->storeNfseEmitida($data, $response, $jsonSentWithoutNull, $empresa_id);

    }

    public function refreshStatus(string $idIntegracao)
    {
        $response = $this->Plugnotas->getNfse($idIntegracao);

        if (isset($response['statusCode']) && $response['statusCode'] != 200) {
            throw new HttpException(500, $response['message']);
        }

        $this->updateStatusReceived([
            'id' => $response['id'],
            'situacao' => $response['status'],
            'prestador' => $response['prestador']['cpfCnpj'],
            'mensagem' => '',
            'emissao' => array_key_exists('dataAutorizacao', $response['retorno']) ? $response['retorno']['dataAutorizacao'] : today(),
            'valorServico' => $response['servico'][0]['valor']['servico'],
        ]);

        return $response;
    }

    public function receiveWebhook(array $data)
    {
        if (isset($data['id'])) {
            $this->updateStatusReceived($data);
            return;
        }
        foreach ($data as $nfse) {
            $this->updateStatusReceived($nfse);
        }
    }

    public function updateStatusReceived($nfse)
    {
        if (isset($nfse['prestador'])) {
            $empresa = Empresa::query()->where('cnpj', $nfse['prestador'])->first();
            $nfse['empresas_id'] = $empresa->id;

            $status = $nfse['situacao'] ?? $nfse['body']['situacao'];
            if ($status === 'REJEITADO') {
                $empresa->notify(new ErrorInNfseNotification(
                    $nfse['mensagem'] ?? $nfse['body']['mensagem'] ?? 'Erro'
                ));
            }
        }

        $this->NfseRepository->saveWebhook($nfse['body'] ?? $nfse);
    }

    public function cancelar(int $id)
    {
        $nfse = $this->NfseRepository->findById($id);
        return $this->Plugnotas->cancelar($nfse->id_tecnospeed);
    }

    public function getGatewayInstance(): PlugnotasService
    {
        return $this->Plugnotas;
    }

    public function dispatchByInvoiceId($fatura_id)
    {
        $fatura = Fatura::query()->find($fatura_id);
        EmitirNfseJob::dispatch($fatura);
    }

}

