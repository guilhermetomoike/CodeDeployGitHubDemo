<?php

namespace Modules\Contratantes\Entities;

use App\Models\Contato;
use App\Models\Endereco;
use Illuminate\Database\Eloquent\Model;

class Contratante extends Model
{
    protected $fillable = ['nome'];

    protected $with = ['endereco', 'email', 'celular'];

    public function endereco()
    {
        return $this->morphOne(Endereco::class, 'addressable');
    }

    public function contatos()
    {
        return $this->morphMany(Contato::class, 'contactable');
    }
    
    public function email()
    {
        return $this
            ->morphOne(Contato::class, 'contactable')
            ->where('tipo', 'email');
    }
    
    public function celular()
    {
        return $this
            ->morphOne(Contato::class, 'contactable')
            ->where('tipo', 'celular');
    }
}
