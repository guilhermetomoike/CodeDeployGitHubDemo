<?php


namespace App\Services\PloomesIntegration;


use Illuminate\Support\Arr;

class PloomesQuoteDTO
{
    private ?array $data;

    public function __construct(?array $data)
    {
        $this->data = $data;
    }

    public function getPropostaUrl()
    {
        return $this->data['DocumentUrl'];
    }

    public function getContractId()
    {
        return collect(Arr::get($this->data, 'Deal.OtherProperties'))
            ->keyBy('FieldId')
            ->get('171327')['AttachmentValueId'];
    }

    public function getNomeCompleto()
    {
        return $this->data['Contact']['Name'];
    }

    public function getCpf()
    {
        return $this->data['Contact']['CPF'];
    }

    public function getEmail()
    {
        return $this->data['Contact']['Email'];
    }

    public function getAddress()
    {
        return [
            'logradouro' => $this->data['Contact']['StreetAddress'] ?? 'n',
            'numero' => $this->data['Contact']['StreetAddressNumber'],
            'bairro' => $this->data['Contact']['Neighborhood'],
            'cep' => $this->data['Contact']['ZipCode'],
        ];
    }

    public function getRg()
    {
        return collect($this->data['Contact']['OtherProperties'])
            ->keyBy('FieldId')
            ->get('168318')['StringValue']??null;
    }

    public function getProfession()
    {
        return collect($this->data['Contact']['OtherProperties'])
            ->keyBy('FieldId')
            ->get('170063')['StringValue'] ?? null;
    }

    public function getUniversity()
    {
        return collect($this->data['Contact']['OtherProperties'])
            ->keyBy('FieldId')
            ->get('163335')['StringValue'] ?? null;
    }

    public function getStadoCivil()
    {
        return collect($this->data['Contact']['OtherProperties'])
            ->keyBy('FieldId')
            ->get('170062')['ObjectValueName'] ?? null;
    }

    public function getAttachmentsIds()
    {
        return collect($this->data['Deal']['OtherProperties'])
            ->whereNotNull('AttachmentValueId')
            ->pluck('AttachmentValueId', 'Field.Name')
            ->toArray();
    }

    public function getAttachmentsUrl()
    {
        $attachmentsId = $this->getAttachmentsIds();

        $attachments = collect($this->data['Deal']['Attachments'])
            ->pluck('Url', 'Id')
            ->toArray();

        $result = [
            'proposta' => $this->getPropostaUrl(),
        ];

        foreach ($attachmentsId as $name => $id) {
            $result[$name] = $attachments[$id];
        }

        return $result;
    }

    public function getCreatorName()
    {
        return Arr::get($this->data, 'Deal.Updater.Name');
    }

    public function getBirthday()
    {
        return Arr::get($this->data, 'Contact.Birthday');
    }

    public function getPhones()
    {
        return collect($this->data['Contact']['Phones'])
            ->pluck('PhoneNumber')
            ->toArray();
    }
}
