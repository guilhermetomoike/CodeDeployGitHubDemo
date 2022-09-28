<?php

namespace Modules\Invoice\Services;

use App\Models\Empresa;
use Modules\Invoice\Entities\Fatura;
use App\Services\Recebimento\RecebimentoService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Invoice\Entities\FaturaItem;
use Modules\Invoice\Entities\MovimentoContasReceber;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RelatorioInvoiceService
{
   
    public function relatorioFaturas($data)
    {
    
    $spreadsheet = new Spreadsheet();
    $spreadsheet->setActiveSheetIndex(0);
    $sheet = $spreadsheet->getActiveSheet();
    $filename = 'Relatorio Faturas Medb.xlsx';

    $sheet->setCellValue('A1', 'Relatorio Faturas');

    $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal('center');
    $sheet->getStyle("A1:H1")->getFont()->setSize(18);
    $sheet->mergeCells('A1:H1');

    $sheet->getColumnDimension('A')->setWidth(10);
    $sheet->getColumnDimension('B')->setWidth(60);
    $sheet->getColumnDimension('C')->setWidth(15);
    $sheet->getColumnDimension('D')->setWidth(15);
    $sheet->getColumnDimension('E')->setWidth(20);
    $sheet->getColumnDimension('F')->setWidth(15);
    $sheet->getColumnDimension('G')->setWidth(10);


    $sheet->setCellValue('A3', 'ID')->setCellValue('B3', 'Pagador')->setCellValue('C3', 'Forma Pagamento')->setCellValue('D3', 'Valor')
        ->setCellValue('E3', 'Compentência')->setCellValue('F3', 'Vencimento')->setCellValue('G3', 'status')->setCellValue('H3', 'Carteiras');

    $sheet->getStyle("A3:H3")->getFont()->setBold(true);
    $i = 4;

    // $carteiras = $request->get('carteira');
    $tamanhoH = 0;

    foreach ($data as $item) {
        $carteiras = '';

        if (count($item->payer->carteirasrel) >    $tamanhoH) {
            $tamanhoH = count($item->payer->carteirasrel);

            $sheet->getColumnDimension('H')->setWidth($tamanhoH * 12);
        }
        foreach ($item->payer->carteirasrel as $carteira) {

            if ($carteiras != '') {
                $carteiras = $carteira->nome . ' - ' . $carteiras;
            }
            if ($carteiras == '') {
                $carteiras = $carteira->nome;
            }
        }

        $sheet->setCellValue('A' . $i, $item->payer_id)->setCellValue('B' . $i, ($item->payer ? $item->payer->getName() : null) . ' - ' . $item->payer_type)->setCellValue('C' . $i, ($item->forma_pagamento_id === 2) ? 'Cartão' : (($item->forma_pagamento_id === 1) ? 'Boleto' : 'PIX'))->setCellValue('D' . $i, $item->subtotal)
            ->setCellValue('E' . $i, $item->data_competencia)->setCellValue('F' . $i, $item->data_vencimento)->setCellValue('G' . $i, $item->status)->setCellValue('h' . $i, $carteiras);
        $i++;
    }



    $sheet->getPageSetup()->setPrintArea('A1:H' . intval($i));

    // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // header('Content-Disposition: attachment;filename="' . $filename . '"');
    // header('Cache-Control: max-age=0')

    $writer = new Xlsx($spreadsheet);
    $writer->save($filename);

    $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
    return response()->download(public_path($filename));
}
   
}
