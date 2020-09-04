<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Repositories\ContactsRepositoryInterface;
use App\Repositories\ContactsRepository;
use App\Interfaces\Repositories\OrdersRepositoryInterface;
use App\Repositories\OrdersRepository;
use App\Interfaces\Repositories\UsersRepositoryInterface;
use App\Repositories\UsersRepository;
use App\Interfaces\Repositories\ExpensesRepositoryInterface;
use App\Repositories\ExpensesRepository;
use App\Interfaces\Repositories\ProductsRepositoryInterface;
use App\Repositories\ProductsRepository;
use App\Interfaces\Repositories\TransactionsRepositoryInterface;
use App\Repositories\TransactionsRepository;

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
        $this->app->bind(TransactionsRepositoryInterface::class, TransactionsRepository::class);
        $this->app->bind(OrdersRepositoryInterface::class, OrdersRepository::class);
        $this->app->bind(UsersRepositoryInterface::class, UsersRepository::class);
        $this->app->bind(ExpensesRepositoryInterface::class, ExpensesRepository::class);
        $this->app->bind(ProductsRepositoryInterface::class, ProductsRepository::class);
    }
}
