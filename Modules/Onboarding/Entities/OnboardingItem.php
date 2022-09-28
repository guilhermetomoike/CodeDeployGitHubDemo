<?php

namespace Modules\Onboarding\Entities;

use Illuminate\Database\Eloquent\Model;

class OnboardingItem extends Model
{
    protected $fillable = ['nome', 'onboarding_id'];

    public function onboarding()
    {
        return $this->belongsTo(Onboarding::class);
    }
}
