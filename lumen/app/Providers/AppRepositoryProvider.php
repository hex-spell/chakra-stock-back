<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ContactsRepositoryInterface;
use App\Repositories\ContactsRepository;
use App\Interfaces\OrdersRepositoryInterface;
use App\Repositories\OrdersRepository;

class AppRepositoryProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ContactsRepositoryInterface::class, ContactsRepository::class);
        $this->app->bind(OrdersRepositoryInterface::class, OrdersRepository::class);
    }
}
