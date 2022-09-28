<?php

namespace App\Services;

use App\Models\AppSettings;
use Illuminate\Database\Eloquent\Model;

class AppSettingsService
{
    public function createOrUpdatedAccess($person_type, $person_id, string $updateType = 'contact', string $originCall = 'login'): ?Model
    {
        $today = now();
        $appSettings = AppSettings::person($person_type, $person_id)->first();

        $data = [
            'person_type' => $person_type,
            'person_id' => $person_id,
            'last_access' => $today,
            'updated_contact' => ($originCall === 'login' ? ($appSettings->updated_contact ?? null) :
                ($updateType === 'contact' ? $today : ($appSettings->updated_contact ?? null))),
            'updated_course' => ($originCall === 'login' ? ($appSettings->updated_course ?? null) :
                ($updateType === 'course' ? $today : ($appSettings->updated_course ?? null))),
        ];

        if ($appSettings) {
            return $this->update($appSettings->id, $data);
        }
        return $this->create($data);
    }

    public function create(array $data): Model
    {
        $appSettings = new AppSettings();
        $appSettings->last_access = $data['last_access'];
        $appSettings->updated_contact = array_key_exists('updated_contact', $data) ? $data['updated_contact'] : null;
        $appSettings->updated_course = array_key_exists('updated_course', $data) ? $data['updated_course'] : null;
        $appSettings->person_type = $data['person_type'];
        $appSettings->person_id = $data['person_id'];
        $appSettings->save();

        return $appSettings;
    }

    public function update(int $id, array $data): ?Model
    {
        $appSettings = AppSettings::find($id);

        if (!$appSettings) {
            return null;
        }

        return $this->edit($appSettings, $data);
    }

    private function edit(Model $appSettings, array $data): Model
    {
        $appSettings->last_access = $data['last_access'];
        $appSettings->updated_contact = $data['updated_contact'];
        $appSettings->updated_course = $data['updated_course'];
        $appSettings->person_type = $data['person_type'];
        $appSettings->person_id = $data['person_id'];
        $appSettings->save();

        return $appSettings;
    }
}
