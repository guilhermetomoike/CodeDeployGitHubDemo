<?php

namespace App\Services;

use App\Models\Empresa;
use Barryvdh\DomPDF\Facade as PDF;

class ContratoService extends Service
{
    private $empresa;

    private ClicksignApiService $clicksignApi;

    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;

        $this->clicksignApi = app('ClicksignApi');

        $this->verifyClienteKey();
    }

    public function createDocuments(array $documents)
    {
        $documents = collect($documents)->mapWithKeys([$this, 'createDocument']);

        $batch = $this->clicksignApi->createBatch([
            'signer_key' => $this->empresa->socioAdministrador[0]->clicksign_key,
            'document_keys' => $documents->values(),
            'summary' => true
        ]);

        return [
            'documentos' => $documents->toArray(),
            'lote' => $batch['batch']['key'],
            'request_signature_key' => $batch['batch']['request_signature_key'],
        ];
    }

    public function createDocument(string $document)
    {
        $pdfBase64 = $this->generateDocumentPdf($document);

        $clicksignDocument = $this->clicksignApi->createDocument([
            'path' => "/{$this->empresa->id}-{$document}.pdf",
            'content_base64' => "data:application/pdf;base64,{$pdfBase64}",
        ]);

        $clicksignList = $this->clicksignApi->createList([
            'document_key' => $clicksignDocument['document']['key'],
            'signer_key' => $this->empresa->socioAdministrador[0]->clicksign_key,
            'sign_as' => 'sign',
        ]);

        return [$document => $clicksignDocument['document']['key']];
    }

    private function generateDocumentPdf(string $document)
    {
        $pdf = PDF::loadView(
            "contrato.{$document}",
            $this->dataForPdf()
        )
            ->setPaper('a4', 'portrait')
            ->output();

        return base64_encode($pdf);
    }

    private function dataForPdf()
    {
        $socioAdm = $this->empresa->socioAdministrador[0]->load('profissao', 'estado_civil');
        return [
            'makeForPj' => $this->empresa->cnpj && $this->empresa->razao_social,
            'empresa' => $this->empresa,
            'socioAdministrador' => $socioAdm,
        ];
    }

    private function verifyClienteKey()
    {
        $socioAdministrador = $this->empresa->socioAdministrador[0];

        $clicksignSigner = $this->clicksignApi->createSigner([
            'email' => $socioAdministrador->emails[0]->value,
            'phone_number' => $socioAdministrador->celulares[0]->value,
            'auths' => ['email'],
            'name' => $socioAdministrador->nome_completo,
            'documentation' => $socioAdministrador->cpf,
            'birthday' => $socioAdministrador->data_nascimento,
            'has_documentation' => true
        ]);

        $socioAdministrador->clicksign_key = $clicksignSigner['signer']['key'];
        $socioAdministrador->save();
    }

    public static function checkDocument(string $document_id)
    {
        /** @var ClicksignApiService $api */
        $api = app('ClicksignApi');
        return $api->getDocument($document_id);
    }
}
