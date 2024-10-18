<?php

namespace App\Providers;

use App\Interfaces\Repositories\AdminRepositoryInterface;
use App\Interfaces\Repositories\CartRepositoryInterface;
use App\Interfaces\Repositories\CashierRepositoryInterface;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Repositories\OrderDetailRepositoryInterface;
use App\Interfaces\Repositories\OrderRepositoryInterface;
use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Interfaces\Repositories\RunningBillRepositoryInterface;
use App\Interfaces\Repositories\SpatieRepositoryInterface;
use App\Interfaces\Repositories\StoreRepositoryInterface;
use App\Interfaces\Repositories\SuperadminRepositoryInterface;
use App\Interfaces\Repositories\TableRepositoryInterface;
use App\Interfaces\Services\AdminServiceInterface;
use App\Interfaces\Services\AuthServiceInterface;
use App\Interfaces\Services\CartServiceInterface;
use App\Interfaces\Services\CashierServiceInterface;
use App\Interfaces\Services\CategoryServiceInterface;
use App\Interfaces\Services\OrderServiceInterface;
use App\Interfaces\Services\ProductServiceInterface;
use App\Interfaces\Services\RunningBillServiceInterface;
use App\Interfaces\Services\StoreServiceInterface;
use App\Repositories\AdminRepository;
use App\Repositories\CartRepository;
use App\Repositories\CashierRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderDetailRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\RunningBillRepository;
use App\Repositories\SpatieRepository;
use App\Repositories\StoreRepository;
use App\Repositories\SuperadminRepository;
use App\Repositories\TableRepository;
use App\Services\AdminService;
use App\Services\AuthService;
use App\Services\CartService;
use App\Services\CashierService;
use App\Services\CategoryService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\RunningBillService;
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
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(SpatieRepositoryInterface::class, SpatieRepository::class);
        $this->app->bind(TableRepositoryInterface::class, TableRepository::class);
        $this->app->bind(RunningBillRepositoryInterface::class, RunningBillRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderDetailRepositoryInterface::class, OrderDetailRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);

        //Services
        $this->app->bind(AdminServiceInterface::class, AdminService::class);
        $this->app->bind(StoreServiceInterface::class, StoreService::class);
        $this->app->bind(CashierServiceInterface::class, CashierService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(RunningBillServiceInterface::class, RunningBillService::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        $this->app->bind(CartServiceInterface::class, CartService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
