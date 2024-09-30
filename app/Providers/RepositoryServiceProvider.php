<?php

namespace App\Providers;

use App\Interfaces\Repositories\AdminRepositoryInterface;
use App\Interfaces\Repositories\CashierRepositoryInterface;
use App\Interfaces\Repositories\StoreRepositoryInterface;
use App\Interfaces\Repositories\SuperadminRepositoryInterface;
use App\Interfaces\Services\AdminServiceInterface;
use App\Interfaces\Services\AuthServiceInterface;
use App\Interfaces\Services\CashierServiceInterface;
use App\Interfaces\Services\StoreServiceInterface;
use App\Repositories\AdminRepository;
use App\Repositories\CashierRepository;
use App\Repositories\StoreRepository;
use App\Repositories\SuperadminRepository;
use App\Services\AdminService;
use App\Services\AuthService;
use App\Services\CashierService;
use App\Services\StoreService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //Repositories
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(StoreRepositoryInterface::class, StoreRepository::class);
        $this->app->bind(CashierRepositoryInterface::class, CashierRepository::class);
        $this->app->bind(SuperadminRepositoryInterface::class, SuperadminRepository::class);

        //Services
        $this->app->bind(AdminServiceInterface::class, AdminService::class);
        $this->app->bind(StoreServiceInterface::class, StoreService::class);
        $this->app->bind(CashierServiceInterface::class, CashierService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
