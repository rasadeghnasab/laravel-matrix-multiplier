<?php

use App\Classes\{Matrix, MatrixOperators\MatrixMultiplier, ValidMatrix};

return [
    'operators' => [
        MatrixMultiplier::class
    ],
    'validator' => ValidMatrix::class,
    'matrix_class' => Matrix::class
];
