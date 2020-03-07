<?php

use App\Http\RoutesInfo\V1\PasswordInfo;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

/** @var Factory $factory */
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Models\Password::class, static function (Faker $faker) {
    return [
        PasswordInfo::Name => $faker->name,
        PasswordInfo::Value => $faker->password, // password
        PasswordInfo::UserId => User::first()->id,
        PasswordInfo::Username => $faker->email,
        PasswordInfo::Website => str_replace(' ', '', $faker->sentence(3)).'com',
        PasswordInfo::Note => $faker->text(60)
    ];
});
