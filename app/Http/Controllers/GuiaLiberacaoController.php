<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadGuiasRequest;
use App\Http\Resources\EmpresaGuiaLiberacaoResource;
use App\Http\Resources\GuiaLiberacaoWithGuiaResource;
use App\Http\Resources\GuiasNaoProcessadasResource;
use App\Jobs\ParseGuiasJob;
use App\Models\Empresa;
use App\Models\Guia;
use App\Modules\ConvertPDFToText;
use App\Modules\FileParser\Guia\Parser;
use App\Repositories\EmpresaRepository;
use App\Services\File\FileService;
use App\Services\GuiaService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Smalot\PdfParser\Parser as PdfParser;

class GuiaLiberacaoController extends Controller
{
    private $fileService;
    private $guiaService;
    private $storageS3;
    private $storageLocal;
    private $empresaRepository;

    public function __construct(FileService $fileService, GuiaService $guiaService, EmpresaRepository $empresaRepository)
    {
        $this->fileService = $fileService;
        $this->guiaService = $guiaService;

        $this->storageS3 = Storage::disk('s3');
        $this->storageLocal = Storage::disk('local');

        $this->empresaRepository = $empresaRepository;
    }

    public function show($empresa_id)
    {
        $competencia = request()->get('competencia');
        $guias = $this->guiaService->getGuiasByEmpresa($empresa_id, $competencia);
        if (!$guias) return response(['data' => null]);
        return new GuiaLiberacaoWithGuiaResource($guias);
    }

    public function getTipos()
    {
        return response()->json(['data' => Guia::TIPOS], 200);
    }

    public function sendEmail(Request $request)
    {
        try {
            $guiasLiberacaoId = $request->get('guiaLiberacaoId');
            $this->guiaService->sendEmail($guiasLiberacaoId);
            return response(['message' => 'Envio enviado com sucesso!',], 200);
        } catch (\Exception $exception) {
            return response(['message' => $exception->getMessage()], 422);
        }
    }

    public function store(Request $request)
    {
        try {
            $this->guiaService->create($request->all());
            return response(['message' => 'Guia criada com sucesso.'], 200);
        } catch (ModelNotFoundException $exception) {
            return response(['message' => 'Empresa informada não existe.'], 422);
        } catch (\Exception $exception) {
            return response(['message' => $exception->getMessage()], 422);
        }
    }

    public function getEmpresasGuias(Request $request)
    {
        $competencia = $request->get('competencia', competencia_anterior());
        $data_envio = $request->get('data_envio');
        $empresasGuias = $this->guiaService->getEmpresasWithGuias($competencia, $data_envio);
        return EmpresaGuiaLiberacaoResource::collection($empresasGuias);
    }

    public function estornoGuia(Request $request, int $id)
    {
        $this->guiaService->estornar($id);
        return response(['message' => 'Guia estornada com sucesso!'], 200);
    }

    public function getDataPadrao()
    {
        return response($this->guiaService->getDataPadrao());
    }

    public function uploadGuias(UploadGuiasRequest $request)
    {
        $guias = $request->get('guias');
        foreach ($guias as $guia) {
            $file = $this->fileService->uploadFile($guia, 'guia');
            ParseGuiasJob::dispatch($file)->delay(now()->addMinutes(0.4));
        }
        return response(['message' => 'Arquivos enviados com sucesso.'], 200);
    }

    
    function sanitizeString($str)
    {

        $str = preg_replace('/[]/', ' ', $str);
        $str = preg_replace('/(\v|\s)+/', ' ', $str);
        $str = str_replace("\\t", ' ', $str);
        $str = str_replace(" / ", ' ', $str);

        return $str;
    }
  
