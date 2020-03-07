<?php

return [
    /*
   |--------------------------------------------------------------------------
   | Maps routes name to validators
   |--------------------------------------------------------------------------
   |
   | Maps a route name with a validator class
   |
   */

    /*
     * ---------------------
     * Passwords
     * -----------------
     */
    \App\Http\RoutesInfo\V1\PasswordInfo::Update =>
        \App\Http\Requests\V1\Validation\UpdatePasswordRules::class,
    \App\Http\RoutesInfo\V1\PasswordInfo::Store =>
        \App\Http\Requests\V1\Validation\StorePasswordRules::class,
];
