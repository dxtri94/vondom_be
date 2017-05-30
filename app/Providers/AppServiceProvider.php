<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // greater than
        Validator::extend('greater_than', function ($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            return $value >= $data[$parameters[0]];
        });

        Validator::extend('phone', function ($attribute, $value, $paramters, $validator) {

        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
