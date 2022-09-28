<?php


namespace Modules\Linker\Repositories;

use App\Models\Empresa;
use Carbon\Carbon;
use Modules\Linker\Entities\LinkerCliente;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Linker\Services\ILinkerMethodServices;

class LinkerRepository implements ILinkerMethodServices
{
    /**
     * @var CartaoCredito
     */
    private LinkerCliente $linker;
    private Empresa $empresa;


    /**
     * CartaoCreditoRepository constructor.
     */
    public function __construct(Empresa $empresa, LinkerCliente $linker)
    {

        $this->linker = $linker;
        $this->empresa = $empresa;
    }

    public function requestTokenPayments($id, $data)
    {
        try {
            $dados =  $this->empresa->where('id', $data->get('empresas_id'))
                ->select(
                    'empresas.id',
                    'empresas.nome_empresa',
                    'empresas.razao_social',
                    'empresas.cnpj',
                    'empresas.tipo_societario'
                )
                ->first();

            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->verifToken(),
                ],
                'base_uri' => 'https://payments.kanon.linker.com.br'
            ]);

            $response = $client->request(
                'POST',
                '/payments/permission/request',
                ['multipart' => [
                    [
                        'name'     => 'cpf',
                        'contents' => $dados->socioAdministrador[0]->cpf
                    ],

                    [
                        'name'     => 'cnpj',
                        'contents' => $dados->cnpj
                    ],
                    [
                        'name'     => 'action',
                        'contents' => "PROCESS"
                    ]
                ]]
            );


            return $response->getBody();
        } catch (BadResponseException $e) {
            $error_message = $e->getResponse()->getBody()->getContents();
            if (json_decode($error_message)->message  == 'Permission already requested') {
               return $this->repitTokenRequest($id,$dados);
            }
            return  $error_message;
        }
    }

    public function aprovarTokenPayments($id,  $data)
    {
        try {
            // $linker_cliente =  $this->linker::where('id', $id)->first();

            $dados =  Empresa::query()->where('id', $data->get('empresas_id'))
                ->select(

                    'empresas.id',
                    'empresas.nome_empresa',
                    'empresas.razao_social',
                    'empresas.cnpj',
                    'empresas.tipo_societario'
                )
                ->first();



            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->verifToken(),
                ],
                'base_uri' => 'https://payments.kanon.linker.com.br'
            ]);

            $response = $client->request(
                'POST',
                '/payments/permission/approve',
                ['multipart' => [
                    [
                        'name'     => 'cpf',
                        'contents' => $dados->socioAdministrador[0]->cpf
                    ],

                    [
                        'name'     => 'cnpj',
                        'contents' => $dados->cnpj
                    ],
                    [
                        'name'     => 'action',
                        'contents' => "PROCESS"
                    ],
                    [
                        'name'     => 'token',
                        'contents' => $data->token
                    ]
                ]]
            );

            LinkerCliente::query()->where('id', $id)->update(['permission_pay' => 2]);
            return  json_decode($response->getBody());
        } catch (BadResponseException $e) {
            $error_message = $e->getResponse()->getBody()->getContents();
            return  $error_message;
        }
    }


    public function verifToken()
    {
        $linkerAPI = DB::table('apis')->where('id', '5')->first();
        if (Carbon::now() >= $linkerAPI->expires_token) {
            return  $this->login();
        } else {
            return  $linkerAPI->token;
        }
    }
    public function login()
    {
        try {
            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic ' . config('services.linker.token'),
                    'Cookie' => 'XSRF-TOKEN=8ce8cab8-cb48-4c2a-ace5-bc443f5dcd0a'
                ],
                'base_uri' => 'https://oauth.linker.com.br'
            ]);

            $response = $client->request('POST', '/oauth2/token?grant_type=client_credentials');

            DB::table('apis')->where('id', '5')->update(['token' =>  json_decode($response->getBody())->access_token, 'expires_token' => Carbon::now()->addHours(1)]);
            return json_decode($response->getBody())->access_token;
        } catch (\Exception $exception) {

            return $exception->getMessage();
        }
    }

    public function requestTokenExtrato($id, $data)
    {
        try {
            $dados =  $this->empresa->where('id', $data->get('empresas_id'))
                ->select(
                    'empresas.id',
                    'empresas.nome_empresa',
                    'empresas.razao_social',
                    'empresas.cnpj',
                    'empresas.tipo_societario'
                )
                ->first();

            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . config('services.linker.token'),
                ],
                'base_uri' => 'https://ledger.kanon.linker.com.br'
            ]);

            $response = $client->request(
                'POST',
                '/permission/request',
                ['multipart' => [
                    [
                        'name'     => 'cpf',
                        'contents' => $dados->socioAdministrador[0]->cpf
                    ],

                    [
                        'name'     => 'cnpj',
                        'contents' => $dados->cnpj
                    ],
                    [
                        'name'     => 'action',
                        'contents' => "READ"
                    ]
                ]]
            );

            LinkerCliente::query()->where('id', $id)->update(['permission_pay' => 1]);
            return  $response->getBody();
        } catch (BadResponseException $e) {
            $error_message = $e->getResponse()->getBody()->getContents();
            return  $error_message;
        }
    }

    public function aprovarTokenExtrato($id,  $data)
    {

        try {
            // $linker_cliente =  $this->linker::where('id', $id)->first();

            $dados =  Empresa::query()->where('id', $data->get('empresas_id'))
                ->select(

                    'empresas.id',
                    'empresas.nome_empresa',
                    'empresas.razao_social',
                    'empresas.cnpj',
                    'empresas.tipo_societario'
                )
                ->first();



            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . config('services.linker.token'),
                ],
                'base_uri' => 'https://ledger.kanon.linker.com.br'
            ]);

            $response = $client->request(
                'POST',
                '/permission/approve',
                ['multipart' => [
                    [
                        'name'     => 'cpf',
                        'contents' => $dados->socioAdministrador[0]->cpf
                    ],

                    [
                        'name'     => 'cnpj',
                        'contents' => $dados->cnpj
                    ],
                    [
                        'name'     => 'action',
                        'contents' => "READ"
                    ],
                    [
                        'name'     => 'token',
                        'contents' => $data->token_extrato
                    ]
                ]]
            );

            // LinkerCliente::query()->where('id', $id)->update(['permission_pay' => 2]);
            return  $response->getBody();
        } catch (BadResponseException $e) {
            $error_message = $e->getResponse()->getBody()->getContents();
            return  $error_message;
        }
    }

    public function repitTokenRequest($id, $dados)
    {
        try {
         

            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->verifToken(),
                ],
                'base_uri' => 'https://payments.kanon.linker.com.br'
            ]);

            $response = $client->request(
                'POST',
                '/payments/permission/token',
                ['multipart' => [
                    [
                        'name'     => 'cpf',
                        'contents' => $dados->socioAdministrador[0]->cpf
                    ],

                    [
                        'name'     => 'cnpj',
                        'contents' => $dados->cnpj
                    ],
                    [
                        'name'     => 'action',
                        'contents' => "PROCESS"
                    ]
                ]]
            );


            return $response->getBody();
        } catch (BadResponseException $e) {
            $error_message = $e->getResponse()->getBody()->getContents();

            return  $error_message;
        }
    }
}
