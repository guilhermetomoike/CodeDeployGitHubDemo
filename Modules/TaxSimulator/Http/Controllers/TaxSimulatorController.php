<?php

namespace Modules\TaxSimulator\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\TaxSimulator\Http\Requests\TaxSimulatorRequest;
use Modules\TaxSimulator\Services\TaxSimulatorService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TaxSimulatorController extends Controller
{

    /**
     * @var TaxSimulatorService
     */
    private TaxSimulatorService $taxSimulator;

    public function __construct(TaxSimulatorService $taxSimulator)
    {
        $this->taxSimulator = $taxSimulator;
    }

    public function simulator(TaxSimulatorRequest $request)
    {
        return response($this->taxSimulator->validateType($request->all()));
    }

    public function index(TaxSimulatorRequest $request)
    {
        $data = $this->taxSimulator->validateType($request->all());
        $value = $request['value'] * 12;

        return response($this->taxSimulator->response($data, $value));
    }

    public function exportSimulacao(Request $request)
    {
        $campos = $request->get('campos');
        $letras = ['B', 'C', 'D', 'E', 'F', 'G','H'];



        $columnfinal =  $letras[count($campos)-1];



        $data = $this->taxSimulator->validateType($request->params);

        $value = $request->params['value'] * 12;

        $data =  $this->taxSimulator->response($data, $value);
        // return $data;
        // ini_set('max_execution_time', 180); //3 minutes

        // ini_set ("memory_limit", "10056M");

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Faturas Medb.xlsx';

        $sheet->setCellValue('A1', 'Simulação');

        $sheet->getStyle('A1:' . $columnfinal . '1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:' . $columnfinal . '1')->getFont()->setSize(18);
        $sheet->mergeCells('A1:' . $columnfinal . '1');

      
    

        $sheet->setCellValue('A3', '');

        foreach ($campos as $key => $campo) {
            $sheet->setCellValue($letras[$key] . '3', $campo['label']);
        }
        $sheet->getStyle('A3:' . $columnfinal . '3')->getFont()->setBold(true);
        $i = 4;

        foreach ($data as $item) {
            $sheet->setCellValue('A' . $i, $item['id']);
            foreach ($campos as $key => $campo) {
                $sheet->setCellValue($letras[$key] . $i, $item[$campo['id']]);
            }
            $i++;
        }

        foreach(range('A','G') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $sheet->getPageSetup()->setPrintArea('A1:G' . intval($i));

        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="' . $filename . '"');
        // header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }
}
