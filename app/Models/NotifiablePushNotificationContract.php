<?php


namespace App\Models;


interface NotifiablePushNotificationContract
{
    public function routeNotificationForFcm();
}
