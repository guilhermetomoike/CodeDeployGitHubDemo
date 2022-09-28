<?php


namespace App\Services\Recebimento;


use App\Services\Recebimento\Contracts\RecebimentoCartao;
use App\Services\Recebimento\Contracts\Recebimento;
use App\Services\Recebimento\Gatway\Iugu\IuguService;
use App\Services\Recebimento\Gatway\PjBank\PjbankService;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RecebimentoService
{
    /**
     * @param $gatway
     * @return Recebimento|RecebimentoCartao
     */
    public function initialize(string $gatway): Recebimento
    {
        switch ($gatway) {
            case 'pjbank':
                return new class extends PjbankService{};
            case 'iugu':
                return new IuguService;
        }

        throw new HttpException(500, 'Nenhum gatway de recebimento informado.');
    }

}
