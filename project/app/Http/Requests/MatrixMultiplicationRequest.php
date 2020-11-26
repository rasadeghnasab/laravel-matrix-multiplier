<?php

namespace App\Http\Requests;

use App\Rules\MatrixNumeric;
use Illuminate\Foundation\Http\FormRequest;

class MatrixMultiplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstMatrix' => ['is_valid_matrix', 'numeric_matrix'],
            'secondMatrix' => ['is_valid_matrix', 'numeric_matrix'],
        ];
    }
}
