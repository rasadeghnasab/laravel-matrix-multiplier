<?php declare(strict_types=1);

namespace App\Rules;

use App\Classes\ValidMatrix;
use App\Exceptions\InvalidMatrixException;
use Illuminate\Contracts\Validation\Rule;

class IsValidMatrix implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            new ValidMatrix($value);
        } catch (InvalidMatrixException $exception) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.is_valid_matrix');
    }
}
