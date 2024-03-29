<?php

namespace App\Providers;

use App\Services\Impl\TodolistServiceImpl;
use App\Services\TodolistService;
use Illuminate\Support\ServiceProvider;

class TodolistServiceProvider extends ServiceProvider
{

    public array $singletons = [
        TodolistService::class => TodolistServiceImpl::class
    ];

    public function provides()
    {
        return [TodolistService::class];
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
