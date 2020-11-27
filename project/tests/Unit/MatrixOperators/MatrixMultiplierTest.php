<?php

namespace Tests\Unit\MatrixOperators;

use App\Classes\Matrix;
use App\Classes\MatrixOperators\MatrixMultiplier;
use App\Classes\ValidMatrix;
use App\Exceptions\ImpossibleMatrixMultiplyException;
use App\Exceptions\InvalidMatrixException;
use App\Interfaces\MatrixInterface;
use PHPUnit\Framework\TestCase;

class MatrixMultiplierTest extends TestCase
{
    /**
     * @test
     * @dataProvider matrices_to_multiply
     *
     * @param array $m1
     * @param array $m2
     * @param array $expected
     * @throws InvalidMatrixException
     */
    public function we_can_multiply_two_matrices(array $m1, array $m2, array $expected): void
    {
        $m1 = new Matrix(new ValidMatrix($m1));
        $m2 = new Matrix(new ValidMatrix($m2));

        $result = (new MatrixMultiplier(Matrix::class))->calculate($m1, $m2);

        $this->assertInstanceOf(MatrixInterface::class, $result);
        $this->assertEqualsCanonicalizing($expected, $result->toArray());
    }

    /**
     * @test
     * @throws InvalidMatrixException
     */
    public function multiplication_throws_error_if_matrices_columns_and_rows_were_not_equal(): void
    {
        $this->expectException(ImpossibleMatrixMultiplyException::class);
        $this->expectExceptionMessage('The second matrix must have 4 rows.');

        $m1 = new Matrix(new ValidMatrix([
            [1, 1, 1, 1],
        ]));

        $m2 = new Matrix(new ValidMatrix([
            [1, 1],
            [1, 1],
            [1, 1],
        ]));

        (new MatrixMultiplier(Matrix::class))->calculate($m1, $m2);
    }

    /**
     * Data providers
     */

    public function matrices_to_multiply()
    {
        return [
            'first multiplication try' => [
                [
                    [1, 1, 1, 1],
                    [1, 1, 1, 1],
                ],
                [
                    [1, 1],
                    [1, 1],
                    [1, 1],
                    [1, 1],
                ],
                [
                    [4, 4],
                    [4, 4],
                ]
            ],
            'second multiplication try' => [
                [
                    [1, 2, 3, 4],
                    [1, 2, 3, 4],
                    [1, 2, 3, 4],
                ],
                [
                    [1, 2, 3, 4],
                    [1, 2, 3, 4],
                    [1, 2, 3, 4],
                    [1, 2, 3, 4],
                ],
                [
                    [10, 20, 30, 40],
                    [10, 20, 30, 40],
                    [10, 20, 30, 40],
                ]
            ],
            'third multiplication try' => [
                [
                    [1, 2],
                    [1, 2],
                    [1, 2],
                ],
                [
                    [1, 2],
                    [1, 2],
                ],
                [
                    [3, 6],
                    [3, 6],
                    [3, 6],
                ]
            ],
        ];
    }
}

