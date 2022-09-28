<?php

namespace App\Models;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Model;

class EmpresaEmailEnvio extends Model
{
    protected $table = 'empresas_emails';

    protected $fillable = [
        'empresas_id', 'usuarios_id', 'email'
    ];

    public function getEmailUsuario()
    {
        return $this->hasOne(Usuario::class, 'id', 'usuarios_id');
    }
}
