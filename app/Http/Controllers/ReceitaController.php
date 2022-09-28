<?php

namespace App\Http\Controllers;

use App\Http\Requests\DivisaoReceitasRequest;
use App\Http\Requests\UploadReceitasRequest;
use App\Http\Resources\ReceitasNaoProcessadasResource;
use App\Http\Resources\ReceitasResource;
use App\Jobs\ParseReceitasJob;
use App\Modules\ConvertPDFToText;
use App\Modules\FileParser\CertidaoNegativa\Parser;
use App\Services\File\FileService;
use App\Services\ReceitaService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Storage;


class ReceitaController extends Controller
{
    private $receitaService;
    private $fileService;
    private $storageS3;
    private $storageLocal;

    public function __construct(ReceitaService $receitaService, FileService $fileService)
    {
        $this->receitaService = $receitaService;
        $this->fileService = $fileService;

        $this->storageS3 = Storage::disk('s3');
        $this->storageLocal = Storage::disk('local');
    }

    public function getReceitas(Request $request)
    {
        $data = $this->receitaService->getReceitas($request);
        return ReceitasResource::collection($data['items']);
    }

    public function createReceita(Request $request)
    {
        try {
            $this->receitaService->create($request->all());
            return response(['message' => 'Receita criada com sucesso.'], 200);
        } catch (\Exception $exception) {
            return response(['message' => $exception->getMessage()], 422);
        }
    }

    public function editReceita(Request $request, int $id)
    {
        try {
            $this->receitaService->edit($id, $request->all());
            return response(['message' => 'Receita editada com sucesso.'], 200);
        } catch (\Exception $exception) {
            return response(['message' => $exception->getMessage()], 422);
        }
    }

    public function upload(UploadReceitasRequest $request)
    {
        $receitas = $request->get('receitas');
        foreach ($receitas as $receita) {
            $file = $this->fileService->uploadFile($receita, 'receita');
            ParseReceitasJob::dispatch($file);
        }
        return response(['message' => 'Arquivos enviados com sucesso.'], 200);
    }

    public function uploadReceitasDevelop(UploadReceitasRequest $request)
    {
        try {


            $receitas = $request->get('receitas');
            foreach ($receitas as $receita) {
                $upload = $this->fileService->uploadFile($receita, 'receita');

            }

            $pdf = $this->storageS3->get($upload->path);
            $this->storageLocal->put($upload->path, $pdf);
            $localPath = storage_path('app/private/') . $upload->path;

            $pdfTexto = (new ConvertPDFToText($localPath))->run();

               
            // $guiaParser = (new Parser($pdfTexto))->parse();

                 return response()->json($pdfTexto,200);
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
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 200);

            // $this->fileService->errorOnUpload($upload, $exception->getMessage());
        }
        // $path = storage_path('/000' . $filename);

        // if(Storage::exists($filename)) {
        //     dd('file esxists');
        // } else {
        //     dd('no file found');
        // }
    }

    public function divisao(DivisaoReceitasRequest $request)
    {
        try {
            $socios = $request->get('socios');
            $this->receitaService->editDivisaoReceitas($socios);
            return response(['message' => 'Divisão de receita alterada com sucesso.'], 200);
        } catch (\Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function receitasNaoProcessadas()
    {
        $receitas = $this->fileService->getUploadFilesWithError('receita');
        return ReceitasNaoProcessadasResource::collection($receitas);
    }

    public function deleteReceitaNaoProcessada(int $id)
    {
        $this->fileService->deleteUploadFileWithError($id);
        return response([], 204);
    }

    public function deleteReceita(int $id)
    {
        $this->receitaService->deleteReceita($id);
        return response([], 204);
    }

    public function generateReport(Request $request)
    {
        return $this->receitaService->generateReport($request);
    }

    public function lancamentoReceita(Request $request, int $id)
    {
        $this->receitaService->lancamentoReceita($request->all(), $id);
        return response(['message' => 'Receita lançada com sucesso.'], 200);
    }

    public function getReceitasByCustomer($customer_id)
    {
        $data = $this->receitaService->getYearlyByCustomer($customer_id);
        return new JsonResponse($data);
    }

    public function storeHolerite(Request $request)
    {
        $result = $this->receitaService->storeHolerite($request->all());
        return new JsonResponse($result);
    }

    public function updateHolerite(Request $request, int $id)
    {
        $result = $this->receitaService->updateHolerite($id, $request->all());
        return new JsonResponse($result);
    }

    public function moveUploadToHolerite(Request $request)
    {
        try {
            $result = $this->receitaService->moveUploadToHolerite($request->all());
            return new JsonResponse($result);
        } catch (\Exception $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], 400);
        }
    }
}
