<?php


namespace App\Models\Notification;


class NotificationPlantaoParams implements NotificationParamsInterface
{
    private $title;
    private $body;
    private $sound = 'default';
    private $data;
    private $token;

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setSound($sound) {
        $this->$sound = $sound;
    }

    public function getSound()
    {
        return $this->sound;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setToken($token) {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }
}
