<?php


namespace App\Services\Recebimento\Gatway\Asas\Common;


use App\Models\Empresa;
use App\Models\Payer\PayerContract;
use Illuminate\Support\Str;

class AsasCliente
{
    public $name;
    public $email;
    public $cpfCnpj;
    public $phone;// faltou
    public $mobilePhone; // faltou
    public $postalCode;// cep
    public $address ;// logradouro 
    public $addressNumber; // endereco number
    public $complement;
    public $province; // bairro
    public $notificationDisabled; // true ou false para desabilitar a cobranca
    public $externalReference; // id da empresa ou cliente do  nosso sistema 
    public $additionalEmails; // outro emails

    public $municipalInscription;
    public $stateInscription; // nao tem por hora

    public $observations;


    /**
     * AsasCliente constructor.
     * @param PayerContract|null $payer
     */
    public function __construct(PayerContract $payer = null)
    {
        if ($payer) {
            $this->build($payer);
        }
    }

    public function build(PayerContract $payer)
    {
        $email = $payer->contatos()->email();
        $phone = $payer->contatos()->celular();

        
        $endereco = $payer->endereco;

        $this->setEmail($email)
            ->setName($payer->getName())
            ->setCpfCnpj($payer->cpf ?? $payer->cnpj)
            ->setPhone($phone)
            ->setMobilePhone($phone)
            ->setPostalCode($endereco->cep)
            ->setAddress($endereco->logradouro)
            ->setAddressNumber($endereco->numero)
            ->setComplement($endereco->complemento ?? '')
            ->setProvince($endereco->bairro)
            ->setNotificationDisabled(true)
            ->setExternalReference($payer->id)
            ->setObservations('cliente MEDB')
            ->setMunicipalInscription($payer->inscricao_municipal ?? '');
    
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return AsasCliente
     */
    public function setEmail($email)
    {
        abort_if((is_countable($email) && !count($email)) || !$email,
            400,
            'Nenhum email cadastrado para este cliente.'
        );
        if (is_countable($email)) {
            $this->email = $email[0];
        } else {
            $this->email = $email;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return AsasCliente
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCpfCnpj()
    {
        return $this->cpfCnpj;
    }

    /**
     * @param mixed $cpfCnpj
     * @return AsasCliente
     */
    public function setCpfCnpj($cpfCnpj)
    {
        abort_if(!$cpfCnpj, 422, 'Cliente sem CPF ou CNPJ cadastrado;');
        $this->cpfCnpj = $cpfCnpj;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param mixed $postalCode
     * @return AsasCliente
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressNumber()
    {
        return $this->addressNumber;
    }

    /**
     * @param mixed $addressNumber
     * @return AsasCliente
     */
    public function setAddressNumber($addressNumber)
    {
        $this->addressNumber = $addressNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     * @return AsasCliente
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * @param mixed $city
     * @return AsasCliente
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return AsasCliente
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param mixed $province
     * @return AsasCliente
     */
    public function setProvince($province)
    {
        $this->province = $province;
        return $this;
    }

    /**
     * @return array
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * @param string $key
     * @param string $value
     * @return AsasCliente
     */
    public function setMobilePhone($mobilePhone): AsasCliente
    {
        $this->mobilePhone = $mobilePhone;
        return $this;
    }


    

    /**
     * @return array
     */
    public function getNotificationDisabled()
    {
        return $this->notificationDisabled;
    }

      /**
     * @param mixed $notificationDisabled
     * @return AsasCliente
     */
    public function setNotificationDisabled($notificationDisabled): AsasCliente
    {
        $this->notificationDisabled = $notificationDisabled;
        return $this;
    }


        /**
     * @return array
     */
    public function getExternalReference()
    {
        return $this->externalReference;
    }

      /**
     * @param mixed $externalReference
     * @return AsasCliente
     */
    public function setExternalReference($externalReference): AsasCliente
    {
        $this->externalReference = $externalReference;
        return $this;
    }

    
        /**
     * @return array
     */
    public function getObservations()
    {
        return $this->observations;
    }

   /**
     * @param mixed $observations
     * @return AsasCliente
     */
    public function setObservations($observations): AsasCliente
    {
        $this->observations = $observations;
        return $this;
    }

          /**
     * @return array
     */
    public function getMunicipalInscription()
    {
        return $this->municipalInscription;
    }

     /**
     * @param mixed $municipalInscription
     * @return AsasCliente
     */
    public function setMunicipalInscription($municipalInscription): AsasCliente
    {
        $this->municipalInscription = $municipalInscription;
        return $this;
    }



    


    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }
}
