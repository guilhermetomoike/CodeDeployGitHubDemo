<?php

namespace Modules\Onboarding\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Onboarding\Entities\Onboarding;
use Modules\Onboarding\Entities\OnboardingItem;

class OnboardingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Onboarding::class, 3)->create();

        Onboarding::all()->each(function ($onboarding) {
            $onboarding->items()->createMany(factory(OnboardingItem::class, 8)->make()->toArray());
        });
    }
}
