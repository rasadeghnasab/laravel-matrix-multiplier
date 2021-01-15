<?php

namespace App\Providers;

use App\Classes\Matrix;
use Illuminate\Support\ServiceProvider;

class MatrixServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindOperators();

        $this->app->bind(
            Matrix::class,
            function ($app, $data) {
                $matrix_class = config('matrix.matrix_class');
                $validator = config('matrix.validator');

                return new $matrix_class(new $validator($data));
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function bindOperators(): void
    {
        $operators = config('matrix.operators');

        foreach ($operators as $operator) {
            $validator = config('matrix.validator');
            $matrix_class = config('matrix.matrix_class');
            $matrix = new $matrix_class(new $validator([[]]));

            $this->app->bind($operator, fn() => new $operator($matrix));
        }
    }
}
