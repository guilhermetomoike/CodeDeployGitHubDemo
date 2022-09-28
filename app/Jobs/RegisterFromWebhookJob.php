<?php

namespace App\Jobs;

use App\Models\Arquivo;
use App\Models\Carteira;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\EstadoCivil;
use App\Models\Ies;
use App\Models\Invite;
use App\Models\Profissao;
use App\Models\Usuario;
use App\Repositories\InviteRepository;
use App\Services\PloomesIntegration\ApiPloomes;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegisterFromWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $dealId;

    public function __construct(int $dealId)
    {
        $this->dealId = $dealId;
    }

    public function handle(ApiPloomes $apiPloomes)
    {
        $inviteRepository = new InviteRepository();
        /** @var Invite $invite */
        $invite = $inviteRepository->getInviteByPloomesDealId($this->dealId);

        if (!empty($invite)) {
            $invite->confirmado();
        }

        $quote = $apiPloomes->getQuoteData($this->dealId);

        $email = $quote->getEmail();
        $celular = $quote->getPhones();
        $enderecoObject = $quote->getAddress();
        $profissao = $quote->getProfession();
        $university = $quote->getUniversity();
        $estado_civil = $quote->getStadoCivil();
        $attachmentsUrl = $quote->getAttachmentsUrl();

        $cliente = [
            'nome_completo' => $quote->getNomeCompleto(),
            'cpf' => $quote->getCpf(),
            'rg' => $quote->getRg(),
            'data_nascimento' => Carbon::parse($quote->getBirthday())->toDateString(),
            'profissao_id' => $this->validateProfession($profissao),
            'estado_civil_id' => $this->validateEstadoCivil($estado_civil),
        ];

        $vendedorName = $quote->getCreatorName();
        $carteira = Carteira::query()->where('setor', 'onboarding')->first();

        try {
            DB::beginTransaction();
            $empresa = new Empresa();
            $empresa->status_id = 9;
            $empresa->save();

            $cliente = Cliente::query()->updateOrCreate(['cpf' => $cliente['cpf']], $cliente);

            if ($cliente) {
                $empresa->socios()->attach([$cliente->id => [
                    'porcentagem_societaria' => 100,
                    'socio_administrador' => true
                ]]);
            }

            $mapedContacts = $this->mapContacts($email, $celular);

            $address = $this->validateAddress($enderecoObject);
            if ($address) {
                $cliente->endereco()->create($address);
            }

            $university = $this->validateUniversity($university);
            if ($university) {
                $cliente->course()->create(['ies_id' => $university]);
            }

            $cliente->contatos()->createMany($mapedContacts);
            $empresa->contatos()->createMany($mapedContacts);
            $empresa->precadastro()->create([
                'tipo' => 'abertura',
                'usuario_id' => $this->validateVendedor($vendedorName),
                'responsavel_onboarding_id' => $carteira->id,
                'empresa' => []
            ]);

            $attachments = $this->downloadFiles($attachmentsUrl);
            if ($contratoFile = $attachments->firstWhere('nome', 'contrato')) {
                $contrato = $empresa->contrato()->create([
                    'signed_at' => now(),
                    'extra' => [],
                    'dia_vencimento' => 20,
                    'forma_pagamento_id' => 1
                ]);
                $contrato->arquivo()->save($contratoFile);
            }

            if ($socioAttachments = $attachments->whereIn('nome', ['rg', 'cpf', 'comprovante_de_residencia'])) {
                $cliente->arquivos()->saveMany($socioAttachments);
            }

            if ($empresaAttachments = $attachments->whereIn('nome', ['proposta'])) {
                $empresa->arquivos()->saveMany($empresaAttachments);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::channel('stack')->info(json_encode($exception->getMessage()));
            throw $exception;
        }

    }

    private function downloadFiles($urls)
    {
        $uploads = new Collection();
        foreach ($urls as $name => $url) {
            $extension = pathinfo($url, PATHINFO_EXTENSION);
            $fileName = Str::random() . '.' . $extension;
            Storage::put($fileName, file_get_contents($url));
            $arquivo = Arquivo::query()->create([
                'nome_original' => $name,
                'caminho' => $fileName,
                'nome' => $this->validateFileName($name)
            ]);
            $uploads->add($arquivo);
        }
        return $uploads;
    }

    private function validateFileName($name)
    {
        if (preg_match("/\bcontrato\b/i", $name)) {
            return 'contrato';
        }
        if (preg_match("/\bcomprovante.*resid.?ncia\b/i", $name)) {
            return 'comprovante_de_residencia';
        }
        if (preg_match("/\b(cpf)|(cnh)\b/i", $name)) {
            return 'cpf';
        }
        if (preg_match("/\brg\b/i", $name)) {
            return 'rg';
        }

        return $name;
    }

    private function validateAddress(array $enderecoObject)
    {
        if (!$enderecoObject['cep']) {
            return false;
        }

        $address = consulta_cep1($enderecoObject['cep']);

        if (!$address) {
            return false;
        }

        $enderecoObject['cidade'] = $address->municipio;
        $enderecoObject['uf'] = $address->uf;
        $enderecoObject['ibge'] = $address->ibge;
        $enderecoObject['numero'] = substr($enderecoObject['numero'], 0, 9);
        return $enderecoObject;
    }

    private function mapContacts($email, array $celular)
    {
        $contacts = [
            [
                'tipo' => 'email',
                'value' => $email,
                'optin' => true,
            ]
        ];
        foreach ($celular as $numero) {
            $contacts[] = [
                'tipo' => 'celular',
                'value' => $numero,
                'optin' => true,
                'options' => ['is_whatsapp' => true],
            ];
        }

        return $contacts;
    }

    private function validateProfession($profissao)
    {
        $profissao = strtolower(clean_string($profissao));
        if (substr($profissao, -1) == 'a') {
            $profissao = substr($profissao, 0, -1);
        }
        if (substr($profissao, -3) == '(a)') {
            $profissao = trim(str_replace(['(a)'], '', $profissao));
        }
        $profissao = Profissao::query()->firstWhere('nome', 'like', $profissao . '%');

        return $profissao ? $profissao->id : null;
    }

    private function validateEstadoCivil($estado_civil)
    {
        $estado_civil = strtolower(clean_string($estado_civil));
        if (substr($estado_civil, -1) == 'a') {
            $estado_civil = substr($estado_civil, 0, -1);
        }
        if (substr($estado_civil, -3) == '(a)') {
            $estado_civil = trim(str_replace(['(a)'], '', $estado_civil));
        }
        $estado_civil = EstadoCivil::query()->firstWhere('nome', 'like', $estado_civil . '%');

        return $estado_civil ? $estado_civil->id : null;
    }

    private function validateUniversity(?string $university)
    {
        if (!$university) {
            return false;
        }

        $university = strtolower(clean_string($university));

        $university_inst = Ies::query()->firstWhere('nome', 'like', '%' . $university . '%');

        return $university_inst ? $university_inst->id : null;
    }

    private function validateVendedor($vendedorName)
    {
        $user = Usuario
                ::query()
                ->firstWhere('nome_completo', 'like', explode(' ', $vendedorName)[0] . '%');

        return $user ? $user->id : null;
    }
}
