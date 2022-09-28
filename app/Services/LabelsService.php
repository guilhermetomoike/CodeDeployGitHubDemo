<?php

namespace App\Services;

use App\Models\Label;

class LabelsService
{
    public function storeLabel(array $data)
    {
        $label = Label::create($data);

        return $label->fresh();
    }

    public function updateLabel(array $data, Label $label)
    {
        return $label->fill($data)->save();
    }
}
