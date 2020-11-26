<?php

namespace App\Providers;

use App\Rules\CanMultiplyTo;
use App\Rules\IsValidMatrix;
use App\Rules\MatrixNumeric;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('is_valid_matrix', sprintf('%s@passes', IsValidMatrix::class));
        Validator::extend('can_multiply_to', sprintf('%s@passes', CanMultiplyTo::class));
        Validator::extend('numeric_matrix', sprintf('%s@passes', MatrixNumeric::class));
    }
}
