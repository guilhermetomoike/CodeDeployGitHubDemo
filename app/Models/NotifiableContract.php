<?php


namespace App\Models;


interface NotifiableContract
{
    public function routeNotificationForWhatsApp();

    public function routeNotificationForMail();

    public function contatos();
}
