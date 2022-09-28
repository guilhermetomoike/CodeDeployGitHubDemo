<?php

namespace App\Models\Nfse;

use App\Jobs\DownloadPdfNfseJob;
use App\Models\Empresa;
use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Symfony\Component\HttpFoundation\File\File;

class Nfse extends Model
{
    use SoftDeletes, LogsActivity, HasArquivos;

    protected $table = 'empresas_nfse';

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    const DELETED_AT = 'cancelada_at';

    protected $dates = [
        'emissao'
    ];

    protected $casts = [
        'payload' => 'object'
    ];

    protected $fillable = [
        'pdf_externo', 'empresas_id', 'prestador', 'tomador', 'numero_nfse', 'valor_nota', 'id_tecnospeed', 'status', 'protocol',
        'mensagem', 'arquivo', 'serie', 'lote', 'codigo_verificacao', 'data_autorizacao', 'mensagem_retorno', 'emissao',
        'cancelada_at', 'previsao_recebimento', 'payload', 'descricao', 'email', 'created_at', 'competencia', 'fatura_id'
    ];

    public function arquivo_nfse()
    {
        return $this->arquivo();
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresas_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function (Nfse $nfse) {
            if ($nfse->pdf_externo) dispatch(new DownloadPdfNfseJob($nfse));
        });

        static::updated(function (Nfse $nfse) {
            if ($nfse->wasChanged('pdf_externo')) dispatch(new DownloadPdfNfseJob($nfse));
        });
    }

    public function setEmissaoAttribute($value)
    {
        if (!count(explode('-', $value))) {
            $this->attributes['emissao'] = date_from_br($value);
        }
        $this->attributes['emissao'] = substr($value, 0, 10);
    }

    public function setMensagemRetornoAttribute($value)
    {
        $this->attributes['mensagem_retorno'] = str_replace(
            ['linedelimiter', 'delimiter'], ['<br>', ' | '], stripcslashes(clean_string($value))
        );
    }

    public function setStatusAttribute($value)
    {
        if ($value == 'CANCELADO') {
            $this->attributes['cancelada_at'] = now();
        }
        $this->attributes['status'] = $value;
    }
}