    public function uploadGuiasDevelop(UploadGuiasRequest $request)
    {
        // try {

    
        $guias = $request->get('guias');
        foreach ($guias as $guia) {
            $upload = $this->fileService->uploadFile($guia, 'guia');
        }

        $pdf = $this->storageS3->get($upload->path);
        $this->storageLocal->put($upload->path, $pdf);
        $localPath = storage_path('app/private/') . $upload->path;



        $parser = new PdfParser();
        $pdf    = $parser->parseFile($localPath);
        try {


            $text =  $this->sanitizeString($pdf->getText());

            $guiaParser = (new Parser([$text]))->parse();
            return response()->json([$text, $guiaParser], 200);
        } catch (\Exception $exception) {

      
            $pdfTexto = (new ConvertPDFToText($localPath))->run();
            // return  [$pdfTexto,$text];
            $guiaParser = (new Parser($pdfTexto))->parse();
            return response()->json($guiaParser, 200);
        }
        return response()->json(['nao entrou no if', $guiaParser], 200);

        // $guiaParser = (new Parser($pdfTexto))->parse();



        // return response()->json( $this->identifyEmpresaFromGuia($guiaParser),200);

        //  $cnpj = '';
        // $pdfTexto =   [ " Prefeitura do Município de Maringá Guia de Recolhimento Estado do Paraná Vencimento: 20/08/2021 ISS Secretaria Municipal da Fazenda Não receber após o vencimento Cadastro Mobiliário: 192784 CPF/CNPJ:29.177.950/0001-78 Razão Social: FLEURY MEDEIROS CLINICA MEDICA EIRELI - ME Receita: 91 - ISSQN HOMOLOGADO Nosso número: 44442100000043666 Base de Cálculo: 60.750,00 Valor Correção: 0,00 Competência: 07/2021 Valor do Tributo: 1.215,00 Valor Multa: 0,00 Data Emissão: 02/08/2021 10:59:34 Valor Desconto: 0,00 Valor Juros: 0,00 Tipo Guia: NFS-e Valor Principal: 1.215,00 Valor Total: 1.215,00 NFS-e N°: 19,20; Autenticação Mecânica Prefeitura do Município de Maringá Guia de Recolhimento Estado do Paraná Vencimento: 20/08/2021 SS Secretaria Municipal da Fazenda Não receber após o vencimento Cadastro Mobiliário: 192784 CPF/CNPJ:29.177.950/0001-78 Razão Social: FLEURY MEDEIROS CLINICA MEDICA EIRELI - ME Receita: 91 - ISSQN HOMOLOGADO Nosso número: 44442100000043666 Base de Cálculo: 60.750,00 Valor Correção: 0,00 Competência: 07/2021 Valor do Tributo: 1.215,00 Valor Multa: 0,00 Data Emissão: 02/08/2021 10:59:34 Valor Desconto: 0,00 Valor Juros: 0,00 Tipo Guia: NFS-e Valor Principal: 1.215,00 Valor Total: 1.215,00 Pague nas agências bancárias: Valor a pagar: 1.215,00 Itaú, Caixa Econômica Federal e Banco do Brasil Autenticação Mecânica 81630000012-1 15002594202-3 10820444421-1 00000043666-7"];
        // $pdfTexto = [" MINISTÉRIO DA FAZENDA 02 PERÍODO DE APURAÇÃO 31/07/2021 SECRETARIA DA RECEITA FEDERAL DO BRASIL 03 NÚMERO DO CPF OU CNPJ 26.873. 829/0001-92 Documento de Arrecadação de Receitas Federais 04 CÓDIGO DARECEITA 0561 DARF IR 05 NÚMERO DE REFERÊNCIA 01 NOME/TELEFONE 165 - CLINICA MEDICA G SUZUKI EIRELI - 06 DATADE VENCIMENTO (0044) 99623233 20/08/2021 07 VALOR DO PRINCIPAL 192,55 Veja no verso 08 VALOR DA MULTA Instruções para preenchimento 0,00 ATENÇÃO 09 VALOR DOS JUROS E / OU ENCARGOS DL 1.025/69 0,00 É vedado o recolhimento de tributos administrados pela Secretaria da Receita Federal do Brasil (RFB) cujo valor total seja inferior a R$ 10,00. 10 VALOR TOTAL 192,55 Ocorrendo tal situação, adicione esse valor ao tributo de mesmo código de períodos subseqüentes, até que o total seja igual ou superior a R$ 10,00. 11 AUTENTICAÇÃO BANCÁRIA (Somente nas 1a, e 2 vias) Aprovado pela IN/RFB no. 736 de 2 de maio de 2007 Corte aqui. MINISTÉRIO DA FAZENDA 02 PERÍODO DE APURAÇÃO 31/07/2021 SECRETARIA DA RECEITA FEDERAL DO BRASIL 03 NÚMERO DO CPF OU CNPJ 26.873. 829/0001-92 Documento de Arrecadação de Receitas Federais 04 CÓDIGO DARECEITA 0561 DARF IR 05 NÚMERO DE REFERÊNCIA 01 NOME/TELEFONE 165 - CLINICA MEDICA G SUZUKI EIRELI - 06 DATADE VENCIMENTO (0044) 99623233 20/08/2021 07 VALOR DO PRINCIPAL Veja no verso 192,55 Instruções para preenchimento 08 VALOR DA MULTA 0,00 09 VALOR DOS JUROS E/OU ATENÇÃO ENCARGOS DL 1.025/69 0,00 É vedado o recolhimento de tributos administrados pela Secretaria da Receita Federal do Brasil (RFB) cujo valor total seja inferior a R$ 10,00. 10 VALOR TOTAL 192,55 Ocorrendo tal situação, adicione esse valor ao tributo de mesmo código de períodos subseqüentes, até que o total seja igual ou superior a R$ 10,00. 11 AUTENTICAÇÃO BANCÁRIA (Somente nas 1 e 2 vias) Aprovado pela IN/RFB no. 736 de 2 de maio de 2007"];
        // $pdfTexto = ["SIMPLES Documento de Arrecadação do Simples Nacional N AoNAL CNPJ Razão Social 27.754.611/0001-81 GB CLINICA MEDICA EIRELI Período de Apuração Data de Vencimento Número do Documento Pagar este documento até Julho/2021 20/08/2021 07.20.21214.6907609-3 20/08/2021 Observações Valor Total do Documento 1.737,25 Composição do Documento de Arrecadação Código Denominação Principal Multa Juros Total 1001 IRPJ - SIMPLES NACIONAL 69,49 69,49 07/2021 1002 CSLL - SIMPLES NACIONAL 60,80 60,80 07/2021 1004 COFINS - SIMPLES NACIONAL 244,08 244,08 07/2021 1005 PIS - SIMPLES NACIONAL 52,99 52,99 07/2021 1006 INSS - SIMPLES NACIONAL 753,97 753,97 07/2021 1010 ISS - SIMPLES NACIONAL 555,92 555,92 ASTORGA (PR) - 07/2021 Totais 1.737,25 1.737,25 SENDA (Versão:5.0.0) Página: 1/1 02/08/2021 14:54:11 85840000017 5 37250328212 6 32072021214 0 69076093682 3 AUTENTICAÇÃO MECÂNICA Documento de Arrecadação do Simples Nacional Pague com o PIX 85840000017 5 37250328212 6 32072021214 0 69076093682 3 CNPJ: 27.754.611/0001-81 Número: 07.20.21214.6907609-3 Pagar até: 20/08/2021 Valor: 1.737,25"];
        //  $cnpj = str_replace('CNPJ: ', '', $cnpj);


        // $guiaParser = (new Parser($pdfTexto))->parse();
        // return response()->json($guiaParser, 200);


        // $parse = [
        //     'cnpj' => [],
        //     'valores' => [],
        // ];
        // // return $this->validateType($text);
        // foreach($pdfTexto as $text){
        //     $parse['cnpj'] = $this->getCnpj($text);
        //     $parse['valores'] = array_merge($parse['valores'], $this->setValores($text));
        //     $parse['barcode'] = $this->getBarcode($text);
        // }
        //  return response()->json($parse,200);

        // return formata_cnpj_bd($cnpj);
        // } catch (\Exception $exception) {
        //     return response()->json($exception->getMessage(), 200);

        // $this->fileService->errorOnUpload($upload, $exception->getMessage());
        // }
        // $path = storage_path('/000' . $filename);

        // if(Storage::exists($filename)) {
        //     dd('file esxists');
        // } else {
        //     dd('no file found');
        // }
    }


