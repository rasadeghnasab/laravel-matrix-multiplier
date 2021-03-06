<?php declare(strict_types=1);

namespace App\Classes;

use App\Exceptions\InvalidMatrixException;

class ValidMatrix
{
    private array $matrix;

    public function __construct(array $matrix)
    {
        if (!$this->validate($matrix)) {
            throw new InvalidMatrixException('Matrix is invalid.');
        }

        $this->matrix = $matrix;
    }

    public function validate(array $matrix): bool
    {
        if (empty($matrix)) {
            return false;
        }

        $prev_column_count = count($matrix[0]);
        foreach ($matrix as $row) {
            if (!is_array($row)) {
                return false;
            }

            $current_column_count = count($row);
            if ($current_column_count != $prev_column_count) {
                return false;
            }

            foreach ($row as $column) {
                if (!is_numeric($column)) {
                    return false;
                }
            }
            $prev_column_count = $current_column_count;
        }

        return true;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->matrix;
    }
}

