<?php

namespace App\Models\OrdemServico;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OsAtividadeBase extends Model
{
    protected $table = 'os_atividade_base';

    protected $casts = [
        'envio_email' => 'boolean',
        'input' => 'object',
    ];

    protected $fillable = [
        'nome', 'descricao', 'input', 'sla_hora',
    ];

    public function setInputAttribute($value)
    {
        foreach ($value as &$item) {
            $item['nome'] = Str::slug($item['nome'], '_');
        }

        $this->attributes['input'] = json_encode($value);
    }
}
