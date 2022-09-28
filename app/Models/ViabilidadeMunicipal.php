<?php

namespace App\Models;

use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ViabilidadeMunicipal extends Model
{
    use HasArquivos;
    use LogsActivity;

    protected $table = 'viabilidade_municipal';

    protected $casts = ['documentos_necessarios' => 'array'];

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    protected $fillable = [
        'cidade_id',
        'alvara_endereco_fiscal',
        'cnae_exigido',
        'vigilancia',
        'modelo_solicitacao',
        'modelo_solicitacao_site',
        'tempo_emissao_alvara',
        'tempo_emissao_licenca_sanitaria',
        'valor_licenca_sanitaria',
        'valor_alvara',
        'percentual_iss',
        'nfs_eletronica_manual',
        'crm_juridico',
        'documentos_necessarios',
        'abertura_area_rual',
        'mes_renovacao_alvara',
        'observacoes',
        'modelo_solicitacao_email',
        'nfs_eletronica_manual_site',
    ];

    protected $with = ['cidade'];

    public function cidade() {
        return $this->belongsTo(Cidade::class);
    }
}
