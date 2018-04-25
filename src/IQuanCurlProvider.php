<?php

namespace IQuanCurl;

use Illuminate\Support\ServiceProvider;

class IQuanCurlProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('iquancurl', function ($app) {
            return new IQuanCurl($app);
        });
    }

    public function provides()
    {
        return ['iquancurl'];
    }
}
