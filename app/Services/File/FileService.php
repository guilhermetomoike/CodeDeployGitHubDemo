<?php

namespace App\Services\File;

use App\Models\Upload;
use App\Modules\ConvertBase64ToFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    private $storage;

    public function __construct()
    {
        $this->storage = Storage::disk('s3');
    }

    public function getPendingUploadFiles(string $label)
    {
        return Upload::query()
            ->where('label', $label)
            ->where('there_is_error', false)
            ->get();
    }

    public function getUploadFilesWithError(string $label)
    {
        return Upload::query()
            ->where('label', $label)
            ->where('there_is_error', true)
            ->get();
    }

    public function uploadFile(array $file, string $label)
    {
        $pdf = ConvertBase64ToFile::run($file['base64']);
        $path = Str::random(40) . '.pdf';

        $this->storage->put($path, $pdf);

        return Upload::updateOrCreate([
            'label' => $label,
            'name' => $file['name'],
            'data_competencia' => $file['competencia'],
        ], [
            'path' => $path,
        ]);
    }

    public function errorOnUpload(Upload $upload, string $errorMessage)
    {
        $upload->update([
            'there_is_error' => true,
            'error_message' => $errorMessage,
        ]);
    }

    public function deleteUploadFileWithError(int $id)
    {
        $file = Upload::find($id);

        $this->storage->delete($file->path);
        $file->delete();
    }
}
