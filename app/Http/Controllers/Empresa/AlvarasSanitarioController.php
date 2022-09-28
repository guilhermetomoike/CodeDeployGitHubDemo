<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlvaraSanitarioRequest;
use App\Http\Resources\AlvaraSanitariosResource;
use App\Models\Empresa\AlvaraSanitario;
use App\Services\Empresa\AlvarasSanitarioService;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use InvalidArgumentException;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class AlvarasSanitarioController extends Controller
{
    private AlvarasSanitarioService $alvarasSanitarioService;

    public function __construct(AlvarasSanitarioService $alvarasSanitarioService)
    {
        $this->alvarasSanitarioService = $alvarasSanitarioService;
    }

    public function index()
    {
        $alvaras = $this->alvarasSanitarioService->getAllAlvaraSanitarios();
        if (!$alvaras) return new JsonResponse();
        return AlvaraSanitariosResource::collection($alvaras);
    }

    public function store(AlvaraSanitarioRequest $request)
    {
        $data = $request->validated();
        try {
            $alvara = $this->alvarasSanitarioService->storeAlvaraSanitario($data);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return new AlvaraSanitariosResource($alvara);
    }

    public function show(int $id)
    {
        $alvara = $this->alvarasSanitarioService->getAlvaraSanitario($id);
        return new AlvaraSanitariosResource($alvara);
    }

    public function update(AlvaraSanitarioRequest $request, AlvaraSanitario $alvara)
    {
        $data = $request->validated();
        $this->alvarasSanitarioService->updateAlvaraSanitario($data, $alvara);
        return new AlvaraSanitariosResource($alvara);
    }

    public function destroy(AlvaraSanitario $alvara)
    {
        $this->alvarasSanitarioService->deleteAlvaraSanitario($alvara);
        return response()->noContent();
    }


    public function relatorio(Request $request)
    {
        $alvaras =    AlvaraSanitario::with(['empresa' => fn ($query) => $query->with('carteirasrel')])
            ->whereHas('empresa')
            ->where('created_at', '<=', $request->data_fim)
            ->where('created_at', '>=', $request->data_inicio)
            ->get();


        $carteiras = $request->get('carteira');
        $result = [];
        $printtrue = false;
        if (!isset($carteiras[0])) {
            $result = $alvaras;
        }else{
        foreach ($alvaras as $item) {

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
        $filename = 'Relatorio AlvaraSanitarios Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio AlvaraSanitarios');

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
