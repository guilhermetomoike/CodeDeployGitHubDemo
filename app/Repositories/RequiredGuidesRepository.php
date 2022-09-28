<?php


namespace App\Repositories;


use App\Models\Empresa;
use App\Models\Empresa\RequiredGuide;

class RequiredGuidesRepository
{
    public function getAllRequiredGuides()
    {
        return RequiredGuide::query()->where('active', true)->get();
    }
}
