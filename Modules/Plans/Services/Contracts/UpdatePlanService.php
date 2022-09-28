<?php


namespace Modules\Plans\Services\Contracts;


interface UpdatePlanService
{
    public function execute(int $id, array $data);
}
