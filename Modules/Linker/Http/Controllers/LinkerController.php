<?php

namespace Modules\Linker\Http\Controllers;

use App\Models\Arquivo;
use App\Models\Empresa;
use App\Models\GuiaLiberacao;
use App\Services\Nfse\Contracts\ApiNfse;
use Carbon\Carbon;
use CURLFile;
use Exception;
use finfo;
use GuzzleHttp\Psr7;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Linker\Entities\LinkerAgendar;
use Modules\Linker\Entities\LinkerCliente;
use Modules\Linker\Entities\LinkerPayments;
use Modules\Linker\Services\ILinkerMethodServices;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\File\File;

class LinkerController extends Controller
{

    private $storageS3;
    private $storageLocal;

    protected  $iLinkerMethodServices;


    public function __construct(ILinkerMethodServices $iLinkerMethodServices)
    {
        $this->iLinkerMethodServices = $iLinkerMethodServices;
    }

    public function verifToken()
    {
        return $this->iLinkerMethodServices->verifToken();
    }
    public function login()
    {
        return $this->iLinkerMethodServices->login();
    }
    public function index()
    {

        return LinkerCliente::query()->with('empresa.carteirasrel')
            ->join('clientes', 'clientes.id', 'linker_cliente.clientes_id')
            ->select('linker_cliente.*',  'clientes.nome_completo as cliente', 'clientes.cpf')->get();
    }


    public function showByid($empresa_id)
    {
        return LinkerCliente::query()->where('empresas_id', $empresa_id)->first();
    }

    public function pegar_faturamento(Request $request)
    {
        $empresa = Empresa::query()->with('faturamentos')->where('id', $request->get('empresas_id'))->first();
        $soma = 0;
        $index = 0;
        foreach ($empresa->faturamentos as $item) {
            if ($item->faturamento > 0) {
                $index++;
                $soma  = $item->faturamento + $soma;
            }
        }
        $total = $index > 0 ? $soma / $index : 0;
        return  intval(number_format($total, 2, '.', ''));
    }

