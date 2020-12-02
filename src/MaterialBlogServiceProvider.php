<?php

namespace Octo\MaterialBlog;

use Illuminate\Support\ServiceProvider;

class MaterialBlogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/public/assets' => public_path('vendor/octo/themes/material-blog/assets'),
        ], 'material/assets');

        $this->loadViewsFrom(__DIR__.'/resources/views', 'material-blog');
    }

    public function register()
    {

    }
}
