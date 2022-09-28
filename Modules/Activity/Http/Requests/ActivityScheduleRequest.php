<?php

namespace Modules\Activity\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Activity\Entities\ActivitySchedule;

class ActivityScheduleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'description'     => ['required', 'max:255'],
            'goal'            => ['required', 'date'],
            'deadline'        => ['required', 'date'],
            'observation'     => ['required', 'max:255'],
            'status'          => ['required', 'in:todas,' . implode(',', ActivitySchedule::STATUSES)],
            'recurrence'      => ['required', 'in:' . implode(',', ActivitySchedule::RECURRENCES)],

            'wallter_id'      => ['nullable', 'array'],
            'wallter_id.*.id' => ['nullable', 'exists:carteiras,id'],

            'tax_regime'      => ['required', 'string', 'in:' . implode(',', ActivitySchedule::REGIMES)],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
