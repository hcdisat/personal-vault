<?php

namespace App\Providers;

use App\Core\Repositories\DbPasswordRepository;
use App\Core\Repositories\PasswordRepositoryContract;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function register(): void
    {
        foreach ($this->mapRepositories() as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }

        $reflector = new \ReflectionClass($this);
        $privateMethods = $reflector
            ->getMethods(\ReflectionMethod::IS_PRIVATE);

        foreach ($privateMethods as $method) {
            $this->{$method->name}();
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

    /**
     * @return array|string[]
     */
    protected function mapRepositories(): array
    {
        return [
            PasswordRepositoryContract::class => DbPasswordRepository::class,
        ];
    }
}
