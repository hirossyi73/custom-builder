<?php

namespace CustomBuilder;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection;

class CustomBuilderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Connection::resolverFor('mysql', function (...$parameters) {
            return new Database\MySqlConnection(...$parameters);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