    public function guiasNaoProcessadas()
    {
        $guias = $this->fileService->getUploadFilesWithError('guia');
        return GuiasNaoProcessadasResource::collection($guias);
    }

    public function deleteGuiaNaoProcessada(int $id)
    {
        $this->fileService->deleteUploadFileWithError($id);
        return response([], 204);
    }

    public function changeLiberacao(Request $request)
    {
        $liberacao['contabilidade_departamento_liberacao'] = $request->get('contabilidade_departamento_liberacao');
        $liberacao['rh_departamento_liberacao'] = $request->get('rh_departamento_liberacao');
        $liberacao['financeiro_departamento_liberacao'] = $request->get('financeiro_departamento_liberacao');
        $empresaId = $request->get('empresaId');
        $dataCompetencia = $request->get('dataCompetencia');
        $this->guiaService->changeLiberacao($liberacao, $empresaId, $dataCompetencia);
        return response(['message' => 'Liberação alterada com sucesso.'], 200);
    }

    public function sendAllEligible(Request $request)
    {
        $data_competencia = $request->post('data_competencia');
        $this->guiaService->eligesToSend($data_competencia);
        $this->guiaService->sendAllGuiasEligibles($data_competencia, true);
        return response()->json(['message' => 'Beleza! os emails estão send enviados.']);
    }

    public function eligesToSend(Request $request)
    {
        $data_competencia = $request->post('data_competencia');
        $this->guiaService->eligesToSend($data_competencia);
        return response()->json(['message' => 'Liberação realizada com sucesso.']);
    }

    public function getUploadStatus()
    {
        $data = $this->guiaService->getUploadReport();
        return new JsonResponse($data);
    }

