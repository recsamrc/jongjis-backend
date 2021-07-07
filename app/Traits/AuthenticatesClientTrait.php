<?php

namespace App\Traits;

trait AuthenticatesClientTrait
{
    public function guard()
    {
        return auth()->guard('api');
    }

    public function user()
    {
        return $this->guard()->user();
    }
}
