<?php

namespace App\Providers;

use App\Interfaces\Services\ContactsServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Services\OrdersServiceInterface;
use App\Services\ContactsService;
use App\Services\OrdersService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ContactsServiceInterface::class, ContactsService::class);
        $this->app->bind(OrdersServiceInterface::class, OrdersService::class);
    }
}
