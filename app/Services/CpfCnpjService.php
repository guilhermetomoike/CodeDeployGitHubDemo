<?php


namespace App\Services;


use http\Client;
use Illuminate\Support\Facades\Http;

class CpfCnpjService
{

    public function getCpf(string $document)
    {
        $package = config('services.cpf-cnpj.cpf_package');

        $data = $this->get($package, $document);

        if (isset($data->nascimento)) {
            $nascimento = \DateTime::createFromFormat('d/m/Y', $data->nascimento);

            $data->nascimento = date_format($nascimento, 'Y-m-d');
        }

        return json_encode($data);
    }

    public function getCnpj(string $document)
    {
        $package = config('services.cpf-cnpj.cnpj_package');

        return json_encode($this->get($package, $document));
    }

    public function get($package, $document)
    {
        $url = config('services.cpf-cnpj.url');
        $token = config('services.cpf-cnpj.token');

        $client = new \GuzzleHttp\Client();

        $request = $client->get(
            "{$url}/{$token}/{$package}/{$document}",
            [
                'content-type' => 'application/json'
            ],
        );

        return json_decode($request->getBody()->getContents());
    }
}
