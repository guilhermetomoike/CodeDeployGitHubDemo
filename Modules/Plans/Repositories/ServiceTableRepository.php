<?php


namespace Modules\Plans\Repositories;


use Modules\Plans\Entities\ServiceTable;

class ServiceTableRepository
{
    public function all()
    {
        return ServiceTable::all();
    }

    public function create(array $data)
    {
        return ServiceTable::query()->create($data);
    }

    public function findById($id)
    {
        return ServiceTable::query()->find($id);
    }

    public function delete($id)
    {
        return ServiceTable::destroy($id);
    }

    public function update($id, array $data)
    {
        return $this->findById($id)->update($data);
    }
}
