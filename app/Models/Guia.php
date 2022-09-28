<?php

namespace App\Models;

use App\Models\Traits\HasArquivos;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Guia extends Model
{
    use SoftDeletes, LogsActivity, HasArquivos;

    protected $table = 'guias';

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    const DELETED_AT = 'data_estorno';

    protected $dates = [
        'data_vencimento',
        'data_competencia'
    ];

    protected $fillable = [
        'empresas_id',
        'tipo',
        'data_vencimento',
        'usuarios_id',
        'data_competencia',
        'data_upload',
        'nome_guia',
        'data_estorno',
        'usuario_id_estorno',
        'estornado',
        'valor',
        'barcode',
        'padrao_data_vencimento'
    ];

    protected $casts = [
        'valor' => 'array',
        'erros' => 'array',
        'avisos' => 'array',
    ];

    const TIPO_INSS = 'INSS';
    const TIPO_HOLERITE = 'HOLERITE';
    const TIPO_OUTROS = 'OUTROS';
    const TIPO_IRRF = 'IRRF';
    const TIPO_PIS = 'PIS';
    const TIPO_COFINS = 'COFINS';
    const TIPO_IRPJ = 'IRPJ';
    const TIPO_CSLL = 'CSLL';
    const TIPO_ISS = 'ISS';
    const TIPO_DAS = 'DAS';
    const TIPO_HONORARIOS = 'HONORARIOS';
    const TIPO_FGTS = 'FGTS';
    const TIPO_PIS_COFINS = 'PIS/COFINS';
    const TIPO_IRPJ_CSLL = 'IRPJ/CSLL';

    const TIPOS_NAO_IMPOSTOS = [
        self::TIPO_HOLERITE,
        self::TIPO_OUTROS,
        self::TIPO_HONORARIOS,
        self::TIPO_FGTS,
    ];

    const TIPOS_RH = [
        self::TIPO_OUTROS,
        self::TIPO_HOLERITE,
        self::TIPO_INSS,
        self::TIPO_IRRF,
        self::TIPO_FGTS,
    ];

    const TIPOS_CONTABILIDADE = [
        self::TIPO_PIS,
        self::TIPO_COFINS,
        self::TIPO_IRPJ,
        self::TIPO_CSLL,
        self::TIPO_ISS,
        self::TIPO_DAS,
        self::TIPO_PIS_COFINS,
        self::TIPO_IRPJ_CSLL,
    ];

    const TIPOS_FINANCEIRO = [
        self::TIPO_HONORARIOS,
    ];


    const TIPOS = [
        self::TIPO_OUTROS,
        self::TIPO_HOLERITE,
        self::TIPO_INSS,
        self::TIPO_IRRF,
        self::TIPO_FGTS,
        self::TIPO_PIS,
        self::TIPO_COFINS,
        self::TIPO_IRPJ,
        self::TIPO_CSLL,
        self::TIPO_ISS,
        self::TIPO_DAS,
        self::TIPO_PIS_COFINS,
        self::TIPO_IRPJ_CSLL,
        self::TIPO_HONORARIOS,
    ];

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id', 'usuarios_id');
    }

    public function setDataVencimentoAttribute($value)
    {
        if (is_date_br($value)) {
            $this->attributes['data_vencimento'] = implode('-', array_reverse(explode('/', $value)));
        } else {
            $this->attributes['data_vencimento'] = date('Y-m-d', strtotime($value));
        }
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresas_id', 'id');
    }

    protected static function booted()
    {
        static::deleting(function (Guia $guia) {
            $guia->arquivo()->delete();
            activity('guias')->on($guia)->log('deletado_guia:' . $guia->tipo);
        });

        self::saving(function (Guia $guia) {
            if (!$guia->usuarios_id && $user = auth('api_usuarios')->user()) {
                $guia->usuarios_id = $user->getAuthIdentifier();
            }
            if (!$guia->data_upload) {
                $guia->data_upload = now();
            }
        });
    }
}
