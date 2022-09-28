<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaxasResource;
use App\Models\Empresa\Taxas;
use App\Services\Empresa\TaxasService;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

use InvalidArgumentException;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Http\Request;

class TaxasController extends Controller
{
    private TaxasService $TaxasService;

    public function __construct(TaxasService $TaxasService)
    {
        $this->TaxasService = $TaxasService;
    }

    public function index()
    {
        $taxas = $this->TaxasService->getAllTaxas();
        if (!$taxas) return new JsonResponse();
        return TaxasResource::collection($taxas);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $taxa = $this->TaxasService->storeTaxas($data);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return  TaxasResource::collection($taxa);

    }

    public function show(int $id)
    {
        $taxas = $this->TaxasService->getTaxas($id);
        //  new TaxasResource($taxa);
         return TaxasResource::collection($taxas);
    }

    public function update(Request $request, Taxas $taxas)
    {
        $data = $request->all();
        $this->TaxasService->updateTaxas($data, $taxas);
        return TaxasResource::collection($taxas);
    }

    // public function destroy(Taxas $taxa)
    // {
    //     $this->TaxasService->deleteTaxas($taxa);
    //     return response()->noContent();
    // }


    public function relatorio(Request $request)
    {
        $taxas =    Taxas::with(['empresa' => fn ($query) => $query->with('carteirasrel')])
            ->whereHas('empresa')
            ->where('created_at', '<=', $request->data_fim)
            ->where('created_at', '>=', $request->data_inicio)
            ->get();


        $carteiras = $request->get('carteira');
        $result = [];
        $printtrue = false;
        if (!isset($carteiras[0])) {
            $result = $taxas;
        }else{
        foreach ($taxas as $item) {

            foreach ($item->empresa->carteirasrel as $carteira) {
                if (in_array($carteira->id, $carteiras)) {
                    $printtrue = true;
                }
                if ($printtrue) {
                    $result[] = $item;
                }
                $printtrue = false;
            }
        }
    }
     


        $data = $result;
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Taxas Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Taxas');

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:G1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(60);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(22);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);







        $sheet->setCellValue('A3', 'ID')->setCellValue('B3', 'Empresa')->setCellValue('C3', 'Vencimento')->setCellValue('D3', 'status')
            ->setCellValue('E3', 'Cidade - Estado')
            ->setCellValue('F3', 'tipo')
            ->setCellValue('G3', 'Carteiras');

        $sheet->getStyle("A3:G3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;

        foreach ($data as $item) {
            $carteiras = '';

            if (count($item->empresa->carteirasrel) >   $tamanhoH) {
                $tamanhoH = count($item->empresa->carteirasrel);

                $sheet->getColumnDimension('H')->setWidth($tamanhoH * 12);
            }
            foreach ($item->empresa->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }

            $sheet->setCellValue('A' . $i, $item->empresa_id)->setCellValue('B' . $i, ($item->empresa ? $item->empresa->getName() : null))
                ->setCellValue('C' . $i, Carbon::parse($item->data_vencimento)->format('d/m/Y'))
                ->setCellValue('D' . $i, $item->data_vencimento > Carbon::now()->format('Y-m-d') ? 'Normal' : 'Vencido')
                ->setCellValue('E' . $i, $item->empresa->endereco->cidade . ' - ' . $item->empresa->endereco->uf)
                ->setCellValue('F' . $i, $item->empresa->endereco->tipo)
                ->setCellValue('G' . $i, $carteiras);
            $i++;
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
