<?php

namespace App\Models;

use App\Events\EmpresaCadastradaEvent;
use App\Models\Cliente\ResidenciaMedica;
use App\Models\Empresa\RequiredGuide;
use App\Models\Payer\PayerContract;
use App\Models\Nfse\Nfse;
use App\Models\Empresa\AcessoPrefeitura;
use App\Models\Empresa\Alvara;
use App\Models\Empresa\AlvaraSanitario;
use App\Models\Empresa\Bombeiro;
use App\Models\Empresa\Cnae;
use App\Models\Empresa\Coworking;
use App\Models\Empresa\MotivoDesativacao;
use App\Models\Empresa\Procuracao;
use App\Models\Payer\Payer;
use App\Models\Traits\HasArquivos;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Modules\Evaluation\Entities\EvaluationEntity;
use Modules\Invoice\Entities\ContasReceber;
use Modules\Invoice\Entities\Fatura;
use Modules\Onboarding\Entities\EmpresaPosCadastroOnboarding;
use Modules\Plans\Entities\PlanSubscription;
use Spatie\Activitylog\Traits\LogsActivity;

class Empresa extends Model implements PayerContract, NotifiableContract
{
    use Notifiable, LogsActivity, SoftDeletes, HasArquivos, Payer;

    protected $table = 'empresas';

    protected $fillable = [
        'iugu_id', 'tem_cadastro_plugnotas', 'tem_cadastro_dominio', 'inscricao_municipal', 'inicio_atividades', 'regime_tributario',
        'numero_crm_juridico', 'tipo_societario', 'type', 'clinica_fisica', 'nome_fantasia', 'razao_social', 'status_id',
        'codigo_acesso_simples', 'data_sn', 'cnpj', 'trimestral', 'nire', 'pay_cont_id'
    ];

    protected $dispatchesEvents = [
        'created' => EmpresaCadastradaEvent::class
    ];

    protected $appends = ['status_label'];

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected static string $payer_name_column = 'razao_social';

    public static array $status = [
        1 => 'Processando',
        2 => 'Aguardando assinatura',
        3 => 'Aguardando certificado',
        4 => 'Aguardando CNPJ',
        5 => 'Aguardando alvará',
        6 => 'Aguardando acesso',
        7 => 'Aguardando simples',
        8 => 'Aguardando Documentação',
        9 => 'Pré-cadastro',
        70 => 'Desativação Agendada',
        71 => 'Desativada',
        80 => 'Congelamento Agendado',
        81 => 'Congelada',
        99 => 'Aguardando ativação',
        100 => 'Ativa',
    ];

    public function getStatusLabelAttribute()
    {
        return self::$status[$this->attributes['status_id'] ?? 100] ?? 'Não definido';
    }

    public function routeNotificationForWhatsApp()
    {
        return $this->contatos()->whatsapp();
    }

    public function routeNotificationForMail()
    {
        return $this->contatos()->email();
    }

    public function socios()
    {
        return $this->belongsToMany(Cliente::class, 'clientes_empresas', 'empresas_id', 'clientes_id')
            ->withPivot('porcentagem_societaria', 'socio_administrador', 'prolabore_fixo', 'valor_prolabore_fixo', 'percentual_prolabore');
    }


    public function sociosAdicionais()
    {

        return $this->belongsToMany(Cliente::class, 'clientes_empresas', 'empresas_id', 'clientes_id')
            ->whereNotIn('clientes.profissao_id', [9, 15, 18, 19, 20, 21, 22])
            ->select('clientes_empresas.clientes_id');
    }

    public function socioAdministrador()
    {
        return $this->socios()->wherePivot('socio_administrador', 1);
    }

    public function guias()
    {
        return $this->hasMany(Guia::class, 'empresas_id');
    }
    public function guiasCompetencia()
    {
        return $this->hasMany(Guia::class, 'empresas_id')->where('data_competencia', Carbon::now()->subMonth()->setDay(1)->format('Y-m-d'));
    }
    public function guiasLastSix()
    {
        return $this->hasMany(Guia::class, 'empresas_id')->orderBy('data_competencia','asc')->where('data_competencia','>', Carbon::now()->subMonth(7)->setDay(1)->format('Y-m-d'));
    }


