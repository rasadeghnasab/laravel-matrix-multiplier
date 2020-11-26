<?php

namespace Tests\Unit;

use App\Classes\Matrix;
use App\Exceptions\EmptyMatrixException;
use Exception;
use PHPUnit\Framework\TestCase;

class MatrixTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     * @throws EmptyMatrixException
     */
    public function a_matrix_can_not_be_empty(): void
    {
        $this->expectException(EmptyMatrixException::class);
        $this->expectExceptionMessage('Matrix can not be empty');

        new Matrix([]);
    }

    /**
     * @test
     * @dataProvider sample_matrices
     * @doesNotPerformAssertions
     *
     * @param array $array
     * @return void
     * @throws EmptyMatrixException
     */
    public function a_matrix_can_be_created_by_a_not_empty_array(array $array): void
    {
        new Matrix($array);
    }

    /**
     * @test
     * @dataProvider sample_matrices
     *
     * @param array $array
     * @return void
     * @throws EmptyMatrixException
     */
    public function matrix_should_be_equal_to_the_passed_array(array $array): void
    {
        $matrix = new Matrix($array);

        $this->assertEqualsCanonicalizing($array, $matrix->toArray());
    }

    /**
     * @test
     * @dataProvider matrix_to_columns
     *
     * @param array $data
     * @throws EmptyMatrixException
     */
    public function matrix_could_be_presented_by_columns(array $data): void
    {
        $matrix = new Matrix($data['matrix']);

        $this->assertEqualsCanonicalizing($data['expected'], $matrix->columns());
    }

    /**
     * @test
     * @dataProvider get_a_specific_column
     *
     * @param array $data
     * @throws Exception|EmptyMatrixException
     */
    public function we_can_get_a_column_separately(array $data): void
    {
        $matrix = new Matrix($data['matrix']);

        $this->assertEqualsCanonicalizing($data['expected'], $matrix->column($data['column']));
    }

    /**
     * @test
     * @dataProvider unexpected_column
     *
     * @param array $data
     * @throws Exception|EmptyMatrixException
     */
    public function throw_exception_if_column_does_not_exist(array $data): void
    {
        $this->expectException(Exception::class);

        $matrix = new Matrix($data['matrix']);

        $matrix->column($data['column']);
    }

    /**
     * @test
     * @throws EmptyMatrixException
     */
    public function a_matrix_can_be_updated_by_new_values(): void
    {
        $matrix = new Matrix([
            [1, 1, 1],
            [2, 2, 2],
            [3, 3, 3],
        ]);

        $expected = [
            [1, 2],
            [3, 4],
        ];

        $matrix->update($expected);

        $this->assertEqualsCanonicalizing($expected, $matrix->toArray());
    }

    /**
     * @test
     */
    public function matrix_can_not_be_updated_using_empty_array(): void
    {
        $this->expectException(EmptyMatrixException::class);
        $this->expectExceptionMessage('Matrix can not be empty');

        $matrix = new Matrix([
            [1, 1, 1],
            [2, 2, 2],
            [3, 3, 3],
        ]);

        $expected = [];

        $matrix->update($expected);
    }

    /**
     * @test
     * @throws Exception|EmptyMatrixException
     */
    public function we_can_get_a_row(): void
    {
        $matrix = new Matrix([
            [1, 2, 3, 4],
            [5, 6, 7, 8],
        ]);

        $this->assertEquals([1, 2, 3, 4], $matrix->row(0));
        $this->assertEquals([5, 6, 7, 8], $matrix->row(1));
    }

    /**
     * @test
     * @dataProvider row_and_column_count
     *
     * @param array $data
     * @throws EmptyMatrixException
     */
    public function we_ca_get_a_matrix_row_count(array $data): void
    {
        $matrix = new Matrix($data['matrix']);

        $this->assertEquals($data['rowCount'], $matrix->rowCount());
    }

    /**
     * @test
     * @dataProvider row_and_column_count
     *
     * @param array $data
     * @throws EmptyMatrixException
     */
    public function we_ca_get_a_matrix_column_count(array $data): void
    {
        $matrix = new Matrix($data['matrix']);

        $this->assertEquals($data['columnCount'], $matrix->columnCount());
    }


    /**
     * Data providers
     */

    public function row_and_column_count(): array
    {
        return [
            [
                [
                    'matrix' => [
                        [1],
                        [1],
                        [1],
                        [1],
                    ],
                    'rowCount' => 4,
                    'columnCount' => 1
                ],
                [
                    'matrix' => [
                        [1, 2, 3, 4],
                    ],
                    'rowCount' => 1,
                    'columnCount' => 4
                ],
                [
                    'matrix' => [
                        [1, 2, 3],
                        [2, 3, 4],
                        [4, 5, 6],
                    ],
                    'rowCount' => 3,
                    'columnCount' => 3
                ],
                [
                    'matrix' => [
                        [1, 2, 3],
                        [2, 3, 4],
                        [4, 5, 6],
                        [6, 7, 8]
                    ],
                    'rowCount' => 4,
                    'columnCount' => 3
                ],
            ]
        ];
    }
    /**
     * @return array
     */
    public function unexpected_column(): array
    {
        $matrix = [
            [1, 2, 3, 4],
            [5, 6, 7, 8],
        ];

        return [
            [
                [
                    'matrix' => $matrix,
                    'column' => -1
                ],
            ],
            [
                [
                    'matrix' => $matrix,
                    'column' => 4
                ]
            ],
            [
                [
                    'matrix' => $matrix,
                    'column' => 10
                ]
            ],
            [
                [
                    'matrix' => $matrix,
                    'column' => '-1'
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function get_a_specific_column(): array
    {
        return [
            [
                [
                    'matrix' => [
                        [1]
                    ],
                    'column' => 0,
                    'expected' => [1],
                ],
            ],
            [
                [
                    'matrix' => [
                        [1, 2],
                    ],
                    'column' => 1,
                    'expected' => [2]
                ]
            ],
            [
                [
                    'matrix' => [
                        [1, 2, 3, 4],
                        [5, 6, 7, 8],
                        [9, 10, 11, 12],
                    ],
                    'column' => 0,
                    'expected' => [1, 5, 9],
                ]
            ],
            [
                [
                    'matrix' => [
                        [1, 2, 3, 4],
                        [5, 6, 7, 8],
                        [9, 10, 11, 12],
                    ],
                    'column' => 1,
                    'expected' => [2, 6, 10],
                ]
            ],
            [
                [
                    'matrix' => [
                        [1, 2, 3, 4],
                        [5, 6, 7, 8],
                        [9, 10, 11, 12],
                    ],
                    'column' => 2,
                    'expected' => [3, 7, 11],
                ]
            ],
            [
                [
                    'matrix' => [
                        [1, 2, 3, 4],
                        [5, 6, 7, 8],
                        [9, 10, 11, 12],
                    ],
                    'column' => 3,
                    'expected' => [4, 8, 12],
                ]
            ],
        ];
    }

    /**
     * @return array
     */
    public function matrix_to_columns(): array
    {
        return [
            [
                [
                    'matrix' => [
                        [1]
                    ],
                    'expected' => [
                        [1]
                    ]
                ],
            ],
            [
                [
                    'matrix' => [
                        [1, 2, 3, 4],
                    ],
                    'expected' => [
                        [1],
                        [2],
                        [3],
                        [4],
                    ],
                ],
            ],
            [
                [
                    'matrix' => [
                        [1, 2, 3, 4, 5],
                        [6, 7, 8, 9, 10],
                    ],
                    'expected' => [
                        [1, 6],
                        [2, 7],
                        [3, 8],
                        [4, 9],
                        [5, 10],
                    ]
                ],
            ],
            [
                [
                    'matrix' => [
                        [1, 2, 3],
                        [4, 5, 6],
                        [7, 8, 9],
                        [10, 11, 12],
                    ],
                    'expected' => [
                        [1, 4, 7, 10],
                        [2, 5, 8, 11],
                        [3, 6, 9, 12],
                    ],
                ]
            ],
        ];
    }

    /**
     * @return array
     */
    public function sample_matrices(): array
    {
        return [
            [
                [1, 1, 1],
                [1, 1, 1],
                [1, 1, 1]
            ],
            [
                [1]
            ],
            [
                [1, 2, 3, 4],
                [5, 6, 7, 8],
                [9, 10, 11, 12],
            ]
        ];
    }

}
