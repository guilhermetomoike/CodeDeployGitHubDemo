<?php

namespace App\Http\Controllers;

use App\Models\CartaoCredito;
use App\Services\Recebimento\RecebimentoService;
use http\Env\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Modules\Invoice\Services\PaymentMethod\IPaymentMethodService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CartaoCreditoController extends Controller
{
    private RecebimentoService $recebimentoService;

    public function __construct(RecebimentoService $recebimentoService)
    {
        $this->recebimentoService = $recebimentoService;
    }

    public function store(Request $request, IPaymentMethodService $paymentMethodService)
    {
        $data = $request->all();
        try {
            $paymentMethodService->create($data);
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
        return $this->successResponse([], 'Informações Criadas com sucesso!', 201);
    }
    public function update(Request $request, IPaymentMethodService $paymentMethodService)
    {
        $data = $request->all();
        try {
            $paymentMethodService->update($data);
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
        return $this->successResponse([], 'Informações atualizadas com sucesso!', 201);
    }



    public function index()
    {
        return CartaoCredito::join('empresas', 'empresas.id', 'cartao_credito.empresa_id')
            ->where('status_id', '<>', '71')->select('cartao_credito.*')->get();
    }
    public function recebimentoEmpresa(Request $request)
    {
        $cobranca = $this->recebimentoService
            ->initialize('iugu')
            ->criarCobrancaDireta($request->all());
        if (!$cobranca) {
            return $this->errorResponse('Não foi possivel fazer a cobrança. Tente novamente mais tarde.');
        }
        return $this->successResponse([], 'Pagamento realizado com sucesso.');
    }


    public function destroy($id)
    {
        try {
            CartaoCredito::where('id', $id)->delete();
            return response()->json(['msg' => 'deletado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Não foi possível excluir esse Cartão.'], 500);
        }
    }


    public function relatorioCartaoCredito(Request $request)
    {

        $data = CartaoCredito::get();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Cartao Credito.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Cartão Credito Medb');

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:F1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(23);
        $sheet->getColumnDimension('E')->setWidth(12);

        // $sheet->getColumnDimension('D')->setWidth();

        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'Cnpj');
        $sheet->setCellValue('C3', 'Empresa');
        $sheet->setCellValue('D3', 'Numero');
        $sheet->setCellValue('E3', 'vencimento');


        $sheet->setCellValue('F3', 'Carteiras');

        $sheet->getStyle("A3:F3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $item) {
            $carteiras = '';

            if (count($item->payer->carteirasrel) >   $tamanhoH) {
                $tamanhoH = count($item->payer->carteirasrel);

                $sheet->getColumnDimension('F')->setWidth($tamanhoH * 12);
            }
            foreach ($item->payer->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }

            $sheet->setCellValue('A' . $i, $item->payer->id)
                ->setCellValue('B' . $i, ' ' . $item->payer->cnpj)
                ->setCellValue('C' . $i, $item->payer->getName())
                ->setCellValue('D' . $i, ' '.$item->numero)
                ->setCellValue('E' . $i, $item->ano . '/' . $item->mes)
                ->setCellValue('F' . $i,  $carteiras);

            $i++;
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:F' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }
}