    public static function getSociosId($id)
    {
        return DB::table('clientes_empresas')
            ->where('empresas_id', $id)
            ->get()
            ->pluck('clientes_id')
            ->toArray();
    }

    public function faturamentos($qtd = 12)
    {
        $mes = today()->subMonths($qtd)->format('Y-m-01');

        return $this->hasMany(Faturamento::class, 'empresas_id')
            ->where('mes', '>=', $mes)
            ->orderByDesc('mes');
    }

    public function faturamento($competencia = '')
    {
        if (!$competencia) {
            $competencia = Carbon::now()->subMonths(1)->setDay(1)->format('Y-m-d');
        }

        return $this->hasOne(EmpresasFaturamento::class, 'empresas_id', 'id')
            ->where('mes', $competencia);
    }

    public function faturamentoAdicionais($competencia = '')
    {
        if (!$competencia) {
            $competencia = Carbon::now()->subMonths(2)->setDay(1)->format('Y-m-d');
        }

        return $this->hasOne(EmpresasFaturamento::class, 'empresas_id', 'id')
            ->where('mes', $competencia)->select('empresas_faturamentos.faturamento', 'empresas_faturamentos.empresas_id');
    }


    public function funcionarios()
    {
        return $this->hasMany(EmpresaFuncionario::class, 'empresa_id', 'id');
    }
    public function receitas()
    {
        return $this->hasMany(Receita::class, 'empresa_id', 'id');
    }
    public function receitasCompetencia()
    {
        return $this->hasOne(Receita::class, 'empresa_id', 'id')->where('data_competencia', Carbon::now()->subMonth()->setDay(1)->format('Y-m-d'));
    }

    public function contrato()
    {
        return $this->hasOne(Contrato::class, 'empresas_id', 'id');
    }

    public function nfse()
    {
        return $this->hasMany(Nfse::class, 'empresas_id')
            ->orderBy('emissao', 'desc');
    }

    public function motivoCongelamento()
    {
        return $this->hasMany(EmpresaMotivoCongelamento::class, 'empresas_id', 'id');
    }

    public function cartao_credito()
    {
        return $this->morphMany(CartaoCredito::class, 'payer');
    }

    public function certificado_digital()
    {
        return $this->morphOne(CertificadoDigital::class, 'owner');
    }

    public function transacao_recebimento()
    {
        return $this->morphMany(TransacaoRecebimento::class, 'chargeable');
    }

