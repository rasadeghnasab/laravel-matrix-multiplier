<?php

namespace App\Http\Requests;

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
            'first_matrix' => [
                'required',
                'array',
                'is_valid_matrix',
                'numeric_matrix',
                'can_multiply_to:second_matrix'
            ],
            'second_matrix' => ['required', 'array', 'is_valid_matrix', 'numeric_matrix'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_matrix.can_multiply_to' => trans(
                'validation.can_multiply_to',
                [
                    'attribute' => 'first matrix',
                    'values' => 'second matrix'
                ]
            ),
        ];
    }
}
