<?php

namespace Modules\Plans\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Plans\Entities\PlansIntervalType;
use Modules\Plans\Entities\PlansPayableWith;

class PlanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ruleInIntervalTypes = Rule::in(PlansIntervalType::all());
        $ruleInPayableWith = Rule::in(PlansPayableWith::all());

        return [
            'name' => 'string|required|min:6|max:250',
            'description' => 'string|required|min:6|max:250',
            'type' => ['required'],
            'price' => 'required|numeric',
            'interval' => 'nullable|numeric',
            'interval_type' => ['nullable', 'string', $ruleInIntervalTypes],
            'payable_with' => ['nullable', 'string', $ruleInPayableWith],
            'start_on' => ['nullable', 'date'],

            'service_tables' => 'nullable|array',
            'service_tables.*.service_table_id' => ['nullable', Rule::exists('service_tables', 'id')],
            'service_tables.*.quantity' => 'nullable|numeric',

            'os_base' => 'nullable|array',
            'os_base.*.os_base_id' => ['nullable', Rule::exists('os_base', 'id')],
            'os_base.*.quantity' => 'nullable|numeric',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
