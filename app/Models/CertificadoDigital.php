<?php

namespace App\Models;

use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;

class CertificadoDigital extends Model
{
    use HasArquivos;

    protected $table = 'certificados';

    protected $fillable = ['senha', 'validade', 'codigo', 'isWithCustomer','isWithPartner'];
}
