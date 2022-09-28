<?php

namespace Modules\Irpf\Entities;

use Illuminate\Database\Eloquent\Model;

class IrpfInputPendencia extends Model
{
    protected $table = 'irpf_pendencia_input';

    protected $fillable = ['irpf_pendencia_id', 'type', 'label', 'name',];

    public function value()
    {
        return $this->hasOne();
    }
}
