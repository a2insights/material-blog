<?php

namespace Atiladanvi\MaterialHasblog;

use Illuminate\Support\ServiceProvider;

/**
 * Class MaterialHasblogServiceProvider
 *
 * @package Atiladanvi\MaterialHasblog
 */
class MaterialHasblogServiceProvider extends ServiceProvider
{
    /**
     * Boot the resources path
     * @void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/public/assets' => public_path('vendor/material/assets'),
        ], 'clean/assets');

        $this->loadViewsFrom(__DIR__.'/resources/views', 'material');
    }

    /**
     * Register resources
     * @void
     */
    public function register()
    {

    }
}
