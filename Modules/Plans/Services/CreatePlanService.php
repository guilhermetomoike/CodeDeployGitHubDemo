<?php


namespace Modules\Plans\Services;


use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Plans\Entities\Plan;

class CreatePlanService implements Contracts\CreatePlanService
{
    public function execute(array $data)
    {
        try {
            DB::beginTransaction();
            $plan = Plan::query()->create($data);
            /** @var Plan $plan */
            if (isset($data['os_base']) && !empty($data['os_base'])) {
                $plan->service_order()->sync($this->qualifyFoSync($data['os_base'], 'os_base_id'));
            }
            if (isset($data['service_tables']) && !empty($data['service_tables'])) {
                $plan->service_table()->sync($this->qualifyFoSync($data['service_tables'], 'service_table_id'));
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Erro ao salvar o plano. - ' . $e->getMessage());
        }

        return $plan;
    }

    private function qualifyFoSync($items, string $index): array
    {
        $item_sync_arra = [];
        foreach ($items as $item) {
            $item_sync_arra[$item[$index]] = $item;
        }
        return $item_sync_arra;
    }
}
