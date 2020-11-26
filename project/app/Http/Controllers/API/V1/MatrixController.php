<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MatrixMultiplicationRequest;

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
        return response()->json([
            'result' => 'success',
            'data' => [['KS', 'GJ']]
        ]);
    }
}
