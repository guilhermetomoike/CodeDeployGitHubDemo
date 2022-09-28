<?php


namespace App\Services\Recebimento\Gatway\Iugu\Common;


use App\Models\Empresa;
use App\Models\Payer\PayerContract;
use Illuminate\Support\Str;

class IuguCliente
{
    public $email;
    public $name;
    public $cpf_cnpj;
    public $zip_code;
    public $number;
    public $street;
    public $city;
    public $state;
    public $district;
    public $custom_variables = [];

    /**
     * IuguCliente constructor.
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
        $endereco = $payer->endereco;

        $this->setEmail($email)
            ->setName($payer->getName())
            ->setCpfCnpj($payer->cpf ?? $payer->cnpj)
            ->setZipCode($endereco->cep)
            ->setNumber($endereco->numero)
            ->setStreet($endereco->logradouro)
            ->setCity($endereco->cidade)
            ->setState($endereco->uf)
            ->setDistrict($endereco->bairro)
            ->setCustomVariables($payer->getModelAlias(), $payer->id);
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
     * @return IuguCliente
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
     * @return IuguCliente
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
        return $this->cpf_cnpj;
    }

    /**
     * @param mixed $cpf_cnpj
     * @return IuguCliente
     */
    public function setCpfCnpj($cpf_cnpj)
    {
        abort_if(!$cpf_cnpj, 422, 'Cliente sem CPF ou CNPJ cadastrado;');
        $this->cpf_cnpj = $cpf_cnpj;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zip_code;
    }

    /**
     * @param mixed $zip_code
     * @return IuguCliente
     */
    public function setZipCode($zip_code)
    {
        $this->zip_code = $zip_code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     * @return IuguCliente
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     * @return IuguCliente
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return IuguCliente
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     * @return IuguCliente
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @param mixed $district
     * @return IuguCliente
     */
    public function setDistrict($district)
    {
        $this->district = $district;
        return $this;
    }

    /**
     * @return array
     */
    public function getCustomVariables(): array
    {
        return $this->custom_variables;
    }

    /**
     * @param string $key
     * @param string $value
     * @return IuguCliente
     */
    public function setCustomVariables(string $key, string $value): IuguCliente
    {
        $this->custom_variables[] = ['name' => $key, 'value' => $value];
        return $this;
    }

    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }
}
