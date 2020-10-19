<?php

namespace usee\filter;

use Illuminate\Support\ServiceProvider;

class UseeFilterServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                UseeFilterServiceProvider::class,
            ]);
        }
    }
}