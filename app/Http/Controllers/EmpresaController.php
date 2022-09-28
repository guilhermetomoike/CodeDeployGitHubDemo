<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpresaStoreRequest;
use App\Http\Resources\ClienteResource;
use App\Http\Resources\EmpresaResource;
use App\Http\Resources\EmpresaTrashedResource;
use App\Http\Resources\EmpresaWithContratoResource;
use App\Http\Resources\EmpresaWithStatusResouce;
use App\Models\ActivityLog;
use App\Models\Carteira;
use App\Models\CarteiraEmpresa;
use App\Models\Cliente;
use App\Models\Contato;
use Illuminate\Support\Collection;

use App\Models\Empresa;
use App\Models\MotivoDesativar;
use App\Services\Empresa\CongelarEmpresaService;
use App\Services\Empresa\CreateEmpresaService;
use App\Services\Empresa\UpdateEmpresaService;
use App\Services\EmpresaService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class EmpresaController extends Controller
{
    private EmpresaService $empresaService;

    public function __construct(EmpresaService $empresaService)
    {
        $this->empresaService = $empresaService;
    }

    public function index(Request $request)
    {
        if (is_a($this->getCurrentUser(), Cliente::class)) {
            return EmpresaWithStatusResouce::collection($this->getCurrentUser()->empresa);
        }
        $empresas = Empresa::withTrashed()->get();
        return EmpresaResource::collection($empresas);
    }

    public function store(EmpresaStoreRequest $request, CreateEmpresaService $createEmpresaService)
    {
        $data = $request->validated();
        try {
            $empresa = $createEmpresaService->execute($data);
            return response()->json($empresa);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function show(int $id)
    {
        validator(['id' => $id,], ['id' => 'exists:empresas'])->validate();
        $empresa = $this->empresaService->getEmpresa($id);
        if ($empresa->trashed() && auth('api_clientes')->user()) {
            return $this->errorResponse('Empresa Desativada.', 404);
        } else if ($empresa->trashed()) {
            $data = new EmpresaTrashedResource($empresa);
            return response()->json(compact('data'));
        }
        return new EmpresaWithStatusResouce($empresa);
    }

    public function update(Request $request, UpdateEmpresaService $updateEmpresaService, $id)
    {
        $data = $request->all();
        $empresa = $updateEmpresaService->execute($id, $data);
        return new EmpresaWithStatusResouce($empresa);
    }

    public function socios(int $id)
    {
        try {
            $socios = Empresa::findOrFail($id)->socios()->select('*')->get();
            return ClienteResource::collection($socios);
        } catch (ModelNotFoundException $exception) {
            return response(['message' => 'Empresa não existe ou está desativada.'], 404);
        }
    }

    public function search($search)
    {
        $empresas = $this->empresaService->searchEmpresa($search);
        if (!$empresas) {
            return $this->noContent();
        }
        return EmpresaResource::collection($empresas);
    }

    public function congelamento(Request $request, CongelarEmpresaService $congelarEmpresaService)
    {
        try {
            $empresa = $congelarEmpresaService->execute($request->all());
        } catch (\Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }
        return new EmpresaWithStatusResouce($empresa);
    }

    public function desativar(Request $request, int $id)
    {
        $this->empresaService->desativarEmpresa($id, $request->all());
        return $this->successResponse();
    }

    public function motivosDesativar()
    {
        return MotivoDesativar::get();
    }

    public function storeAcessoNfse(Request $request, $id)
    {
        $saved = $this->empresaService->cadastrarAcessoNfse($id, $request->all(['site', 'login', 'senha']));
        if (!$saved) {
            return $this->errorResponse();
        }
        return $this->successResponse($request->all());
    }


    public function getEmailEnvio(int $id)
    {
        $emails = $this->empresaService->getNotifiableEmail($id);
        return response($emails);
    }

    public function addArquivo(Request $request, int $id)
    {
        $empresa = Empresa::find($id);
        return $empresa->addArquivo(
            $request['arquivo_id'],
            $request->tipo ?? $id,
            ['tipo' => $request['tipo']]
        );
    }

    public function getCarteiras(Request $request, int $id)
    {
        $empresa = Empresa::withTrashed()->where('id', $id)->first();
        return response()->json(['data' => $empresa->carteiras], 200);
    }

    public function addCarteira(Request $request, int $id)
    {
        $empresa = Empresa::find($id);
        $carteira = Carteira::find($request->get('carteira_id'));
        $empresa->carteiras()->syncWithoutDetaching($carteira);
        return response()->json(['message' => 'Carteira vinculada com sucesso.'], 200);
    }

    public function addCarteiras(Request $request, int $id)
    {
        $empresa = Empresa::find($id);

        foreach ($request->get('carteiras') as $carteira_id) {

            $exist = DB::table('carteira_empresa')->where('empresa_id', $id)->where('carteira_id', $carteira_id)->first();
            // return response()->json($exist,200);
            if (!isset($exist->carteira_id)) {
                $carteira = Carteira::find($carteira_id);
                $empresa->carteiras()->syncWithoutDetaching($carteira);
            }
            $exist =[];
        }
        return response()->json(['message' => 'Carteiras vinculadas com sucesso.'], 200);
    }
    public function removeCarteira(Request $request, int $id)
    {
        $empresa = Empresa::find($id);
        $carteiraId = $request->get('carteira_id');
        $empresa->carteiras()->detach($carteiraId);
        return response()->json(['message' => 'Carteira removida com sucesso.'], 200);
    }

    public function getEmpresaContrato(int $id)
    {
        $empresa = Empresa
            ::with(['contrato' => fn ($query) => $query->with('arquivos')])
            ->find($id);
        return new EmpresaWithContratoResource($empresa);
    }

    public function getRequiredGuidesByEmpresa($empresa_id)
    {
        $empresa = Empresa::findOrFail($empresa_id)->required_guide;
        return response($empresa);
    }

    public function setRequiredGuidesByEmpresa(Request $request, $empresa_id)
    {
        $empresa = Empresa::findOrFail($empresa_id);
        $this->empresaService->setRequiredGuidesByEmpresa($empresa, $request->all());
        return response($empresa->required_guide);
    }

    public function changeTribucacaoFrequency(Request $request, int $id)
    {
        $empresa = Empresa::query()->find($id);
        $empresa->trimestral = $request->trimestral;
        $empresa->save();
        return new JsonResponse(['message' => 'Alterado com sucesso', 'data' => $empresa]);
    }

    public function getTribucacaoFrequency(int $id)
    {
        $empresa = Empresa::query()->find($id);
        return new JsonResponse(['trimestral' => $empresa->trimestral]);
    }

    public function cancel($id)
    {
        Empresa::find($id)->delete();

        return new JsonResponse(['message' => 'Empresa Cancelada com sucesso']);
    }

    public function reativarEmpresaStatus(Request $request)
    {
      Empresa::where('id',$request->empresas_id)->withTrashed()->update(['congelada'=>0,'saiu'=>0,'status_id'=>$request->status,'deleted_at'=>null]);

        return new JsonResponse(['msg' => 'Empresa atualizada']);
    }
    
    public function relatorioEmpresas(Request $request)
    {

        // ini_set('max_execution_time', 180); //3 minutes
        // ini_set ("memory_limit", "10056M");

        $data =     Empresa::withTrashed()
            ->select('id', 'razao_social', 'cnpj', 'regime_tributario', 'status_id', 'saiu', 'congelada')
            ->with('residencia_medica')
            ->get();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Faturas Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Faturas');

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:G1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(60);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);



        $sheet->setCellValue('A3', 'ID')->setCellValue('B3', 'razao_social')->setCellValue('C3', 'cnpj')->setCellValue('D3', 'regime_tributario')
            ->setCellValue('E3', 'status');

        $sheet->getStyle("A3:G3")->getFont()->setBold(true);
        $i = 4;

        $carteiras = $request->get('carteira');


        foreach ($data as $item) {
            if ($item->saiu || $item->trashed()) {
                $status = 'desativada';
            } else if ($item->congelada) {
                $status = 'congelada';
            } else if ($item->status_id == 70) {
                $status = 'desativacao_agendada';
            } else if ($item->status_id < 100) {
                $status = 'abertura';
            } else {
                $status = 'normal';
            }
            if ($item->residencia_medica ? true : false) {
                $status = 'residencia';
            }

            if ($status == $request->get('status')) {


                $sheet->setCellValue('A' . $i, $item->id)->setCellValue('B' . $i, $item->razao_social)->setCellValue('C' . $i, $this->formata_cpf_cnpj($item->cnpj))
                    ->setCellValue('D' . $i, $item->regime_tributario)->setCellValue('E' . $i, $status);
                $i++;
            } else if ($request->get('status') == null) {
                $sheet->setCellValue('A' . $i, $item->id)->setCellValue('B' . $i, $item->razao_social)->setCellValue('C' . $i, $this->formata_cpf_cnpj($item->cnpj))
                    ->setCellValue('D' . $i, $item->regime_tributario)->setCellValue('E' . $i, $status);
                $i++;
            }
        }


        $sheet->getPageSetup()->setPrintArea('A1:D' . intval($i));

        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="' . $filename . '"');
        // header('Cache-Control: max-age=0');


        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }
    function formata_cpf_cnpj($cpf_cnpj)
    {
        /*
            Pega qualquer CPF e CNPJ e formata
    
            CPF: 000.000.000-00
            CNPJ: 00.000.000/0000-00
        */

        ## Retirando tudo que não for número.
        $cpf_cnpj = preg_replace("/[^0-9]/", "", $cpf_cnpj);



        $bloco_1 = substr($cpf_cnpj, 0, 2);
        $bloco_2 = substr($cpf_cnpj, 2, 3);
        $bloco_3 = substr($cpf_cnpj, 5, 3);
        $bloco_4 = substr($cpf_cnpj, 8, 4);
        $digito_verificador = substr($cpf_cnpj, -2);
        $cpf_cnpj_formatado = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "/" . $bloco_4 . "-" . $digito_verificador;


        return $cpf_cnpj_formatado;
    }


    public function TimeTempoEmpresas()
    {
        $dataSet  =   DB::select("
        select id,
        subject_id,
        created_at,
        json_unquote(json_extract(`properties`, '$.\"old\" . \"status_id\"'))   old_status,
        json_unquote(json_extract(`properties`, '$.\"attributes\".\"status_id\"')) new_status
     from `activity_log`
     where `subject_type` = 'empresa'
       and created_at > '2020-01-01 00:00:00'
       and json_unquote(json_extract(`properties`, '$.\"old\".\"status_id\"')) not in (1, 70, 71, 80, 81, 100)
       and json_unquote(json_extract(`properties`, '$.\"attributes\".\"status_id\"')) not in (1, 70, 71, 80, 81, 100)
       and json_unquote(json_extract(`properties`, '$.\"old\".\"status_id\"')) <>
           json_unquote(json_extract(`properties`, '$.\"attributes\".\"status_id\"'))
     ");

        $dividBy =  1;
        $dataSet = new Collection($dataSet);
        $statusIdNeeded = [3, 4, 5, 6, 7];

        $label = [
            "Certificado",
            "CNPJ",
            "Alvará",
            "NFSE",
            "Simples",
        ];
        $data = [];

        $groupedDataBySubject = $dataSet
            ->groupBy('subject_id')
            ->map(function (Collection $itemsByCompany) use ($statusIdNeeded) {
                $times = [];
                foreach ($statusIdNeeded as $status_id) {
                    $startedAt = $itemsByCompany
                        ->filter(fn ($item) => $item->new_status == $status_id)
                        ->first()->created_at ?? false;

                    $finishedAt = $itemsByCompany
                        ->filter(fn ($item) => $item->old_status == $status_id)
                        ->first()->created_at ?? false;

                    if ($startedAt && $finishedAt) {
                        $times[$status_id] = (strtotime($finishedAt) - strtotime($startedAt)) / 60;
                    }
                }

                return $times;
            });

        return $groupedDataBySubject;

        $status = [3 => "Certificado", 4 => "CNPJ", 5 => "Alvará", 6 => "NFSE", 7 => "Simples"];

        $empresasTimes = [];
        $empresa = (object)[];
        for ($i = 0; $i < 2000; $i++) {
            if (isset($groupedDataBySubject[$i])) {
                if ($groupedDataBySubject[$i] != []) {
                    $empresa =   Empresa::where('id', $i)->select('id', 'nome_empresa', 'cnpj')->first();
                    //  return $empresa->nome_empresa;
                    if (isset($empresa->id)) {

                        for ($j = 3; $j < 8; $j++) {

                            if (isset($groupedDataBySubject[$i][$j])) {
                                $labels[$i][] = [$status[$j] => number_format((round($groupedDataBySubject[$i][$j] / 60) / $dividBy), 2)];
                            }
                        }
                        $empresasTimes[] = ['empresas_id' => $empresa->id, 'nome' => $empresa->nome_empresa, 'cnpj' => $empresa->cnpj, 'times' => $labels];
                    }
                }
            }
            $empresa = (object)[];
            $labels = [];
        }

        // return $empresasTimes;

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Times Abertura Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Times Abertura ');

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:G1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(60);
        $sheet->getColumnDimension('C')->setWidth(22);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);


        $sheet->setCellValue('A3', 'ID')->setCellValue('B3', 'nome')->setCellValue('C3', 'Certificado')->setCellValue('D3', 'Certificado')->setCellValue('E3', 'CNPJ')
            ->setCellValue('F3', 'Alvará')->setCellValue('G3', 'NFSE')->setCellValue('H3', 'Simples');

        $sheet->getStyle("A3:H3")->getFont()->setBold(true);
        $i = 4;



        foreach ($empresasTimes as $item) {



            $sheet->setCellValue('A' . $i, $item['empresas_id'])
                ->setCellValue('B' . $i, $item['nome'])
                ->setCellValue('C' . $i, $this->formata_cpf_cnpj($item['cnpj']))
                ->setCellValue('D' . $i, isset($item['times'][$item['empresas_id']][0]['Certificado']) ?  $item['times'][$item['empresas_id']][0]['Certificado'] : null)
                ->setCellValue('E' . $i, isset($item['times'][$item['empresas_id']][1]['CNPJ']) ?  $item['times'][$item['empresas_id']][1]['CNPJ'] : null)
                ->setCellValue('F' . $i, isset($item['times'][$item['empresas_id']][2]['Alvará']) ?  $item['times'][$item['empresas_id']][2]['Alvará'] : null)
                ->setCellValue('G' . $i, isset($item['times'][$item['empresas_id']][3]['NFSE']) ?  $item['times'][$item['empresas_id']][3]['NFSE'] : null)
                ->setCellValue('H' . $i, isset($item['times'][$item['empresas_id']][4]['Simples']) ?  $item['times'][$item['empresas_id']][4]['Simples'] : null);
            $i++;
        }


        $sheet->getPageSetup()->setPrintArea('A1:H' . intval($i));

        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="' . $filename . '"');
        // header('Cache-Control: max-age=0');


        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    public function EmpresaDataAtiva()
    {
      
      
        $dates = ActivityLog::where('properties','like','%"status_id": 100%')
        ->where('description','updated')
        ->select('updated_at','subject_id')
        ->get();
   

        foreach($dates as $emp){
            $carteiras ='';
            
          $lib = Empresa::where('id',$emp->subject_id)->first(); 
          
          if (isset($lib->carteirasrel)) {  
            foreach ($lib->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }
            $data[] = ['id' => $lib->id, 'empresa' => $lib->razao_social, 'cnpj' => $lib->cnpj, 'data' => Carbon::parse($emp->updated_at)->format('d/m/Y'), 'carteira' => $carteiras];

        }
        }
      


        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio data empresa ativa Medb.xlsx';
        $ultimaletra = 'E';

        $sheet->setCellValue('A1', 'Relatorio Times Abertura ');

        $sheet->getStyle("A1:".$ultimaletra."1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:".$ultimaletra."1")->getFont()->setSize(18);
        $sheet->mergeCells("A1:E1");

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(60);
        $sheet->getColumnDimension('C')->setWidth(22);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(16);
    

        $sheet
        ->setCellValue('A3', 'ID')
        ->setCellValue('B3', 'empresa')
        ->setCellValue('C3', 'CNPJ')
        ->setCellValue('D3', 'Data')
        ->setCellValue('E3', 'Carteiras');

        $sheet->getStyle("A3:".$ultimaletra."3")->getFont()->setBold(true);
        $i = 4;

      

        foreach ($data as $item) {

            

            $sheet->setCellValue('A' . $i, $item['id'])
                ->setCellValue('B' . $i, $item['empresa'])
                ->setCellValue('C' . $i, $this->formata_cpf_cnpj($item['cnpj']))
                ->setCellValue('D' . $i, $item['data'] )
                ->setCellValue('E' . $i,$item['carteira']);
             $i++;
        }


        $sheet->getPageSetup()->setPrintArea("A1:".$ultimaletra.intval($i));

        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="' . $filename . '"');
        // header('Cache-Control: max-age=0');


        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }


    public function relatorioDDD()
    {
              
      
        $empcon = Empresa::get();
    
        // query()->with('contatos')
        // ->get();
   
        
        $ufs = [
            'DF'=>[61],
            'GO'=>[62,64],
            'MT'=>[65,66],
            'MS'=>[67],
            'AL'=>[82],
            'BA'=>[71,73,74,75,77] ,
            'CE'=>[85,88],
            'MR'=>[98,99],
            'PB'=>[83],
            'PE'=>[81,87],
            'PI'=>[86,89],
            'RG'=>[84],
            'SE'=>[79],
            'AC'=>[68],
            'AP'=>[98],
            'AM'=>[92,97],
            'PA'=>[91,93,94],
            'RO'=>[69],
            'RR'=>[95],
            'TO'=>[63],
            'ES'=>[27,28],
            'MG'=>[31,32,33,34,35,37,38],
            'RJ'=>[21,22,24],
            'SP'=>[11,12,13,14,15,16,17,18,19],
            'PR'=>[41,42,43,44,45,46],
            'RS'=>[51,53,54,55],
            'SC'=>[47,48,49],
   ];
        foreach($empcon as $emp){
            $carteiras ='';
            $ddd = '';
            $ufddd = '';
          
          if (isset($emp->carteirasrel)) {  
            foreach ($emp->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }

            if(substr($emp->contatos()->whatsapp(), 2, 3) == '+55'){
        $ddd =  substr($emp->contatos()->whatsapp(), 5, 2);
            }else{
               $ddd =  substr($emp->contatos()->whatsapp(),2, 2);
            }

            foreach($ufs  as $index => $uf){
  if(in_array($ddd, $uf)) {
      $ufddd = $index;
  }

            }

            $data[] = [
                'id' => $emp->id, 
                'empresa' => $emp->razao_social, 
                'cnpj' => $emp->cnpj, 
                'ddd' =>  $ddd,
                'ufddd'=> $ufddd,
                'carteira' => $carteiras
                ];

        }
        }

        // return $data;


      
    

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio DDD estado carteira Medb.xlsx';
        $ultimaletra = 'F';

        $sheet->setCellValue('A1', 'Relatorio DDD estado carteira');

        $sheet->getStyle("A1:".$ultimaletra."1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:".$ultimaletra."1")->getFont()->setSize(18);
        $sheet->mergeCells("A1:F1");

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(60);
        $sheet->getColumnDimension('C')->setWidth(22);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(10);
    

        

        $sheet
        ->setCellValue('A3', 'ID')
        ->setCellValue('B3', 'empresa')
        ->setCellValue('C3', 'CNPJ')
        ->setCellValue('D3', 'DDD')
        ->setCellValue('E3', 'UF')
        ->setCellValue('F3', 'Carteiras');

        $sheet->getStyle("A3:".$ultimaletra."3")->getFont()->setBold(true);
        $i = 4;

      
   


        foreach ($data as $item) {

            

            $sheet->setCellValue('A' . $i, $item['id'])
                ->setCellValue('B' . $i, $item['empresa'])
                ->setCellValue('C' . $i, $this->formata_cpf_cnpj($item['cnpj']))
                ->setCellValue('D' . $i, $item['ddd'] )
                ->setCellValue('E' . $i, $item['ufddd'] )

                ->setCellValue('F' . $i,$item['carteira']);
             $i++;
        }


        $sheet->getPageSetup()->setPrintArea("A1:".$ultimaletra.intval($i));

        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="' . $filename . '"');
        // header('Cache-Control: max-age=0');


        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }
}

