<?php


namespace App\Services;


use App\Models\Cliente;
use App\Models\Upload;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\InputBag;

class UploadService
{
    public function getById(int $id)
    {
        return Upload::find($id);
    }

    public function getByType(string $type, InputBag $query)
    {
        return Upload::query()
            ->where('label', $type)
            ->when($query->get('customer_id'), function ($query, $customer_id) {
                $query->where('causer_type', 'cliente');
                $query->where('causer_id', $customer_id);
            })
            ->when($query->get('withCauser'), function ($query, $withCauser) {
                $query->with('causer');
            })
            ->get();
    }

    public function create(array $data)
    {
        $files = [];
        foreach ($data['files'] as $item) {
            $path = Storage::disk('s3')->put(null, $item);
            $files[] = Upload::query()->create([
                'label' => $data['label'],
                'name' => $item->getClientOriginalName(),
                'path' => $path,
            ]);
        }
        return $files;
    }

    public function delete($id)
    {
        return Upload::find($id)->delete();
    }
}
