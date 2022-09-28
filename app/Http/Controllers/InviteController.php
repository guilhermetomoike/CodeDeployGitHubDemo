<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerIndicationRequest;
use App\Infrastructure\Guzzle\Ploomes;
use App\Models\Invite;
use App\Services\InviteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InviteController
{
    private InviteService $inviteService;

    public function __construct(InviteService $inviteService)
    {
        $this->inviteService = $inviteService;
    }

    public function index(Request $request)
    {
        $data = $this->inviteService->getAll($request);
        return new JsonResponse($data);
    }

    public function destroy(int $id)
    {
        $deleted = $this->inviteService->delete($id);
        if (!$deleted)
            return new JsonResponse(['message' => 'Não foi possível realizar a solicitação!'], 400);
        return new JsonResponse(['message' => 'Removido com sucesso!']);
    }

    public function webhook(Request $request)
    {
        $leads = $request->post('leads');
        if (!is_array($leads) || !count($leads)) {
            return new JsonResponse([]);
        }

        foreach ($leads as $item) {
            $this->inviteService->create([
                'invitee_email' => $item['custom_fields']['[CAMPO] E-mail do amigo'] ?? null,
                'invitee_name' => $item['custom_fields']['[CAMPO] Nome do amigo'] ?? null,
                'invitee_phone' => $item['custom_fields']['[CAMPO] Telefone do amigo'] ?? null,
                'customer_cpf' => $item['custom_fields']['CPF'] ?? null,
                'customer_email' => $item['email'] ?? null,
            ]);
        }

        return new JsonResponse(['message' => 'ok']);
    }

    public function customerIndication(CustomerIndicationRequest $request)
    {
        $data = $request->validated();

        /** @var Invite $invitee */
        $invitee = $this->inviteService->create([
            'customer_id' => $data['customer_id'],
            'invitee_name' => $data['nome'],
            'invitee_email' => $data['email'],
            'invitee_cpf' => $data['cpf'],
            'invitee_phone' => $data['telefone'],
        ]);

        $ploomes = new Ploomes($invitee);

        $ploomes->sendInvitee($invitee);
        $ploomes->createDeals($invitee);

        return new JsonResponse(['message' => 'ok']);
    }

    public function customerInvites()
    {
        $invites = $this->inviteService->getByCustomer(auth('api_clientes')->id());

        return new JsonResponse($invites);
    }

    public function relatorioInvite(Request $request)
    {
      
    $data = $this->index($request)->original;
    $spreadsheet = new Spreadsheet();
    $spreadsheet->setActiveSheetIndex(0);
    $sheet = $spreadsheet->getActiveSheet();
    $filename = 'Relatorio Indicados Medb.xlsx';

    $sheet->setCellValue('A1', 'Relatorio Indicados');

    $sheet->getStyle("A1:E1")->getAlignment()->setHorizontal('center');
    $sheet->getStyle("A1:E1")->getFont()->setSize(18);
    $sheet->mergeCells('A1:E1');

    $sheet->getColumnDimension('A')->setWidth(10);
    $sheet->getColumnDimension('B')->setWidth(40);
    $sheet->getColumnDimension('C')->setWidth(40);
    $sheet->getColumnDimension('D')->setWidth(20);
    $sheet->getColumnDimension('E')->setWidth(20);





    $sheet->setCellValue('A3', 'ID')->setCellValue('B3', 'Usuario')->setCellValue('C3', 'nome indicado')->setCellValue('D3', 'cpf indicado')->setCellValue('E3', 'telefone indicado');

    $sheet->getStyle("A3:E3")->getFont()->setBold(true);
    $i = 4;

    // $carteiras = $request->get('carteira');
    $tamanhoH = 0;

//  return $data ;
    foreach ($data as $item) {

        $sheet->setCellValue('A' . $i, $item->customer_id)->setCellValue('B' . $i, $item->customer['nome_completo'] ?? null)
        ->setCellValue('C' . $i, $item->invitee_name)->setCellValue('D' . $i, $item->invitee_cpf)->setCellValue('E' . $i, $item->invitee_phone);
        
        $i++;
    }



    $sheet->getPageSetup()->setPrintArea('A1:E' . intval($i));

    // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // header('Content-Disposition: attachment;filename="' . $filename . '"');
    // header('Cache-Control: max-age=0');


    $writer = new Xlsx($spreadsheet);
    $writer->save($filename);

    $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
    return response()->download(public_path($filename));
}



}
