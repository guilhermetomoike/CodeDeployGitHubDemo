<?php

namespace App\Services\Nfse\Plugnotas;

use App\Services\FileService;
use App\Services\Nfse\Common\Servico\Servico;
use App\Services\Nfse\Common\Tomador\Tomador;
use App\Services\Nfse\Contracts\ApiNfse;
use App\Services\Nfse\Plugnotas\Common\Nfse;
use App\Services\SlackService;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Storage;
use stdClass;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PlugnotasService extends PlugnotasConfig implements ApiNfse
{
    /**
     * @param array $nfse
     * @return stdClass|mixed
     */
    public function emitir(Nfse $nfse)
    {
        try {
            $response = $this->Http
                ->post('nfse', ['json' => [$nfse->toArray()]])
                ->getBody()
                ->getContents();

            return json_decode($response);

        } catch (BadResponseException $exception) {
            $error = $exception->getResponse()->getBody()->getContents();
            $decodedResponse = json_decode($error);
            (new SlackService())->addChannel('#ti')->addField('Erro de nfse', "$error")->send();
            abort(400, "Erro ao emitir. ({$decodedResponse->error->message})");
        } catch (\Throwable $e) {
            abort(500, 'Erro inesperado do servidor de envio.');
        }
    }

    public function cancelar(string $nfse_id_integracao)
    {
        try {
            $response = $this->Http->post('nfse/cancelar/' . $nfse_id_integracao)->getBody()->getContents();

            return json_decode($response);

        } catch (BadResponseException $e) {
            $error = $e->getResponse()->getBody()->getContents();
            throw new HttpException(500, "Erro ao cancelar Nfse. [{$error->message}]");
        }
    }

    public function downloadPdf(\App\Models\Nfse\Nfse $nfse)
    {
        $fileName = storage_path('app/public/' . $nfse->id_tecnospeed . '.pdf');
        $this->Http->get("nfse/pdf/{$nfse->id_tecnospeed}", [
            'sink' => $fileName
        ]);
        $storedFile = Storage::disk()->putFile(null, $fileName);
        Storage::disk('public')->delete(basename($fileName));
        return $storedFile;
    }

    public function getClient()
    {
        return $this->Http;
    }

    public function getNfse(string $idIntegracao)
    {
        try {
            $response = $this->Http
                ->get('nfse/'.$idIntegracao)
                ->getBody()
                ->getContents();

            return json_decode($response, true);

        } catch (BadResponseException $exception) {
            $error = $exception->getResponse()->getBody()->getContents();
            throw new HttpException(400, "Erro ao consultar a Nfse. [{$error}]");
        }
    }

}
