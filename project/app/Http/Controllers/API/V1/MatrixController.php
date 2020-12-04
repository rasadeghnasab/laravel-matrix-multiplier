<?php

namespace App\Http\Controllers\API\V1;

use App\Classes\Matrix;
use App\Classes\MatrixOperators\MatrixMultiplier;
use App\Http\Controllers\Controller;
use App\Http\Requests\MatrixMultiplicationRequest;
use App\Transformers\MatrixCharTransformer;

class MatrixController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param MatrixMultiplicationRequest $request
     * @param MatrixMultiplier $matrixMultiplier
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\InvalidMatrixException
     */
    public function multiply(MatrixMultiplicationRequest $request, MatrixMultiplier $matrixMultiplier)
    {
        $first_matrix = app()->make(Matrix::class, $request->get('first_matrix'));
        $second_matrix = app()->make(Matrix::class, $request->get('second_matrix'));

        $result_matrix = $matrixMultiplier->calculate($first_matrix, $second_matrix);

        $char_matrix = MatrixCharTransformer::transform($result_matrix);

        return response()->json(
            [
                'data' => $char_matrix
            ]
        );
    }
}