    public function relatorioGuias()
    {
       
    
        $data =     Empresa::query()->
            select('id', 'razao_social', 'cnpj', 'regime_tributario', 'status_id', 'saiu', 'congelada')
            ->get();

            // return $data;
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Guias Fechamentos Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Guias Fechamentos');

        $sheet->getStyle("A1:Y1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:Y1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:Y1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);




        $sheet->setCellValue('A3', 'ID')->setCellValue('B3', 'cnpj')->setCellValue('C3', 'razao_social')->setCellValue('D3', 'cidade')
            ->setCellValue('E3', 'Regime')->setCellValue('F3', 'carteiras')
            
            ->setCellValue('G3', 'xml')->setCellValue('H3', 'DEISS')
            ->setCellValue('I3', 'Faturamento')->setCellValue('J3', 'DAS')->setCellValue('K3', 'FATOR R')
            ->setCellValue('L3', 'ISS')->setCellValue('M3', 'PIS')->setCellValue('N3', 'COFINS')->setCellValue('O3', 'CSLL')->setCellValue('P3', 'IRPJ')
            ->setCellValue('Q3', 'Prolabore')->setCellValue('R3', 'T/P')->setCellValue('S3', 'INSS')->setCellValue('T3', 'IRRF')->setCellValue('U3', 'GUIAS')
            ->setCellValue('V3', '%')->setCellValue('W3', 'OBS1')->setCellValue('X3', 'OBS2')->setCellValue('Y3', 'OBS3');

        $sheet->getStyle("A3:X3")->getFont()->setBold(true);
        $i = 4;

        $tamanhoH = 0;

        foreach ($data as $item) {

            $carteiras = '';

            if (count($item->carteirasrel) >   $tamanhoH) {
                $tamanhoH = count($item->carteirasrel);

                $sheet->getColumnDimension('H')->setWidth($tamanhoH * 12);
            }
            foreach ($item->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }

            // return $item->receitasCompetencia->prolabore;
                $sheet->setCellValue('A' . $i, $item->id)
                ->setCellValue('B' . $i, $this->formata_cpf_cnpj($item->cnpj))

                ->setCellValue('C' . $i, $item->razao_social)
                ->setCellValue('D' . $i, $item->endereco->cidade ?? "")

                
                ->setCellValue('E' . $i, $item->regime_tributario)
                ->setCellValue('F' . $i, $carteiras)

                
                ->setCellValue('I' . $i, $item->faturamento->faturamento ?? "")
                ->setCellValue('J' . $i, $item->guiasCompetencia->where('tipo','DAS')->first()->valor['das']  ?? null)
                ->setCellValue('K' . $i, $item->receitasCompetencia->fator_r ?? null)
                ->setCellValue('L' . $i, $item->guiasCompetencia->where('tipo','ISS')->first()->valor['iss'] ?? null)
                ->setCellValue('M' . $i, $item->guiasCompetencia->where('tipo','PIS')->first()->valor['pis'] ?? null)
                ->setCellValue('N' . $i, $item->guiasCompetencia->where('tipo','COFINS')->first()->valor['cofins'] ?? null)
                ->setCellValue('O' . $i, $item->guiasCompetencia->where('tipo','CSLL')->first()->valor['csll'] ?? null)
                ->setCellValue('P' . $i, $item->guiasCompetencia->where('tipo','IRPJ')->first()->valor['irpj'] ?? null)


                ->setCellValue('Q' . $i, $item->receitasCompetencia->prolabore ?? null)

                ->setCellValue('S' . $i, $item->receitasCompetencia->inss ?? null)
                ->setCellValue('T' . $i, $item->receitasCompetencia->irrf ?? null);


            
                $i++;
       
        }


        $sheet->getPageSetup()->setPrintArea('A1:Y' . intval($i));

        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="' . $filename . '"');
        // header('Cache-Control: max-age=0');


        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    function formata_cpf_cnpj($cpf_cnpj)
    {
        /*
            Pega qualquer CPF e CNPJ e formata
    
            CPF: 000.000.000-00
            CNPJ: 00.000.000/0000-00
        */

        ## Retirando tudo que não for número.
        $cpf_cnpj = preg_replace("/[^0-9]/", "", $cpf_cnpj);



        $bloco_1 = substr($cpf_cnpj, 0, 2);
        $bloco_2 = substr($cpf_cnpj, 2, 3);
        $bloco_3 = substr($cpf_cnpj, 5, 3);
        $bloco_4 = substr($cpf_cnpj, 8, 4);
        $digito_verificador = substr($cpf_cnpj, -2);
        $cpf_cnpj_formatado = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "/" . $bloco_4 . "-" . $digito_verificador;


        return $cpf_cnpj_formatado;
    }

}
