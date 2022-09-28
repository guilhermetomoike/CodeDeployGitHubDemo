<?php

namespace App\Models;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Manager;

class Upload extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected $fillable = ['label', 'name', 'path', 'data_competencia', 'there_is_error', 'error_message', 'causer_type', 'causer_id'];

    public function causer()
    {
        return $this->morphTo('causer');
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function (self $upload) {
            if ($auth = Auth::guard('api_usuarios')->user()) {
                $type = Usuario::class;
            } else if ($auth = Auth::guard('api_clientes')->user()) {
                $type = Cliente::class;
            }
            if (!$auth) return;
            $upload->causer_id = $auth->getAuthIdentifier();
            $upload->causer_type = array_search($type, Relation::morphMap()) ?? $type;
        });
    }
}
