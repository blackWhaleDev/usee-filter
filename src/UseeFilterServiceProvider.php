<?php

namespace youness_usee\filter;

use youness_usee\filter\Console\Commands\MakeFilter;
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
                MakeFilter::class
            ]);
        }
    }
}