<?php

use App\Http\Controllers\API\V1\MatrixController;
use Illuminate\Support\Facades\Route;

Route::prefix('matrix')->group(
    function () {
        Route::post('multiply', [MatrixController::class, 'multiply']);
    }
);
