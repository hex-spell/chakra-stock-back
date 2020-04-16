<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ContactsRepositoryInterface;
use App\Repositories\ContactsRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ContactsRepositoryInterface::class, ContactsRepository::class);
    }
}
