<?php

namespace App\Providers;

use App\Interfaces\IPhonebookRepository;
use App\Interfaces\IPhonebookService;
use App\Interfaces\IUserRepository;
use App\Interfaces\IUserService;
use App\Repositories\PhonebookRepository;
use App\Repositories\UserRepository;
use App\Services\PhonebookService;
use App\Services\UserService;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IPhonebookService::class, PhonebookService::class);
        $this->app->bind(IPhonebookRepository::class, PhonebookRepository::class);
        $this->app->bind(IUserService::class, UserService::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