    public function createConta(Request $request)
    {


        $arquivo = Arquivo::query()->where('model_type', 'empresa')->where('model_id', $request->get('empresas_id'))
            ->where('nome', 'LIKE', '%contrato_social%')
            ->latest()->first();





        $this->storageS3 = Storage::disk('s3');
        $this->storageLocal = Storage::disk('local');



        $pdf = $this->storageS3->get($arquivo->caminho);
        $this->storageLocal->put($arquivo->caminho, $pdf);
        $localPath = storage_path('app/private/') . $arquivo->caminho;

        $file = new File($localPath);

        // $arquivopost = new CURLFILE(
        //     $file->getRealPath(),
        //     $file->getMimeType(),
        //     $file->getFilename()
        // );


        // try {
        //     $file = ['file' => new CURLFILE($localPath)];
        //     return $file;
        // } catch (\Throwable $th) {
        //     return 'erro';
        // }
        $dados =  Empresa::query()->where('id', $request->get('empresas_id'))
            ->select(

                'empresas.id',
                'empresas.nome_empresa',
                'empresas.razao_social',
                'empresas.cnpj',
                'empresas.tipo_societario'
            )
            ->first();


        // return $request->all();
        $linker_cadastro = [
            'empresas_id' => $dados->id,
            'clientes_id' =>  $dados->socioAdministrador[0]->id,
            // 'token' => $request->get('token'),
            // 'permission_pay' => 0,

            'companyRevenue' => $request->get('companyRevenue'),
            'companyPartnerChanged' => $request->get('companyPartnerChanged'),
            'mailingAddress' => $request->get('mailingAddress1') == true ? 'residencial' : 'comercial',
            'partnerPEP' => $request->get('partnerPEP'),
        ];
        $linker_cliente  = LinkerCliente::query()->where('empresas_id', $request->get('empresas_id'))->first();
        if (isset($linker_cliente->id)) {
            LinkerCliente::query()->where('empresas_id', $request->get('empresas_id'))->update($linker_cadastro);
        } else {
            $linker_cliente =  LinkerCliente::create($linker_cadastro);
        }

        try {

            // 'base_uri' => 'https://accounts.kanon.linker.com.br'
            // 'Authorization' => 'Basic NGNnMTV2MWE3OG85cTg1NGk1ZXJ2OGg1MGo6OXFrYmY5aXBuaXJycjJtZjlnZHI2MWxnbjRhMzQ2NnFqdWFiY2R1OTVnN2FxODk0bjk5',
            // 'Authorization' => 'Basic MjNlZWYzZTg1c29mc2lrZms4YWk0YzA3ZzY6dDhtNGw0MjFvY2lkbzJ1b3RoOG41bjd2ZTBpZDFjMTFvdnIyZXI0c2x2NGJuZmV1NGNw',

            // 'base_uri' => 'https://accounts.sandbox.kanon.linker.com.br'


            if ($linker_cliente->id) {

                $client = new Client([
                    'headers' => [
                        'Accept'         => 'application/json',
                        'Authorization' => 'Basic ' . config('services.linker.token'),
                    ],
                    'base_uri' => 'https://accounts.kanon.linker.com.br'
                ]);




                $response = $client->request(
                    'POST',
                    '/accounts/create',
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
                            'name'     => 'email',
                            'contents' => $dados->socioAdministrador[0]->emails[0]->value,
                        ],
                        [
                            'name'     => 'phoneNumber',
                            'contents' => '55' . preg_replace("/[^0-9]/", "", $dados->socioAdministrador[0]->celulares[0]->value)
                        ],
                        [
                            'name'     => 'companyZipCode',
                            'contents' => $dados->endereco->cep,
                        ],
                        [
                            'name'     => 'companyCountry',
                            'contents' => 'BR',
                        ],
                        [
                            'name'     => 'companyCity',
                            'contents' => $dados->endereco->cidade,
                        ],
                        [
                            'name'     => 'companyNeighborhood',
                            'contents' => $dados->endereco->bairro,
                        ],
                        [
                            'name'     => 'companyState',
                            'contents' => $dados->endereco->uf,
                        ],
                        [
                            'name'     => 'companyStreet',
                            'contents' => strlen($dados->endereco->logradouro) > 40 ? substr($dados->endereco->logradouro, 0, 39) : $dados->endereco->logradouro
                        ],
                        [
                            'name'     => 'companyNumber',
                            'contents' => $dados->endereco->numero,
                        ],
                        [
                            'name'     => 'companyComplement',
                            'contents' => !$dados->endereco->complemento ? 'sem' : $dados->endereco->complemento,
                        ],
                        [
                            'name'     => 'companyRevenue',
                            'contents' => $request->get('companyRevenue'),
                        ],
                        [
                            'name'     => 'companyLegalFormat',
                            'contents' => $dados->tipo_societario,
                        ],
                        [
                            'name'     => 'companyPartnerChanged',
                            'contents' => $request->get('companyPartnerChanged'),
                        ],
                        [
                            'name'     => 'partnerZipCode',
                            'contents' => $dados->socioAdministrador[0]->endereco->cep,
                        ],
                        [
                            'name'     => 'partnerCity',
                            'contents' => $dados->socioAdministrador[0]->endereco->cidade,
                        ],
                        [
                            'name'     => 'partnerCountry',
                            'contents' => 'BR',
                        ],
                        [
                            'name'     => 'partnerNeighborhood',
                            'contents' => $dados->socioAdministrador[0]->endereco->bairro,
                        ],
                        [
                            'name'     => 'partnerState',
                            'contents' =>  $dados->socioAdministrador[0]->endereco->uf,
                        ],
                        [
                            'name'     => 'partnerStreet',
                            'contents' =>  strlen($dados->socioAdministrador[0]->endereco->logradouro) > 40 ? substr($dados->socioAdministrador[0]->endereco->logradouro, 0, 39) : $dados->socioAdministrador[0]->endereco->logradouro,
                        ],
                        [
                            'name'     => 'partnerNumber',
                            'contents' =>  $dados->socioAdministrador[0]->endereco->numero,
                        ],
                        [
                            'name'     => 'partnerComplement',
                            'contents' => !$dados->socioAdministrador[0]->endereco->complemento ? 'sem' : $dados->socioAdministrador[0]->endereco->complemento,
                        ],
                        [
                            'name'     => 'mailingAddress',
                            'contents' => $request->get('mailingAddress1') == 'residencial' ? $request->get('mailingAddress1') : $request->get('mailingAddress2'),
                        ],
                        [
                            'name'     => 'partnerPEP',
                            'contents' => $request->get('partnerPEP'),
                        ],
                        [
                            'name'     => 'document',
                            'contents' =>  Psr7\Utils::tryFopen($file->getRealPath(), 'r'),
                            'filename' => $file->getFilename()
                        ],

                    ]]
                );
            }
            LinkerCliente::query()->where('id', $linker_cliente->id)->update(['status' => json_decode($response->getBody())->status]);


            return response()->json(json_decode($response->getBody())->status, 200);
        } catch (BadResponseException $e) {
            $error_message = $e->getResponse()->getBody()->getContents();
            return  $error_message;
        }
    }

    public function updateConta($id, Request $request)
    {
        $mensage1 = '';
        $mensage = '';


        $linker_cliente = LinkerCliente::FindOrFail($id);

        // if (!empty($request->token)) {
        //     $linker_cliente->token = $request->get('token');

        //     $data1 =    json_decode($this->aprovarTokenPayments($id, $request));
        //     try{
        //         $mensage1 = $data1->message->text;


        //       }catch(Exception $e){
        //           $mensage1 = $data1->message;
        // LinkerCliente::query()->where('id', $id)->update(['permission_pay' => 1]);



        //       }
        // }
        if (!empty($request->token_extrato)) {
            $linker_cliente->token_extrato =  $request->get('token_extrato');

            $data2 =      json_decode($this->aprovarTokenExtrato($id, $request));

            try {

                $mensage = $data2->message->text;
            } catch (Exception $e) {
                LinkerCliente::query()->where('id', $id)->update(['permission_pay' => 2]);

                $mensage = $data2->message;
            }
        }

        $linker_cliente->save();


        return response()->json('Pagamento: ' . $mensage1  . ' ' .  'Extrato: ' . $mensage, 200);
    }
    public function requestTokenPayments($id, Request $request)
    {
        return $this->iLinkerMethodServices->requestTokenPayments($id, $request);
    }
    public function aprovarTokenPayments($id, Request $request)
    {
        return $this->iLinkerMethodServices->aprovarTokenPayments($id, $request);
    }

    public function requestTokenExtrato($id, Request $request)
    {
        return $this->iLinkerMethodServices->requestTokenExtrato($id, $request);
    }
    public function aprovarTokenExtrato($id, Request $request)
    {
        return $this->iLinkerMethodServices->aprovarTokenExtrato($id, $request);
    }


    public function agendarPayments()
    {
        $linker_payments = [];
        $data = [];
        $linker_cliente =  LinkerCliente::where('permission_pay', 2)->join('empresas', 'empresas.id', 'linker_cliente.empresas_id')
            ->select('linker_cliente.id', 'linker_cliente.empresas_id', 'empresas.cnpj')->where('linker_cliente.id', 1)->first();
        //vericar saldo 

        // foreach ($linker_clientes as $linker_cliente) {

        $guias = [];

        //pegar codigo de barras

        $guaiLiberacao = GuiaLiberacao::orderBy('created_at', 'desc')->where('empresa_id', 74)->first();

        $guias = $guaiLiberacao
            ->guias()
            ->where('data_competencia', $guaiLiberacao->competencia)
            ->with('arquivo')
            ->get();

        // return $guias;

        $guia = [];
        $data = [];

        foreach ($guias as $item) {

            if (!empty($item['barcode'])) {
                $guia[] = ['tipo' => $item['tipo'], 'linker_cliente_id' => $linker_cliente->id, 'cnpj' => $linker_cliente->cnpj, 'guias_id' => $item['id'], 'description' => 'pagamento da guia ' . $item['tipo'], 'barcode' => str_replace(" ", "", $item['barcode']),  'amount' => $item['valor'][strtolower($item['tipo'])]];
            }
        }
        // }
        foreach ($guia as $g) {
            LinkerAgendar::create($g);
        }
    }


    public function payBarCode()
    {


        $agendamentos = LinkerAgendar::get();


        
        // $client = new Client([
        //     'headers' => [
        //         'Accept'         => 'application/json',
        //         'Authorization' => 'Basic ' . config('services.linker.token'),
        //     ],
        //     'base_uri' => 'https://ledger.kanon.linker.com.br'
        // ]);

        // $response = $client->request(
        //     'GET',
        //     '/statement/22896023000169?page=2&start=2022-04-01&end=2022-04-06' );

        try {
            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->verifToken(),
                ],
                'base_uri' => 'https://payments.kanon.linker.com.br'
            ]);

            foreach ($agendamentos as $g) {
                if ($g->tipo == 'FGTS') {
                    $response = $client->request(
                        'POST',
                        '/v1/pay?cnpj=' . $g->cnpj,
                        ['multipart' => [
                            [
                                'name'     => 'barcode',
                                'contents' => $g->barcode
                            ],

                            [
                                'name'     => 'amount',
                                'contents' => $g->amount
                            ],
                            [
                                'name'     => 'description',
                                'contents' => $g->description
                            ],
                        ]]
                    );
                    // $g->payment_day = Carbon::now();
                    // $g->save();
                    return response()->json(json_decode($response->getBody()));



                    // $linker_payments =  [
                    //     "linker_payments_id" => json_decode($response->getBody())->id,
                    //     "account" =>  json_decode($response->getBody())->account,
                    //     "id_external" => $g->id,
                    //     "id_adjustment" =>  json_decode($response->getBody())->id_adjustment ?? null,
                    //     "barcode" =>  $g->barcode,
                    //     "due_date" => json_decode($response->getBody())->due_date ?? '2022-01-20',
                    //     "description" => "pagamento da guia " . $g['tipo'],
                    //     "assignor" => json_decode($response->getBody())->assignor ?? '',
                    //     "assignor_document" => null,
                    //     "discount" => 0,
                    //     "interest" => 0,
                    //     "fine" => 0,
                    //     "amount" =>  json_decode($response->getBody())->amout ?? $g['amount'],
                    //     "transaction_code" => json_decode($response->getBody())->transaction_code ?? null,
                    //     "transaction_date" =>  json_decode($response->getBody())->transaction_date ?? null,
                    //     "payment_confirmation" =>   json_decode($response->getBody())->payment_confirmation ?? null,
                    //     "id_schedule" => "",
                    //     "schedule_date" =>  null,
                    //     "status" => 1,
                    //     'linker_cliente_id' => $g->linker_cliente_id,
                    //     'guias_id' => $g->guias_id
                    // ];

                    // $data[] =   LinkerPayments::create($linker_payments);

                    // $linker_payments =  [
                    //     "linker_payments_id" => 38389, //json_decode($response->getBody())->id
                    //     "account" => 16996,
                    //     "id_external" => 31598,
                    //     "id_adjustment" => null  , //json_decode($response->getBody())->id_adjustment;
                    //     "barcode" => "858000000089502503852137230716213090810135884576",
                    //     "due_date" => "2021-01-10",
                    //     "description" => "pagamento da guia INSS",
                    //     "assignor" => "DARF/DARF-SIMPLES 0385",
                    //     "assignor_document" => null ,
                    //     "discount" => 0,
                    //     "interest" => 0,
                    //     "fine" => 0,
                    //     "amount" => 850.25,
                    //     "transaction_code" => "952175353-3638-738654093 385987-219914-599631",
                    //     "transaction_date" => "2021-11-10 08:32:48.742000",
                    //     "payment_confirmation" =>  null ,
                    //     "id_schedule" => "",
                    //     "schedule_date" =>  null ,
                    //     "status" => 1,
                    //     'linker_cliente_id' => $linker_cliente->id,
                    //     'guias_id' => $g['id']
                    // ];

                    // $linker_payments['barcode'] = json_decode($response->getBody())->barcode;
                    // $linker_payments['due_date'] = json_decode($response->getBody())->due_date;
                    // $linker_payments['description'] = json_decode($response->getBody())->description;





                    // $linker_payments = [];

                }
            }
            return response()->json('nao era pra cair aqui',200);
        } catch (BadResponseException $e) {
            $error_message = $e->getResponse()->getBody()->getContents();
            return  response()->json($error_message);
        }
    }

    public function relatorioClientesLinker(Request $request)
    {
        $data = $this->index();



        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio  Clientes Linker Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio  Clientes Linker  Medb');

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:F1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(55);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(10);



        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'Empresa');
        $sheet->setCellValue('C3', 'Cnpj');
        $sheet->setCellValue('D3', 'Cliente');
        $sheet->setCellValue('E3', 'Cpf');
        $sheet->setCellValue('F3', 'Carteiras');




        $sheet->getStyle("A3:F3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $item) {
            $pass = false;

            $carteiras = '';

            $tamanhoH = count($item->empresa->carteirasrel);
            if (count($item->empresa->carteirasrel) >   $tamanhoH) {


                $sheet->getColumnDimension('F')->setWidth($tamanhoH * 13);
            }
            foreach ($item->empresa->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }

                if ($carteira->id == $request->carteira_id) {
                    $pass = true;
                } else {
                    $pass = $request->carteira_id > 0 ? false : true;
                }
            }

            if ($pass) {

                $sheet->setCellValue('A' . $i, $item->id)
                    ->setCellValue('B' . $i, $item->empresa->getName())
                    ->setCellValue('C' . $i, $item->empresa->cnpj . " ")
                    ->setCellValue('D' . $i, $item->cliente)
                    ->setCellValue('E' . $i, $item->cpf)

                    ->setCellValue('F' . $i, $carteiras);



                $i++;
            }
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:F' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }
}
