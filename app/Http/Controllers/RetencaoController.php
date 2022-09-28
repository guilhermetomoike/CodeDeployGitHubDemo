<?php

namespace App\Http\Controllers;

use App\Http\Requests\RetencaoRequest;
use App\Models\Retencao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RetencaoController extends Controller
{

     public function index()
     {
         return response()->json(Retencao::with('motivo','empresa')->get(),200);
     }

     public function show($empresa_id)
     {
         return Retencao::where('empresas_id',$empresa_id)->first();
     }
    public function store(RetencaoRequest $request){

        $data = $request->all();
       $conteudo = Retencao::create($data);

        return response()->json(['msg'=>'Empresa retida com sucesso', 'conteudo'=>$conteudo]);
    }

    public function update(RetencaoRequest $request,$id){

        $data = $request->all();
        $conteudo =  Retencao::findOrFail($id)->update($data);

        return response()->json(['msg'=>'Empresa retida  atualizado com sucesso', 'conteudo'=>$data],200);

    }

    public function destroy($id)
    {
        Retencao::findOrFail($id)->delete();
        return response()->json('deletado  com sucesso');

    }

    public function relatorio()
    {
        $data = Retencao::with('motivo','empresa')->get();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Retenções Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Retenções Medb');

        $sheet->getStyle("A1:D1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:D1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:D1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(18);


        // $sheet->getColumnDimension('D')->setWidth();

        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'Cnpj');
        $sheet->setCellValue('C3', 'Empresa');
        $sheet->setCellValue('D3', 'Motivo');
        $sheet->setCellValue('E3', 'dias da retenção');

        $sheet->setCellValue('F3', 'Carteiras');

        $sheet->getStyle("A3:F3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        foreach ($data as $item) {
           
            $carteiras = '';

            if (count($item->empresa->carteirasrel) >   $tamanhoH) {
                $tamanhoH = count($item->empresa->carteirasrel);

                $sheet->getColumnDimension('F')->setWidth($tamanhoH * 12);
            }
            foreach ($item->empresa->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }

            $sheet->setCellValue('A' . $i, $item->empresa->id)
                ->setCellValue('B' . $i, ' ' . $item->empresa->cnpj)
                ->setCellValue('C' . $i, $item->empresa->razao_social)
                ->setCellValue('D' . $i, $item->motivo->motivo)
                ->setCellValue('E' . $i, $this->diasDatas($item->data_retencao,Carbon::now()))

                ->setCellValue('F' . $i,  $carteiras);

            $i++;
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:D' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    function diasDatas($data_inicial,$data_final) {
        $diferenca = strtotime($data_final) - strtotime($data_inicial);
        $dias = floor($diferenca / (60 * 60 * 24)); 
        return $dias;
    }
}
