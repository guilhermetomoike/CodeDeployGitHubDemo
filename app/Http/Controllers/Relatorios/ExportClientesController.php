<?php

namespace App\Http\Controllers\Relatorios;

use App\Exports\ClientesIrpfExport;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportClientesController
{
    public function __invoke(Request $request)

    {
        try {
            // ini_set('max_execution_time', 180); //3 minutes
            // ini_set ("memory_limit", "10056M");
            $data = Cliente::get();
            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);
            $sheet = $spreadsheet->getActiveSheet();
            $filename = 'Relatorio Clientes Medb.xlsx';

            $sheet->setCellValue('A1', 'Relatorio Clientes');

            $sheet->getStyle("A1:C1")->getAlignment()->setHorizontal('center');
            $sheet->getStyle("A1:C1")->getFont()->setSize(18);
            $sheet->mergeCells('A1:C1');

            $sheet->getColumnDimension('A')->setWidth(10);
            $sheet->getColumnDimension('B')->setWidth(50);
            $sheet->getColumnDimension('C')->setWidth(30);



            $sheet->setCellValue('A3', 'Id Cliente')->setCellValue('B3', 'nome')->setCellValue('C3', 'Email');

            $sheet->getStyle("A3:C3")->getFont()->setBold(true);
            $i = 4;

            // $carteiras = $request->get('carteira');
            $tamanhoH = 0;
            foreach ($data as $item) {
                $valor = 0;

                // $valor = $valor - (178 * count($faturas));y


                $sheet->setCellValue('A' . $i, $item->id)
                    ->setCellValue('B' . $i, $item->nome_completo)
                    ->setCellValue('C' . $i, $item->email);
                $i++;
            }
            $sheet->getPageSetup()->setPrintArea('A1:C' . intval($i));

            $writer = new Xlsx($spreadsheet);
            $writer->save($filename);

            $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
            return response()->download(public_path($filename), $filename);
          
        } catch (\Exception $exception) {
            Log::error('ExportClientesIrpf: ' . $exception->getMessage());
            return response()->json($exception->getMessage(), 500);
        }
    }
}
