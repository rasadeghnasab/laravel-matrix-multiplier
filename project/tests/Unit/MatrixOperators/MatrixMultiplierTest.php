<?php

namespace Tests\Unit\MatrixOperators;

use App\Classes\Matrix;
use App\Classes\MatrixOperators\MatrixMultiplier;
use App\Exceptions\InvalidMatrixException;
use App\Interfaces\MatrixInterface;
use PHPUnit\Framework\TestCase;

class MatrixMultiplierTest extends TestCase
{
    /**
     * @test
     * @dataProvider matrices_to_multiply
     *
     * @param array $data
     * @throws InvalidMatrixException
     */
    public function we_can_multiply_two_matrices(array $data): void
    {
        $m1 = new Matrix($data['m1']);
        $m2 = new Matrix($data['m2']);

        $result = (new MatrixMultiplier(Matrix::class))->calculate($m1, $m2);

        $this->assertInstanceOf(MatrixInterface::class, $result);
        $this->assertEqualsCanonicalizing($data['expected'], $result->toArray());
    }

    public function matrices_to_multiply()
    {
        return [
            [
                [
                    'm1' => [
                        [1, 1, 1, 1],
                        [1, 1, 1, 1],
                    ],
                    'm2' => [
                        [1, 1],
                        [1, 1],
                        [1, 1],
                        [1, 1],
                    ],
                    'expected' => [
                        [4, 4],
                        [4, 4],
                    ]
                ]
            ],
            [
                [
                    'm1' => [
                        [1, 2, 3, 4],
                        [1, 2, 3, 4],
                        [1, 2, 3, 4],
                    ],
                    'm2' => [
                        [1, 2, 3, 4],
                        [1, 2, 3, 4],
                        [1, 2, 3, 4],
                        [1, 2, 3, 4],
                    ],
                    'expected' => [
                        [10, 20, 30, 40],
                        [10, 20, 30, 40],
                        [10, 20, 30, 40],
                    ]
                ]
            ],
            [
                [
                    'm1' => [
                        [1, 2],
                        [1, 2],
                        [1, 2],
                    ],
                    'm2' => [
                        [1, 2],
                        [1, 2],
                    ],
                    'expected' => [
                        [3, 6],
                        [3, 6],
                        [3, 6],
                    ]
                ]
            ],
        ];
    }
}

