<?php

namespace App\Exceptions;

use Exception;

class InvalidMatrixException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     */
    public function render()
    {
        return response()
            ->json([
                'errors' => [
                    'Your matrix value is invalid.'
                ],
            ])
            ->setStatusCode(422);
    }
}
