<?php

namespace App\Providers;

use App\Interfaces\Repositories\AdminRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Repositories\AdminRepository;
use App\Repositories\UserRepository;
use App\Services\AdminService;
use App\Services\UserService;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserService::class, function (Application $app) {
            return new UserService($app->make(UserRepositoryInterface::class));
        });

        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(AdminService::class, function (Application $app) {
            return new AdminService($app->make(AdminRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
