<?php

namespace Modules\Activity\Http\Controllers;

use App\Models\Carteira;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Activity\Entities\ActivitySchedule;
use Modules\Activity\Http\Requests\ActivityScheduleRequest;
use Modules\Activity\Services\ActivityScheduleService;

class ActivityScheduleController extends Controller
{
    /** @var ActivityScheduleService $service */
    private $service;

    public function __construct()
    {
        $this->service = new ActivityScheduleService();
    }

    public function index(Request $request)
    {
        return response()->json(ActivitySchedule::all());
    }

    public function store(ActivityScheduleRequest $request)
    {
        $activitySchedule = $this->service->create($request->validated());

        return response()->json(['data' => $activitySchedule], 201);
    }

    public function show($id)
    {
        $activitySchedule = ActivitySchedule::findOrFail($id);

        return response()->json(['data' => $activitySchedule], 200);
    }

    public function update(ActivityScheduleRequest $request, $id)
    {
        $activitySchedule = ActivitySchedule::findOrFail($id);
        $activitySchedule = $this->service->update($activitySchedule, $request->validated());

        return response()->json(['data' => $activitySchedule], 200);
    }

    public function destroy($id)
    {
        $activitySchedule = ActivitySchedule::findOrFail($id);
        $this->service->delete($activitySchedule);

        return response()->json([], 200);
    }

    public function recurrence()
    {
        $recurrence = [
            [
                'label' => 'Única',
                'value' => ActivitySchedule::RECURRENCE_ONLY,
            ],
            [
                'label' => 'Semanal',
                'value' => ActivitySchedule::RECURRENCE_WEEKLY,
            ],
            [
                'label' => 'Mensal',
                'value' => ActivitySchedule::RECURRENCE_MONTHLY,
            ],
            [
                'label' => 'Semesttral',
                'value' => ActivitySchedule::RECURRENCE_SEMIANNUAL,
            ],
            [
                'label' => 'Anual',
                'value' => ActivitySchedule::RECURRENCE_YEARLY,
            ],
        ];

        return response()->json(['data' => $recurrence], 200);
    }

    public function status()
    {
        return response()->json(['data' => ActivitySchedule::STATUSES], 200);
    }

    public function regimes()
    {
        return response()->json([ 'data' => ActivitySchedule::REGIMES], 200);
    }

    public function wallters()
    {
        $carteiras = Carteira::query()->select(['id', 'nome'])->get();

        return response()->json(['data' => $carteiras], 200);
    }

    public function executeActivitySchedule($id)
    {
        /** @var ActivitySchedule|null $activitySchedule */
        $activitySchedule = ActivitySchedule::find($id);

        if (!$activitySchedule) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    "id" =>  'O id é inválido',
                ],
            ]);
        }

        $activitySchedule->execute();
        return response()->json([], 200);
    }
}
