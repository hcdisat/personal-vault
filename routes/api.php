<?php

use App\Http\RoutesInfo\V1\PasswordInfo;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->namespace('V1')
    ->group(static function () {
        Route::prefix('auth')
            ->group(static function (Router $r) {
                $r->post('login', 'AuthController@login');
                $r->post('register', 'AuthController@register');
                $r->post('refresh', 'AuthController@refresh');
                $r->get('error', 'AuthController@showError')->name('api-error');
            });

        Route::prefix('passwords')
            ->middleware(['api.auth']) 
            ->group(static function (Router $r) {
                $r->get('', 'PasswordsController@index');
                $r->get('{password}', 'PasswordsController@show');
                $r->delete('{password}', 'PasswordsController@destroy');

                $r->get('self', 'PasswordsController@self')
                    ->name(PasswordInfo::Self);

                Route::middleware('api.validator')
                    ->group(static function (Router $r) {
                        $r->post('', 'PasswordsController@store')
                            ->name(PasswordInfo::Store);

                        $r->put('{password}', 'PasswordsController@update')
                            ->name(PasswordInfo::Update);
                    });
            });
    });

