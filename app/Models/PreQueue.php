<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreQueue extends Model
{
    protected $table = 'pre_queue';

    protected $fillable = ['job_id', 'tipo', 'usuario_id', 'cliente_id', 'empresa_id', 'payload', 'dispatched_at'];

    public static function getDispatchableJobs()
    {
        return self::query()
            ->where('tipo', 'pgbl_mail')
            ->whereNull('dispatched_at')
            ->get();
    }
}
