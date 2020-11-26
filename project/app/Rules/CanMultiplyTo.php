<?php

namespace App\Rules;

use App\Classes\Matrix;
use App\Classes\ValidMatrix;
use App\Exceptions\InvalidMatrixException;
use Illuminate\Contracts\Validation\Rule;

class CanMultiplyTo implements Rule
{
    protected $validator;
    protected $parameters;
    private $column_count;

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $data = $this->validator->getData();

        $other_matrix = $data[$this->parameters];

        try {
            $first_matrix = new Matrix(new ValidMatrix($value));
            $second_matrix = new Matrix(new ValidMatrix($other_matrix));
        } catch (InvalidMatrixException $e) {
            return false;
        }

        $this->column_count = $first_matrix->columnCount();

        return $this->column_count === $second_matrix->rowCount();
    }

    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validate($attribute, $value, $parameters, $validator)
    {
        $this->validator = $validator;
        $this->parameters = array_shift($parameters);

        return $this->passes($attribute, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.can_multiply_to');
    }
}
