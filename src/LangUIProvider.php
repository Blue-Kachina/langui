<?php

namespace bluekachina\langui;

use Illuminate\Support\ServiceProvider;

class LangUIProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->make('bluekachina\langui\langui.php');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->loadRoutesFrom(__DIR__.'/routes.php');
//        $this->loadMigrationsFrom(__DIR__.'/migrations');
//        $this->loadViewsFrom(__DIR__.'/views', 'langui');
//        $this->publishes([
//            __DIR__.'/views' => base_path('resources/views/bluekachina/langui'),
//        ]);
    }
}
