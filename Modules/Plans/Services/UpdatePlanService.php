<?php


namespace Modules\Plans\Services;


use Modules\Plans\Entities\Plan;

class UpdatePlanService implements Contracts\UpdatePlanService
{

    public function execute(int $id, array $data)
    {
        $plan = Plan::query()->find($id)->update($data);
        /** @var Plan $plan */
        $plan->service_order()->sync($this->qualifyFoSync($data['os_base'], 'os_base_id'));
        $plan->service_table()->sync($this->qualifyFoSync($data['service_tables'], 'service_table_id'));
        return $plan;
    }

    private function qualifyFoSync($os_base, string $index): array
    {
        $os_array = [];
        foreach ($os_base as $item) {
            $os_array[$item[$index]] = $item;
        }
        return $os_array;
    }
}
