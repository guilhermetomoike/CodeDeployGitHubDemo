<?php


namespace App\Services\Cliente;


use App\Mail\ClienteNovaSenhaMail;
use App\Repositories\ClienteRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordService
{
    private ClienteRepository $clienteRepository;

    public function __construct(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function resetPassword(string $cpf, string $email)
    {
        $cliente = $this->clienteRepository->search($cpf)->first();
        $emails = $cliente->contatos()->email();

        if ($emails->count() == 0 || !$emails->contains($email)) {
            throw new \Exception('Email não corresponde ao do cadastro.', 400);
        }

        $data['senha'] = mb_strtolower(Str::random(8));
        $this->clienteRepository->updateCliente($cliente->id, $data);

        Mail::to($email)
            ->send(new ClienteNovaSenhaMail($data['senha']));
    }

    public function getInfo(string $cpf)
    {
        $cliente = $this->clienteRepository->search($cpf)->first();
        if (!$cliente) return false;
        $emails = $cliente->contatos()->email();

        if ($emails->count() == 0) {
            return false;
        }

        return $this->truncateEmail($emails->first());
    }

    private function truncateEmail(string $email)
    {
        [$name, $domain] = explode('@', $email);
        $length = floor(strlen($name) / 2);
        $truncatedName = substr($name, 0, $length) . str_repeat('*', $length);
        return $truncatedName . '@' . $domain;
    }
}
