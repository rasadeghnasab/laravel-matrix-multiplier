<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MatrixNumeric implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param $attribute
     * @param $matrix
     * @return bool
     */
    public function passes($attribute, $matrix): bool
    {
        foreach ($matrix as $row) {
            $check = array_filter($row, 'is_numeric');
            if (count($check) < count($row)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "The :attribute must only contain integers(whole numbers).";
    }
}
