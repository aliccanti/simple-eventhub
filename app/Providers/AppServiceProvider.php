<?php

namespace App\Providers;

use App\Repositories\EventRepository;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Repositories\Interfaces\PurchaseRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\PurchaseRepository;
use App\Repositories\UserRepository;
use App\Services\AuthorizerService;
use App\Services\Interfaces\AuthorizerServiceInterface;
use App\Services\Interfaces\NotificationServiceInterface;
use App\Services\NotificationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(PurchaseRepositoryInterface::class, PurchaseRepository::class);
        $this->app->bind(AuthorizerServiceInterface::class, AuthorizerService::class);
        $this->app->bind(NotificationServiceInterface::class, NotificationService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
