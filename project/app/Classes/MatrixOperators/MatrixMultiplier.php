<?php declare(strict_types=1);

namespace App\Classes\MatrixOperators;

use App\Classes\ValidMatrix;
use App\Exceptions\ImpossibleMatrixMultiplyException;
use App\Interfaces\{MatrixCreatorInterface, MatrixInterface, MatrixOperatorInterface};

class MatrixMultiplier implements MatrixOperatorInterface
{
    private MatrixCreatorInterface $result_matrix;

    /**
     * MatrixMultiplier constructor.
     * @param MatrixCreatorInterface $result_matrix
     */
    public function __construct(MatrixCreatorInterface $result_matrix)
    {
        $this->result_matrix = $result_matrix;
    }

    /**
     * @param MatrixInterface $m1
     * @param MatrixInterface $m2
     * @return MatrixInterface
     */
    public function calculate(MatrixInterface $m1, MatrixInterface $m2): MatrixInterface
    {
        $this->operationCanPerform($m1, $m2);

        $result = [];

        $m2_columns = $m2->columns();
        foreach ($m1->toArray() as $row_index => $row) {
            foreach ($m2_columns as $column_index => $m2_column) {
                $result[$row_index][$column_index] = $this->sum($m2_column, $row);
            }
        }

        return $this->result_matrix->update(new ValidMatrix($result));
    }

    private function operationCanPerform(MatrixInterface $m1, MatrixInterface $m2): void
    {
        if ($m1->columnCount() !== $m2->rowCount()) {
            $message = sprintf("The second matrix must have %s rows.", $m1->columnCount());

            throw new ImpossibleMatrixMultiplyException($message);
        }
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
