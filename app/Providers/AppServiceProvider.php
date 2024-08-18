<?php

namespace App\Providers;

use App\Interfaces\IPhonebookRepository;
use App\Interfaces\IPhonebookService;
use App\Repositories\PhonebookRepository;
use App\Services\PhonebookService;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
