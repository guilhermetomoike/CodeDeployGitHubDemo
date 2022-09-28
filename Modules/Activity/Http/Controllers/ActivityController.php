<?php

namespace Modules\Activity\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Activity\Entities\Activity;
use Modules\Activity\Http\Requests\ActivityRequest;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $activities = Activity
            ::with('empresa.carteiras')
            ->orderBy('executed')
            ->get();

        return response()->json($activities, 200);
    }

    public function show($id)
    {
        return response()->json(['data' => Activity::findOrFail($id)], 200);
    }

    public function update(ActivityRequest $request, $id)
    {
        $data = $request->validated();
        $activity = Activity::findOrFail($id);

        $activity->update($data);
        $activity->save();

        return response()->json(['data' => $activity], 200);
    }

    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return response()->json([], 200);
    }
}
