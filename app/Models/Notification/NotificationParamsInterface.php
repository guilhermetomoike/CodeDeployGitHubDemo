<?php


namespace App\Models\Notification;


interface NotificationParamsInterface
{
    public function setTitle($title);
    public function getTitle();

    public function setBody($body);
    public function getBody();
}
