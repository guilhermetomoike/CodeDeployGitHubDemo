<?php

namespace Modules\Activity\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest
{
    public function rules()
    {
        return [
            'executed' => ["required", 'boolean'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
