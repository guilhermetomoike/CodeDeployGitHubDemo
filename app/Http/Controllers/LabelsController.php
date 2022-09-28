<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelsRequest;
use App\Http\Resources\LabelsResource;
use App\Models\Label;
use App\Services\LabelsService;

class LabelsController extends Controller
{
    private LabelsService $labelsService;

    public function __construct(LabelsService $labelsService)
    {
        $this->labelsService = $labelsService;
    }

    public function store(LabelsRequest $request)
    {
        $data = $request->validated();
        $label = $this->labelsService->storeLabel($data);
        return new LabelsResource($label);
    }

    public function show(Label $label)
    {
        return new LabelsResource($label);
    }

    public function update(LabelsRequest $request, Label $label)
    {
        $data = $request->validated();
        $this->labelsService->updateLabel($data, $label);
        return new LabelsResource($label);
    }
}
