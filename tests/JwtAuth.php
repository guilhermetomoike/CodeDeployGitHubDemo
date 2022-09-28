<?php


namespace Tests;


use Illuminate\Contracts\Auth\Authenticatable;

trait JwtAuth
{
    public function actingAs(Authenticatable $user, $driver = null)
    {
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);
        $this->withHeader('Authorization', 'Bearer ' . $token);

        return $this;
    }
}
