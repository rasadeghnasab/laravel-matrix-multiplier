<?php

namespace App\Http\Controllers\API\V1;

use App\Classes\Matrix;
use App\Classes\MatrixOperators\MatrixMultiplier;
use App\Classes\ValidMatrix;
use App\Http\Controllers\Controller;
use App\Http\Requests\MatrixMultiplicationRequest;
use App\Transformers\MatrixCharTransformer;

class MatrixController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param MatrixMultiplicationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function multiply(MatrixMultiplicationRequest $request)
    {
        $first_matrix = new Matrix(new ValidMatrix($request->get('first_matrix')));
        $second_matrix = new Matrix(new ValidMatrix($request->get('second_matrix')));

        $result_matrix = (new MatrixMultiplier(Matrix::class))->calculate($first_matrix, $second_matrix);

        $char_matrix = MatrixCharTransformer::transform($result_matrix);

        return response()->json([
            'data' => $char_matrix
        ]);
    }
}
