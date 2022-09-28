<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles, SoftDeletes;

    protected $table = 'usuarios';

    protected $guard_name = 'api_usuarios';

    protected $fillable = [
        'id',
        'usuario',
        'nome_completo',
        'senha',
        'tipo',
        'data_criacao',
        'ativo',
        'email',
        'avatar',
        'email_integracao',
        'senha_email',
        'telefone_celular',
        'email_medb',
        'senha_email_medb',
    ];

    protected $hidden = [
        'senha',
        'senha_email',
        'senha_email_medb',
    ];

    public function departamento()
    {
        return $this->belongsToMany(Departamento::class, 'departamentos_usuarios');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getFirstName()
    {
        return explode(' ', $this->nome_completo)[0];
    }

    public function carteira()
    {
        return $this->hasOne(Carteira::class, 'responsavel_id');
    }

    public function setSenhaAttribute($value)
    {
        $this->attributes['senha'] = md5($value);
    }

    public function routeNotificationForOneSignal()
    {
        return [
            'include_external_user_ids' => ['usuario_id_' . (string)$this->id]
        ];
    }
}
