<?php

namespace Larastash\Options\Providers;

use Illuminate\Support\ServiceProvider;
use Larastash\Options\Option;
use Larastash\Options\Models\Model;

class OptionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        }
    }

    public function register()
    {
        $this->app->singleton(Model::class, Model::class);
        $this->app->singleton(Option::class, Option::class);
        $this->app->singleton('option', Option::class);
    }
}