    public function contas_bancarias()
    {
        return $this->morphMany(ContaBancaria::class, 'owner')
            ->leftJoin('bancos', 'bancos.id', '=', 'banco_id')
            ->select(
                'conta_bancarias.id',
                'conta_bancarias.owner_type',
                'conta_bancarias.owner_id',
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

    public function endereco()
    {
        return $this->morphOne(Endereco::class, 'addressable');
    }

    public function motivo_desativacao()
    {
        return $this->hasOne(MotivoDesativacao::class, 'empresa_id', 'id');
    }

    public function acessos_prefeituras()
    {
        return $this->hasMany(AcessoPrefeitura::class, 'empresas_id', 'id');
    }
    public function acessos_deiss()
    {
        return $this->hasMany(AcessoPrefeitura::class, 'empresas_id', 'id')->where('tipo', 'deiss');
    }

    public function precadastro()
    {
        return $this->hasOne(EmpresaPreCadastro::class);
    }

    public function guia_liberacao()
    {
        return $this->hasMany(GuiaLiberacao::class, 'empresa_id', 'id')
            ->orderByDesc('competencia');
    }

    public function contatos()
    {
        return $this->morphMany(Contato::class, 'contactable');
    }

    public function residencia_medica()
    {
        return $this->hasOne(ResidenciaMedica::class, 'empresa_id', 'id')
            ->where('cliente_residencia.data_conclusao', '>', Carbon::now())
            ->orderBy('cliente_residencia.id', 'DESC');
    }
    public function residencia_medica_arquivo()
    {
        return $this->hasOne(ResidenciaMedica::class, 'empresa_id', 'id')
            ->where('cliente_residencia.data_conclusao', '>', Carbon::now())
            ->join('arquivos', 'arquivos.model_id', 'cliente_residencia.id')
            ->where('model_type', 'residencia_medica')
            ->select('arquivos.id as arquivo_id')
            ->orderBy('arquivos.id', 'DESC');
    }

    public function carteiras()
    {
        return $this->belongsToMany(Carteira::class, 'carteira_empresa', 'empresa_id', 'carteira_id');
    }
    public function carteirasrel()
    {
        return $this->belongsToMany(Carteira::class, 'carteira_empresa', 'empresa_id', 'carteira_id')->select('carteiras.nome', 'carteiras.id')->where('carteiras.setor', '<>', 'rh');
    }
    public function carteirasContabil()
    {
        return $this->belongsToMany(Carteira::class, 'carteira_empresa', 'empresa_id', 'carteira_id')->select('carteiras.nome', 'carteiras.id')->where('carteiras.nome','like' ,'%Contábil%');
    }

    public function cnae()
    {
        return $this->hasOne(Cnae::class);
    }

    public function alvara()
    {
        return $this->hasOne(Alvara::class);
    }
    public function alvara_sanitario()
    {
        return $this->hasOne(AlvaraSanitario::class);
    }
    public function bombeiro()
    {
        return $this->hasOne(Bombeiro::class);
    }
    public function coworking()
    {
        return $this->hasOne(Coworking::class);
    }
    public function procuracaopf()
    {
        return $this->hasOne(Procuracao::class)->where('tipo', 'pf');
    }
    public function procuracaopj()
    {
        return $this->hasOne(Procuracao::class)->where('tipo', 'pj');
    }
    public function comentarios()
    {
        return $this->morphMany(Comentario::class, 'commentable')->latest();
    }

    public function label()
    {
        return $this->morphOne(Label::class, 'labelable');
    }

    public function required_guide()
    {
        return $this->belongsToMany(RequiredGuide::class, 'company_required_guides', 'empresa_id', 'required_guide_id');
    }

    public function poscadastro_onboardings()
    {
        return $this->hasMany(EmpresaPosCadastroOnboarding::class);
    }

    public function getArquivosEmpresaByName(string $nome)
    {
        return Arquivo::query()
            ->where('model_type', $this->getMorphClass())
            ->where('model_id', $this->id)
            ->where('nome', $nome)
            ->get();
    }

    public function evaluations()
    {
        return $this->morphMany(EvaluationEntity::class, 'evaluable');
    }

    public function appSettings()
    {
        return $this->morphOne(AppSettings::class, 'person');
    }
    public function contas_receber()
    {
        $mes = Carbon::now()->setDay(20)->format('Y-m-d');
        return $this->hasOne(ContasReceber::class, 'payer_id', 'id')->where('vencimento', $mes);
    }
    public function fatura()
    {
        // $mes= Carbon::now()->setDay(15)->format('Y-09-d');
        return $this->hasOne(Fatura::class, 'payer_id', 'id')
            ->where('fatura.data_vencimento', '>', Carbon::now()->format('Y-m-01'))
            ->where('fatura.data_vencimento', '<',  Carbon::now()->format('Y-m-30'))
            ->where('fatura.payer_type', 'empresa');
    }
    public function faturaAnualCong()
    {
        // $mes= Carbon::now()->setDay(15)->format('Y-09-d');
        return $this->hasOne(Fatura::class, 'payer_id', 'id')
            ->where('fatura.data_competencia', '>', Carbon::now()->format('Y-04-01'))
            ->where('fatura.data_competencia', '<',  Carbon::now()->format('Y-04-30'))
            ->where('fatura.payer_type', 'empresa');
    }
    public function ultfatura()
    {
        // $mes= Carbon::now()->setDay(15)->format('Y-09-d');
        return $this->hasOne(Fatura::class, 'payer_id', 'id')
            ->where('fatura.payer_type', 'empresa')
            ->orderByDesc('id');
    }
    public function priTreefatura()
    {
        // $mes= Carbon::now()->setDay(15)->format('Y-09-d');
        return $this->hasMany(Fatura::class, 'payer_id', 'id')
            ->where('fatura.payer_type', 'empresa');
    }
    public function ultSixMonths()
    {
        return $this->hasMany(Fatura::class, 'payer_id', 'id')
            ->where('data_vencimento', '>', Carbon::now()->subMonths(6)->format('Y-m-15'))
            ->where('fatura.payer_type', 'empresa');
    }
    public function plansubscription()
    {
        return $this->hasOne(PlanSubscription::class, 'payer_id', 'id')->orderby('created_at', 'desc');
    }
}
