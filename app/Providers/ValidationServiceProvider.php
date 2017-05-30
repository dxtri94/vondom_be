<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Common\CustomValidation;
use Illuminate\Validation;

class ValidationServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->app['validator']->resolver(function ($translator, $data, $rules, $messages) {
            return new CustomValidation($translator, $data, $rules, $messages);
        });
    }
}