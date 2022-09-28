<?php


namespace Modules\Plans\Repositories;


use Modules\Plans\Entities\Plan;

class PlansRepository
{
    public function all()
    {
        return Plan::all();
    }

    public function geyById(int $id)
    {
        return Plan::query()->find($id);
    }

    public function delete($id)
    {
        return Plan::destroy($id);
    }
}
