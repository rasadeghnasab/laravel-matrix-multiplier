<?php

namespace App\Classes\MatrixOperators;

use App\Interfaces\MatrixInterface;
use App\Interfaces\MatrixOperatorInterface;

class MatrixMultiplier implements MatrixOperatorInterface
{
    private string $matrixInterface;

    public function __construct(string $matrixInterface)
    {
        $this->matrixInterface = $matrixInterface;
    }

    /**
     * @param MatrixInterface $m1
     * @param MatrixInterface $m2
     * @return MatrixInterface
     */
    public function calculate(MatrixInterface $m1, MatrixInterface $m2): MatrixInterface
    {
        $result = [];

        $m2_columns = $m2->columns();
        foreach ($m1->toArray() as $row_index => $row) {
            foreach ($m2_columns as $column_index => $m2_column) {
                $result[$row_index][$column_index] = $this->sum($m2_column, $row);
            }
        }

        return new $this->matrixInterface($result);
    }

    private function sum(array $m1, array $m2): int
    {
        $sum = 0;
        foreach ($m1 as $index => $m1_item) {
            $sum += $m1[$index] * $m2[$index];
        }

        return $sum;
    }
}
