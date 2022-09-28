<?php

namespace App\Http\Controllers;

use App\Http\Resources\PosCadastroListResource;
use App\Http\Requests\EmpresaPosCadastroUpdateRequest;
use App\Http\Resources\EmpresaPosCadastroResource;
use App\Models\Empresa;
use App\Repositories\PosCadastroRepository;
use App\Services\Empresa\StepsAfterRegistrationService;
use App\Services\EmpresaPosCadastroStatusService;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\EmpresaPosCadastroService;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EmpresaPosCadastroController extends Controller
{
    /**
     * @var StepsAfterRegistrationService
     */
    private StepsAfterRegistrationService $stepsAfterRegistrationService;

    public function __construct(StepsAfterRegistrationService $stepsAfterRegistrationService)
    {
        $this->stepsAfterRegistrationService = $stepsAfterRegistrationService;
    }

    public function index(Request $request, PosCadastroRepository $repository)
    {
        $data['status_id'] = $request->query('status_id');
        $data['tipo'] = $request->query('tipo');
        $empresa = $repository->getPosCadastroList($data);
        return PosCadastroListResource::collection($empresa);
    }

    public function show(int $id, PosCadastroRepository $repository)
    {
        $empresa = $repository->loadCompleteEmpresaPosCadastro($id);
        return new EmpresaPosCadastroResource($empresa);
    }

    public function update(EmpresaPosCadastroUpdateRequest $request, Empresa $empresa)
    {
        $data = $request->validated();

        $empresaPosCadastroService = new EmpresaPosCadastroService($empresa);
        $empresaPosCadastroService->update($data);
        $empresaPosCadastroService->fireEvents();
        return new EmpresaPosCadastroResource($empresa);
    }

    public function status()
    {
        $status = collect(Empresa::$status)->filter(function ($value, $key) {
            return $key < 100 && !in_array($key, [70, 71, 80, 81]);
        });
        return $status;
    }

    public function checkStep(EmpresaPosCadastroStatusService $service, int $id)
    {
        $data = $service->execute($id);
        return response()->json($data);
    }

    public function getDataSteps($empresa_id, $step)
    {
        return $this->stepsAfterRegistrationService->getDataByStep($empresa_id, $step);
    }

    public function cancel($empresa_id)
    {
        $empresa = Empresa::query()->find($empresa_id);
        if ($empresa->status_id > 2) {
            return new JsonResponse(['message' => 'Só pode deletar quando o contrato ainda não estiver assinado!'], 400);
        }
        $deleted = $empresa->delete();
        if (!$deleted) return new JsonResponse(['message' => 'Não deu pra deletar, essa venda é forte!!!'], 400);

        return new JsonResponse(['message' => 'Empresa Cancelada com sucesso']);
    }

    public function pularAcesso($empresa_id)
    {
        $empresa = Empresa::query()->find($empresa_id);
        $empresa->status_id = 7;
        $empresa->save();
    }

    public function relatorioPosCadastro(Request $request, PosCadastroRepository $repository)
    {


        $data = $this->index($request, $repository);



        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Empresas Pos Cadastro Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio  Empresas Planos ocultos  Medb');

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:F1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(60);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(10);



        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'Empresa');
        $sheet->setCellValue('C3', 'Status');
        $sheet->setCellValue('D3', 'Carteiras');
        $sheet->setCellValue('E3', 'Cidade');
        $sheet->setCellValue('F3', 'Estado');



        $sheet->getStyle("A3:F3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $item) {
        $pass=false;
          
                $carteiras = '';

                $tamanhoH = count($item->carteirasrel);
                if (count($item->carteirasrel) >   $tamanhoH) {


                    $sheet->getColumnDimension('D')->setWidth($tamanhoH * 13);
                }
                foreach ($item->carteirasrel as $carteira) {

                    if ($carteiras != '') {
                        $carteiras = $carteira->nome . ' - ' . $carteiras;
                    }
                    if ($carteiras == '') {
                        $carteiras = $carteira->nome;
                    }
                    if($carteira->id == $request->carteira_id){
                        $pass = true;
                    }else{
                        $pass = $request->carteira_id >0 ? false: true; 
                    }

                }

                if($pass){

                $sheet->setCellValue('A' . $i, $item->id)
                    ->setCellValue('B' . $i, $item->nome_empresa == null ? $item->razao_social : $item->nome_empresa)
                    ->setCellValue('C' . $i, $item->status_label)
                    ->setCellValue('D' . $i, $carteiras);
                if (isset($item->endereco->cidade)) {
                    $sheet->setCellValue('E' . $i, $item->endereco->cidade)
                        ->setCellValue('F' . $i, $item->endereco->uf);
                }


                $i++;
            }
            
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:F' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }
}
