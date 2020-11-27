<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class ImpossibleMatrixMultiplyException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     * @param Request $request
     * @param ImpossibleMatrixMultiplyException $exception
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function render(Request $request, self $exception)
    {
        return response()
            ->json(
                [
                    'errors' => [
                        $exception->getMessage(),
                    ],
                ]
            )
            ->setStatusCode(422);
    }
}
