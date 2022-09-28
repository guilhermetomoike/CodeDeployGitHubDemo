<?php


namespace App\Services\Aplicativo;


use App\Channels\PushFcm\PushNotificationMessage;

class PushNotificationService
{
    private $androidServerKey;
    private $iosKey;
    private $device_id;
    private $data;
    private $fields;
    private $headers;
    private $url;
    private $ch;

    public function __construct()
    {
        $this->url = config('services.fcm.server_url');
        $this->androidServerKey = config('services.fcm.server_key');
    }

    public function setDeviceId(string $device_id): PushNotificationService
    {
        $this->device_id = $device_id;
        return $this;
    }

    public function setNotification(PushNotificationMessage $notification): PushNotificationService
    {
        $this->data = $notification->toArray();
        return $this;
    }

    public function sendPushNotification()
    {
        $this->buildHeaders();
        $this->buildFields();

        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $this->url);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($this->fields));
        $result = curl_exec($this->ch);
        curl_close($this->ch);
        return json_decode($result, true);
    }

    private function buildHeaders()
    {
        $this->headers = [
            'Authorization: key=' . $this->androidServerKey,
            'Content-Type: application/json'
        ];
    }

    private function buildFields(): void
    {
        $this->fields = [
            'to' => $this->device_id,
            'notification' => $this->data
        ];
    }
}
