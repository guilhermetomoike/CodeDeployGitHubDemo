<?php

namespace Modules\Activity\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CarteiraEmpresa
 * @package Modules\Activity\Entities
 *
 * @property integer id
 * @property integer carteira_id
 * @property integer empresa_id
 */
class CarteiraEmpresa extends Model
{
    protected $table = 'carteira_empresa';
}
