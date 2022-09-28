<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class GuiaLiberacao extends Model
{
    protected $table = 'guias_liberacao';

    protected $fillable = [
        'id',
        'empresa_id',
        'competencia',
        'financeiro_departamento_liberacao',
        'rh_departamento_liberacao',
        'contabilidade_departamento_liberacao',
        'congelado',
        'erro_envio',
        'data_envio',
        'sem_guia',
        'error_message',
        'liberado',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function setEnviado()
    {
        return $this->update([
            'data_envio' => Carbon::now()->format('Y-m-d H:i'),
            'erro_envio' => 0,
            'sem_guia' => 0,
        ]);
    }

    public function setErroEnvio($message)
    {
        return $this->update([
            'erro_envio' => 1,
            'error_message' => $message,
        ]);
    }

    public function guias()
    {
        return $this->hasMany(Guia::class, 'empresas_id', 'empresa_id');
    }
}
