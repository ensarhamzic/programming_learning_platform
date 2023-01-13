<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('validPhone', function ($attribute, $value) {
            return substr($value, 0, 1) === "+";
        });

        Validator::replacer('validPhone', function ($message, $attribute, $rule, $parameters) {
            return 'The :attribute is not valid.';
        });
    }
}
