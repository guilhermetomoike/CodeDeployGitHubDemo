<?php

namespace App\Jobs;

use App\Models\Nfse\Nfse;
use App\Notifications\ErrorInNfseNotification;
use App\Services\Nfse\Plugnotas\PlugnotasService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Modules\Invoice\Entities\Fatura;

class EmitirNfseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $prestador = '25113801000194';
    private string $discriminacao = 'Honorarios contabeis';
    private ?string $competencia;
    private Fatura $fatura;

    public function __construct(Fatura $fatura, string $competencia = null)
    {
        $this->onQueue('financeiro');
        $this->competencia = $competencia ?? competencia_anterior();
        $this->fatura = $fatura;
    }

    public function handle(PlugnotasService $plugnotasService)
    {
        sleep(2);

        try {
            $response = $plugnotasService
                ->getClient()
                ->post('nfse', ['json' => [$this->buildArray()]])
                ->getBody()
                ->getContents();

            Log::channel('stack')->info($response);

            $this->saveResponse(json_decode($response));

        } catch (\Exception $exception) {
            Log::channel('stack')->info($exception->getMessage());
            $this->notifyErrorDiscord($exception->getMessage());
        }
    }

    private function buildArray()
    {
        $fatura = $this->fatura;
        $payer = $fatura->payer;

        return [
            'idIntegracao' => (string)$fatura->id,
            'prestador' => [
                'cpfCnpj' => $this->prestador,
            ],
            'tomador' => [
                'cpfCnpj' => $payer->cpf ?? $payer->cnpj,
                'razaoSocial' => $payer->nome_completo ?? $payer->razao_social,
                'email' => 'financeiro@medb.com.br',
                'endereco' => $this->buildAddress($payer),
            ],
            'servico' => [
                'codigo' => "17.19",
                'cnae' => "6920601",
                'discriminacao' => $this->discriminacao,
                'valor' => [
                    'servico' => (float)$fatura->subtotal,
                ],
                'iss' => [
                    'aliquota' => 0,
                ],
            ],
            'enviarEmail' => false,
            'config' => ['producao' => true]
        ];
    }

    private function buildAddress($payer)
    {
        $endereco = $payer->endereco;

        if (!$endereco->cep) throw new \Exception('EmitirNfseJob: Endereço do pagador  não encontrado.');

        if (!$endereco->ibge) {
            $consulta = consulta_cep1($endereco->cep);

            if (!$consulta) throw new \Exception('EmitirNfseJob: Endereço do pagador  não encontrado.');

            $ibge = $consulta->ibge;

            if (!$ibge) throw new \Exception('EmitirNfseJob: Endereço do pagador  não encontrado.');

            $endereco->ibge = $ibge;
            $endereco->save();
        }

        return [
            'descricaoCidade' => $endereco->cidade,
            'cep' => $endereco->cep,
            'logradouro' => $endereco->logradouro,
            'numero' => $endereco->numero,
            'bairro' => $endereco->bairro,
            'estado' => $endereco->uf,
            'codigoCidade' => $endereco->ibge,
        ];
    }

    private function saveResponse($response)
    {
        $payer = $this->fatura->payer;

        Nfse
            ::query()
            ->updateOrCreate(
                ['fatura_id' => $this->fatura->id,],
                [
                    'empresas_id' => 200,
                    'status' => 'PROCESSANDO',
                    'id_tecnospeed' => $response->documents[0]->id,
                    'prestador' => $this->prestador,
                    'tomador' => $payer->cpf ?? $payer->cnpj,
                    'competencia' => $this->competencia,
                ]);
    }

    private function notifyErrorDiscord(string $errorMessage)
    {
        $this->fatura->payer->notify(new ErrorInNfseNotification($errorMessage));
    }
}
