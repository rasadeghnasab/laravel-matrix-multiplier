<?php declare(strict_types=1);

namespace App\Providers;

use App\Rules\{CanMultiplyTo, IsValidMatrix, MatrixNumeric};
use Illuminate\Support\{Facades\Validator, ServiceProvider};

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
        Validator::extend('numeric_matrix', sprintf('%s@passes', MatrixNumeric::class));
        Validator::extend('can_multiply_to', CanMultiplyTo::class);
    }
}
