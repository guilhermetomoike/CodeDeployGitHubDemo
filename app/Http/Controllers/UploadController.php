<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReceivedHoleritesResource;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UploadController
{
    private UploadService $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => ['string', 'required'],
            'files' => ['array', 'min:1'],
        ]);
        $files = $this->uploadService->create($data);
        return new JsonResponse($files);
    }

    public function show($id)
    {
        $upload = $this->uploadService->getById($id);
        return new JsonResponse($upload);
    }

    public function destroy($id)
    {
        $this->uploadService->delete($id);
        return new JsonResponse(null, 204);
    }

    public function getByType(Request $request, $type)
    {
        $uploads = $this->uploadService->getByType($type, $request->query);
        return ReceivedHoleritesResource::collection($uploads);
    }
}
