<?php

namespace Modules\Irpf\Http\Controllers;

use App\Models\Arquivo;

use App\Services\FileService ;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Irpf\Entities\DeclaracaoIrpf;
use Modules\Irpf\Entities\IrpfQuestionario;
use Modules\Irpf\Http\Requests\IrpfAttachmentRequest;
use Modules\Irpf\Services\GenerateDociePdf;
use Modules\Irpf\Services\IrpfService;
use Modules\Irpf\Transformers\IrpfClientesListResource;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class IrpfController extends Controller
{
    private IrpfService $irpfService;
    private GenerateDociePdf $generateDociePdf;

    public function __construct(IrpfService $irpfService, GenerateDociePdf $generateDociePdf)
    {
        $this->irpfService = $irpfService;
        $this->generateDociePdf = $generateDociePdf;
    }

    public function getDeclaracao(int $cliente_id)
    {
        $declaracao = DeclaracaoIrpf::with('arquivos')->where('cliente_id', $cliente_id)->get();
        return response()->json($declaracao);
    }

    public function getQuestoes($cliente_id)
    {
        $questoes = IrpfQuestionario::query()->where('visivel_cliente', 1)->get(['id', 'pergunta', 'quantitativo']);
        return response()->json($questoes);
    }

    public function storeRespostaQuestionario(Request $request, $cliente_id)
    {
        $stored_respostas = $this->irpfService->storeIrpfResposta($request->all(), $cliente_id);
        if (!$stored_respostas) {
            return response()->json(['message' => 'Não foi possível concluir a operação.']);
        }
        return response()->json(['message' => 'Operação realizada com sucesso']);
    }

    public function getPendencia(int $cliente_id)
    {
        $pendencias = $this->irpfService->getPendenciasByClienteId($cliente_id);

        if (!$pendencias) {
            return response()->json('Não foi possível concluir a operação.');
        }
        return response()->json(['data' => $pendencias]);
    }

    public function storeItem(Request $request, int $cliente_id, int $resposta_id)
    {
        $data = $request->all();
        $stored_items = $this->irpfService->storePendenciaItems($cliente_id, $resposta_id, $data);
        return response()->json(['message' => 'Operação realizada com sucesso.', 'data' => $stored_items]);
    }

    public function exclusaoDeclaracao($irpf_id,FileService $fileService)
    {
       
        // $irpf= DeclaracaoIrpf::where('id',$irpf_id)->first();
      $arquivo =  Arquivo::query()->where('model_id',$irpf_id)->where('nome','declaracao')->first();
        
        // $fileService->deleteFile($arquivo->caminho);

         $arquivo->delete();
         return response()->json('deletado com sucesso',200);
    }

  

    public function finalizaIrpf(IrpfAttachmentRequest $request, int $cliente_id)
    {
        $data = $request->validated();
        try {
            $irpf = $this->irpfService->finalizaDeclaracao($cliente_id, $data);
            return response()->json(['message' => 'Operação realizado com sucesso!', 'data' => $irpf]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function changeIrpfToAceito(Request $request, int $cliente_id)
    {
        $irpf = $this->irpfService->changeIrpfToAceito($cliente_id, (bool) $request->post('aceitou'));

        return response()->json(['message' => 'Operação realizado com sucesso!', 'data' => $irpf]);
    }

    public function changeIrpfToCancelado(Request $request, int $cliente_id)
    {
        $irpf = $this->irpfService->changeIrpfToCancelado($cliente_id, (bool) $request->post('cancelou'));

        return response()->json(['message' => 'Operação realizado com sucesso!', 'data' => $irpf]);
    }

    public function changeIrpfToIsento(Request $request, int $cliente_id)
    {
        $irpf = $this->irpfService->changeIrpfToIsento($cliente_id, (bool) $request->post('isento'));

        return response()->json(['message' => 'Operação realizado com sucesso!', 'data' => $irpf]);
    }

    public function getClientesList(Request $request)
    {
        $ano = $request->get('ano', today()->subYear()->year);
        $clientesList = $this->irpfService->getClientesList($ano);
        return IrpfClientesListResource::collection($clientesList);
    }

    public function downloadDocie(int $clienteId)
    {
        try {
            $docie = $this->generateDociePdf->execute($clienteId);

            return $docie->stream();
        } catch (\Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], 400);
        }
    }
    public function relatorioirpf(Request $request)
    {
        $ano = $request->get('ano', today()->subYear()->year);
        $data = $this->irpfService->getClientesList($ano);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio IRPF .xlsx';

        $sheet->setCellValue('A1', 'Relatorio IRPF ');

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:G1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(23);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(14);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);

        $sheet->setCellValue('A3', 'ID Empresa');
        $sheet->setCellValue('B3', 'Nome Cliente');
        $sheet->setCellValue('C3', 'status');
        $sheet->setCellValue('D3', 'Pendencias Enviadas');
        $sheet->setCellValue('E3', 'Carteiras');
        $sheet->setCellValue('F3', 'Fazer com Medb');
        $sheet->setCellValue('G3', 'Isento');


        $sheet->getStyle("A3:G3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $item) {



            $carteiras = '';


            $respondido[0] = 'Não respondido';
            $respondido[1] = 'respondido';

            $sheet->setCellValue('A' . $i, isset($item->empresa[0]->id) ? $item->empresa[0]->id : '')
                ->setCellValue('B' . $i, ' ' . $item->nome_completo)
                ->setCellValue('C' . $i, isset($item->irpf->aceitou) ? 'Questionário respondido' : 'Não respondido')
                ->setCellValue('D' . $i, isset($item->irpf->aceitou) ?  $item->irpf->pendencias['diff'] . '%' : 'N/A')
                ->setCellValue('E' . $i,  isset($item->empresa[0]->carteiras[0]->nome) ? $item->empresa[0]->carteiras[0]->nome : 'Sem carteira')
                ->setCellValue('F' . $i,   isset($item->irpf->aceitou) ? $respondido[$item->irpf->aceitou] : 'Não respondido');
            if (isset($item->irpf->aceitou)) {
                $sheet->setCellValue('G' . $i,  $item->irpf->isento == 0 ? 'Não' : 'Sim');
            } else {
                $sheet->setCellValue('G' . $i, 'Não respondido');
            }

            $i++;
        }

        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');


        $sheet->getPageSetup()->setPrintArea('A1:G' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    public function relatorioirpfResumo(Request $request)
    {
        $ano = $request->get('ano', today()->subYear()->year);
        $clientesList = $this->irpfService->getClientesList($ano);

        $data = [];
        foreach ($clientesList as $cliente) {
            if (isset($cliente->empresa[0]->carteiras[0])) {
                $data[$cliente->empresa[0]->carteiras[0]->id]['qtd'][] =  $cliente->empresa[0]->id;
                if (isset($cliente->irpf)) {

                    if ($cliente->irpf->cancelado == 1) {
                        $data[$cliente->empresa[0]->carteiras[0]->id]['cancelado'][] =  $cliente->empresa[0]->id;
                    } else {
                        if (!isset($cliente->irpf) || $cliente->irpf->step === "questionario") {
                            $data[$cliente->empresa[0]->carteiras[0]->id]['nr'][] = $cliente->empresa[0]->id;
                        } else
                        if ($cliente->irpf->step === "pendencia" and $cliente->irpf->pendencias['sent'] === 0) {

                            $data[$cliente->empresa[0]->carteiras[0]->id]['qr'][] = $cliente->empresa[0]->id;
                        } else
                        if ($cliente->irpf->step === "pendencia" and $cliente->irpf->pendencias['sent'] > 0) {
                            $data[$cliente->empresa[0]->carteiras[0]->id]['iep'][] = $cliente->empresa[0]->id;
                        }
                        else

                        if ($cliente->irpf->step === "comprovante") {

                            $data[$cliente->empresa[0]->carteiras[0]->id]['pe'][] = $cliente->empresa[0]->id;
                        } else

                        if (!empty($cliente->irpf->enviado)) {
                            $data[$cliente->empresa[0]->carteiras[0]->id]['finalizado'][] = $cliente->empresa[0]->id;
                        }
                    }
                } else{
                  
                        $data[$cliente->empresa[0]->carteiras[0]->id]['nr'][] = $cliente->empresa[0]->id;
                    
                }
            } else {

                // return   $data[]['sem-carteira'] 
            }
        }



        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio IRPF Resumido.xlsx';

        $sheet->setCellValue('A1', 'Relatorio IRPF Resumido ');

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:H1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(23);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(14);
        $sheet->getColumnDimension('F')->setWidth(26);
        $sheet->getColumnDimension('G')->setWidth(23);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);



        $sheet->setCellValue('B3', 'QTDE');
        // $sheet->setCellValue('C3', 'NÃO VAI FAZER');
        $sheet->setCellValue('C3', 'NÃO RESPONDEU');
        $sheet->setCellValue('D3', 'QUESTIONARIO RESPONDIDO');
        $sheet->setCellValue('E3', 'INICIO ENVIO DE PENDENCIAS');
        $sheet->setCellValue('F3', 'PENDENCIAS ENVIADAS');
        $sheet->setCellValue('G3', 'FINALIZADO');
        $sheet->setCellValue('H3', 'CANCELADO');

        $sheet->setCellValue('A4', 'CONTABIL 1')
            ->setCellValue('A5', 'CONTABIL 2')
            ->setCellValue('A6', 'CONTABIL 3')
            ->setCellValue('A7', 'CONTABIL 4')
            ->setCellValue('A8', 'CONTABIL 5')
            ->setCellValue('A9', 'CONTABIL 7')
            ->setCellValue('A10', 'TOTAL');




        $sheet->getStyle("A3:H3")->getFont()->setBold(true);
        $i = 4;


        $indices = [
            1 => 4,
            2 => 5,
            3 => 6,
            7 => 7,
            12 => 8,
            17 => 9
        ];

        $totais = [
            'qtd' => 0,
            'nvf' => 0,
            'nr' => 0,
            'qr' => 0,
            'iep' => 0,
            'pe' => 0,
            'finalizado' => 0,
            'cancelado' => 0
        ];
        foreach ($data as $key => $item) {
            $totais['qtd'] = count($item['qtd']) +  $totais['qtd'];
            $totais['nvf'] = $totais['nvf'] + (isset($item['nvf']) ?  count($item['nvf']) : 0);
            $totais['nr'] =  $totais['nr'] + (isset($item['nr']) ?  count($item['nr']) : 0);
            $totais['qr'] = $totais['qr'] + (isset($item['qr']) ?  count($item['qr']) : 0);
            $totais['iep'] =  $totais['iep'] + (isset($item['iep']) ?  count($item['iep']) : 0);
            $totais['pe'] = $totais['pe'] + (isset($item['pe']) ?  count($item['pe']) : 0);
            $totais['finalizado'] =  $totais['finalizado'] + (isset($item['finalizado']) ?  count($item['finalizado']) : 0);
            $totais['cancelado'] =  $totais['cancelado'] + (isset($item['cancelado']) ?  count($item['cancelado']) : 0);



            $sheet->setCellValue('B' . $indices[$key], count($item['qtd']));
            // $sheet->setCellValue('C' . $indices[$key], isset($item['nvf']) ?  count($item['nvf']) : 0);
            $sheet->setCellValue('C' . $indices[$key], isset($item['nr']) ? count($item['nr']) : 0);
            $sheet->setCellValue('D' . $indices[$key], isset($item['qr']) ? count($item['qr']) : 0);
            $sheet->setCellValue('E' . $indices[$key], isset($item['iep']) ?  count($item['iep']) : 0);
            $sheet->setCellValue('F' . $indices[$key], isset($item['pe']) ? count($item['pe']) : 0);
            $sheet->setCellValue('G' . $indices[$key], isset($item['finalizado']) ? count($item['finalizado']) : 0);
            $sheet->setCellValue('H' . $indices[$key], isset($item['cancelado']) ? count($item['cancelado']) : 0);


            // $i++;
        }
        $sheet->setCellValue('B' . 10, $totais['qtd']);
        // $sheet->setCellValue('C' . 10,  $totais['nvf']);
        $sheet->setCellValue('C' . 10, $totais['nr']);
        $sheet->setCellValue('D' . 10, $totais['qr']);
        $sheet->setCellValue('E' . 10,  $totais['iep']);
        $sheet->setCellValue('F' . 10, $totais['pe']);
        $sheet->setCellValue('G' . 10,  $totais['finalizado']);
        $sheet->setCellValue('H' . 10, $totais['cancelado']);



        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');


        $sheet->getPageSetup()->setPrintArea('A1:H' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }
}
