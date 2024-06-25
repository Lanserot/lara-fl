<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Infrastructure\Interfaces\IFileStorageRepository;
use Infrastructure\Interfaces\Order\IOrderRepository;
use Infrastructure\Interfaces\User\IUserMapper;
use Infrastructure\Interfaces\User\IUserRepository;
use Infrastructure\Mapper\User\UserMapper;
use Infrastructure\Repositories\FileStorageRepository;
use Infrastructure\Repositories\OrderRepository;
use Infrastructure\Repositories\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IUserMapper::class, UserMapper::class);
        $this->app->bind(IOrderRepository::class, OrderRepository::class);
        $this->app->bind(IFileStorageRepository::class, FileStorageRepository::class);
    }

    public function boot(): void
    {
    }
}
