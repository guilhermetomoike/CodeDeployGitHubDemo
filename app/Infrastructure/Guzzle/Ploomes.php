<?php

namespace App\Infrastructure\Guzzle;

use App\Models\Invite;

class Ploomes extends Guzzle
{
    /** @var Invite $invitee */
    private $invite;

    public function __construct(Invite $invite)
    {
        $this->setUrl(config('services.ploomes.url'));
        $this->setClient(['User-Key' => config('services.ploomes.key')]);
        $this->invite = $invite;
    }

    public function sendInvitee(): array
    {
        $response = $this->client->post('/Contacts', ['json' =>  [
            "TypeId" => 2,
            'Name' => $this->invite->invitee_name,
            'Email' => $this->invite->invitee_email,
            'Phones' => [
                [
                    'PhoneNumber' => $this->invite->invitee_phone,
                ],
            ]
        ]]);

        $data = json_decode($response->getBody(), true);
        $this->invite->setAttribute('ploomes_id', $data['value'][0]['Id'])->save();

        return $data;
    }

    public function createDeals(): array
    {
        $customer = $this->invite->getCustomer();

        $response = $this->client->post('/Deals', ['json' => [
            "Title" => sprintf("Indicação de %s pelo aplicativo", $customer->nome_completo),
            "ContactId" => $this->invite->ploomes_id,
        ]]);

        $data = json_decode($response->getBody(), true);
        $this->invite->ploomes_deal_id = $data['value'][0]['Id'];
        $this->invite->convidado();

        return $data;
    }
}
