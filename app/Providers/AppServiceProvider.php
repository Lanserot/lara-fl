<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Infrastructure\Interfaces\IUserMapper;
use Infrastructure\Interfaces\User\IUserRepository;
use Infrastructure\Mapper\User\UserMapper;
use Infrastructure\Repositories\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IUserMapper::class, UserMapper::class);
    }

    public function boot(): void
    {
    }
}
