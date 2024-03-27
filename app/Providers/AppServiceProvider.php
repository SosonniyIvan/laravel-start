<?php

namespace App\Providers;

use App\Repositories\Contract\ImageRepositoryInterface;
use App\Repositories\Contract\ProductsRepositoryInterface;
use App\Repositories\ImageRepository;
use App\Repositories\ProductRepository;
use App\Services\Interface\FileStorageServiceInterface;
use App\Services\Interface\OrderRepositoryInterface;
use App\Services\Interface\PaypalServiceInterface;
use App\Services\FileStorageService;
use App\Services\OrderRepository;
use App\Services\PaypalService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public array $bindings = [
        FileStorageServiceInterface::class => FileStorageService::class,
        ProductsRepositoryInterface::class => ProductRepository::class,
        ImageRepositoryInterface::class => ImageRepository::class,
        PaypalServiceInterface::class => PaypalService::class,
        OrderRepositoryInterface::class => OrderRepository::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
