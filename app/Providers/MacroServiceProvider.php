<?php

namespace App\Providers;

use App\Core\Extensions\HttpResponseMacros;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    private array $extensions = [
        HttpResponseMacros::class,
    ];


    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        foreach ($this->extensions as $extension) {
            Response::mixin(app($extension));
        }

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {

    }
}
