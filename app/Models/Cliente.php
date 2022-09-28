<?php

namespace App\Models;

use App\Models\Cliente\ClientAccess;
use App\Models\Payer\Payer;
use App\Models\Payer\PayerContract;
use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Modules\Evaluation\Entities\EvaluationEntity;
use Modules\Irpf\Entities\DeclaracaoIrpf;
use Modules\Irpf\Entities\IrpfClienteResposta;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cliente extends Authenticatable implements JWTSubject, PayerContract
{
    use Notifiable, HasRoles, SoftDeletes, HasArquivos, Payer;

    protected $table = 'clientes';

    protected $guard_name = 'api_clientes';

    protected static string $payer_name_column = 'nome_completo';

    protected $fillable = [
        'nome_completo', 'cpf', 'rg', 'situacao_cadastral', 'email', 'data_nascimento', 'sexo', 'regime_casamento',
        'naturalidade', 'nome_mae', 'pis', 'clinica_fisica', 'qualificacao', 'nacionalidade', 'avatar',
        'senha', 'estado_civil_id', 'profissao_id', 'qualificacao_id', 'especialidade_id', 'clicksign_key', 'iugu_id','pay_cont_id'
    ];

    protected $hidden = [
        'senha',
    ];

    public function empresa()
    {
        return $this->belongsToMany(Empresa::class, 'clientes_empresas', 'clientes_id', 'empresas_id');
    }

    public function getFirstName()
    {
        return explode(' ', $this->nome_completo)[0];
    }

    public function setSenhaDefault()
    {
        $this->update(['senha' => $this->cpf]);
        return $this->cpf;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function prolabore()
    {
        return $this->hasMany(Prolabore::class, 'clientes_id', 'id');
    }

    public function cartao_credito()
    {
        return $this->morphMany(CartaoCredito::class, 'payer');
    }

    public function arquivo()
    {
        return $this->hasMany(ArquivoCliente::class, 'clientes_id', 'id');
    }

    public function setSenhaAttribute($value)
    {
        $this->attributes['senha'] = md5($value);
    }

    public function setNomeCompletoAttribute($value)
    {
        $this->attributes['nome_completo'] = ucwords(mb_strtolower($value));
    }

    public function setNacionalidadeAttribute($value)
    {
        $this->attributes['nacionalidade'] = ucwords(strtolower($value));
    }

    public function irpf_item()
    {
        return $this->hasMany(IrpfClienteResposta::class, 'cliente_id', 'clientes.id')
            ->leftJoin('irpf_questoes', 'irpf_questoes.id', '=', 'irpf_questao_id')
            ->select(
                'irpf_item.id',
                'irpf_item.cliente_id',
                'irpf_item.resposta',
                'irpf_item.qtd',
                'irpf_item.ano',
                'irpf_questoes.pergunta',
                'irpf_questoes.quantitativo'
            );
    }

    public function contas_bancarias()
    {
        return $this->morphMany(ContaBancaria::class, 'owner')
            ->leftJoin('bancos', 'bancos.id', '=', 'banco_id')
            ->select(
                'conta_bancarias.id',
                'bancos.nome',
                'cpf_cnpj',
                'agencia',
                'dv_agencia',
                'conta',
                'dv_conta',
                'tipo',
                'pessoa',
                'banco_id',
                'principal'
            );
    }

    public function contatos()
    {
        return $this->morphMany(Contato::class, 'contactable');
    }

    public function celulares()
    {
        return $this->contatos()->where('tipo', 'celular');
    }

    public function emails()
    {
        return $this->contatos()->where('tipo', 'email');
    }

    public function endereco()
    {
        return $this->morphOne(Endereco::class, 'addressable');
    }

    public function ies()
    {
        return $this->belongsTo(Ies::class);
    }

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class);
    }

    public function estado_civil()
    {
        return $this->belongsTo(EstadoCivil::class);
    }

    public function profissao()
    {
        return $this->belongsTo(Profissao::class);
    }

    public function qualificacao()
    {
        return $this->belongsTo(Qualificacao::class);
    }

    public function irpf()
    {
        return $this->hasOne(DeclaracaoIrpf::class);
    }

    public function routeNotificationForWhatsApp()
    {
        return $this->contatos()->whatsapp();
    }

    public function routeNotificationForMail()
    {
        return $this->contatos()->email();
    }

    public function certificado_digital()
    {
        return $this->morphOne(CertificadoDigital::class, 'owner');
    }

    public function routeNotificationForOneSignal()
    {
        return [
            'include_external_user_ids' => [(string)$this->id]
        ];
    }

    public function getAvatarUrl()
    {
        return $this->avatar ?
            url("clientes/{$this->id}/avatar", [], config('app.env') == 'production') :
            null;
    }

    public function evaluations()
    {
        return $this->morphMany(EvaluationEntity::class, 'evaluable');
    }

    public function appSettings()
    {
        return $this->morphOne(AppSettings::class, 'person');
    }

    public function access()
    {
        return $this->hasMany(ClientAccess::class, 'client_id', 'id');
    }

    public function course()
    {
        return $this->hasMany(ClienteCourse::class);
    }
    public function carteirasrel()
    {
        return $this->belongsToMany(Empresa::class, 'clientes_empresas', 'clientes_id', 'empresas_id')
        ->join('carteira_empresa','carteira_empresa.empresa_id',  'clientes_empresas.empresas_id')
        ->join('carteiras','carteiras.id','carteira_empresa.carteira_id')
        ->select('carteiras.id','carteiras.nome')->where('carteiras.setor','<>','rh');
    }
    public function sociosiguais()
    {
        return $this->belongsToMany(Empresa::class, 'clientes_empresas', 'clientes_id', 'empresas_id');

    }
}
