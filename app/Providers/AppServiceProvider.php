<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Infrastructure\Interfaces\User\IUserRepository;
use Infrastructure\Repositories\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
    }

    public function boot(): void
    {
    }
}
