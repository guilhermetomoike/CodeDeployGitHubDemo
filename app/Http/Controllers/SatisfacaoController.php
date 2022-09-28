<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlvarasRequest;
use App\Http\Requests\SatisfacaoRequest;
use App\Http\Resources\AlvarasResource;
use App\Models\Cliente;
use App\Models\Empresa\Alvara;
use App\Models\Satisfacao;
use App\Services\Empresa\AlvarasService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SatisfacaoController extends Controller
{

    public function index()
    {
        return Satisfacao::with('cliente')->get();
    }

    public function store(SatisfacaoRequest  $request)
    {
        $cliente_id = Cliente::where('cpf', $request->cpf)->first()->id;

        $sat =  Satisfacao::where('cliente_id', $cliente_id)->first();

        // return  response()->json($sat,200);
        if (isset($sat->id)) {
            $this->update($sat->id, ['cliente_id' => $cliente_id, 'comentario' => $request->comentario, 'satisfacao' => $request->satisfacao]);
            return response()->json('Obrigado pela avaliação', 200);
        } else {
            Satisfacao::create(['cliente_id' => $cliente_id, 'comentario' => $request->comentario, 'satisfacao' => $request->satisfacao]);
            return response()->json('Obrigado pela avaliação', 200);
        }
    }

    public function show(int $id)
    {
    }

    public function update($id, $data)
    {
        Satisfacao::where('id', $id)->update($data);
      
    }

    public function destroy(Alvara $alvara)
    {
        $this->alvarasService->deleteAlvara($alvara);
        return response()->noContent();
    }

    public function relatorioSatisfacao()
    {
       
            $data = Satisfacao::with('cliente')->get();
          

            // return $data[0]->cliente->carteirasrel;
    
    
            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);
            $sheet = $spreadsheet->getActiveSheet();
            $filename = 'Relatorio de Satisfação por Cliente .xlsx';
    
            $sheet->setCellValue('A1', 'Relatorio  Satisfação por Cliente ');
    
            $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal('center');
            $sheet->getStyle("A1:G1")->getFont()->setSize(18);
            $sheet->mergeCells('A1:G1');
    
            $sheet->getColumnDimension('A')->setWidth(30);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(40);
            $sheet->getColumnDimension('D')->setWidth(30);
            $sheet->getColumnDimension('E')->setWidth(50);

    
    
    
    
    
            $sheet->setCellValue('A3', 'ID empresas');
            $sheet->setCellValue('B3', 'ID cliente');
            $sheet->setCellValue('C3', 'Cliente');
            $sheet->setCellValue('D3', 'Cpf');
            $sheet->setCellValue('E3', 'Comentario');
            $sheet->setCellValue('F3', 'Satisfacao');
            $sheet->setCellValue('G3', 'carteiras');

    
            $sheet->getStyle("A3:G3")->getFont()->setBold(true);
            $i = 4;
    
            // $carteiras = $request->get('carteira');
            $tamanhoH = 0;
            // return $data;
            foreach ($data as $lib) {
                // return $item;
                $carteiras = '';
    
    
    
                if (count($lib->cliente->carteirasrel) >   $tamanhoH) {
                    $tamanhoH = count($lib->cliente->carteirasrel);
    
                    $sheet->getColumnDimension('G')->setWidth($tamanhoH * 10);
                }
                foreach ($lib->cliente->carteirasrel as $carteira) {
    
                    if ($carteiras != '') {
                        $carteiras = $carteira->nome . ' - ' . $carteiras;
                    }
                    if ($carteiras == '') {
                        $carteiras = $carteira->nome;
                    }
                }
                $id_emps ='';
    foreach($lib->cliente->empresa as $emp){
        
        $id_emps =    $id_emps .', ' .$emp->id ;
    }
    // return  $id_emps;
                $sheet->setCellValue('A' . $i, substr($id_emps,1))
                    ->setCellValue('B' . $i, $lib->cliente->id)
                    ->setCellValue('C' . $i,$lib->cliente->nome_completo)
                    ->setCellValue('D' . $i, $lib->cliente->cpf)
                    ->setCellValue('E' . $i, $lib->comentario)
                    ->setCellValue('F' . $i, $lib->satisfacao)
                    ->setCellValue('G' . $i, $carteiras);
                    $i++;

                // $sheet->getStyle("B" . $i . ":C" . $i)->getFont()->setBold(true);
    
            }
            $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');
            $sheet->getStyle("A4:G" . intval($i))->getAlignment()->setHorizontal('left');

            // $sheet->getStyle("A5:G" . intval($i))->getActiveSheet()->setRightToLeft(true);
    
    
            $sheet->getPageSetup()->setPrintArea('A1:G' . intval($i));
    
            $writer = new Xlsx($spreadsheet);
            $writer->save($filename);
    
            $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
            return response()->download(public_path($filename));
        }
    
}
