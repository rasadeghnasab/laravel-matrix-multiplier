<?php

namespace Tests\Unit;

use App\Classes\ValidMatrix;
use App\Exceptions\InvalidMatrixException;
use PHPUnit\Framework\TestCase;

class ValidMatrixTest extends TestCase
{
    /**
     * @test
     * @dataProvider invalid_matrices_data
     *
     * @param array $data
     * @return void
     */
    public function throw_exception_if_data_is_not_valid(array $data): void
    {
        $this->expectException(InvalidMatrixException::class);
        $this->expectExceptionMessage('Matrix is invalid.');

        new ValidMatrix($data);
    }

    /**
     * @test
     * @dataProvider valid_matrices
     * @doesNotPerformAssertions
     *
     * @param array $data
     * @return void
     * @throws InvalidMatrixException
     */
    public function wont_throw_any_exception_using_valid_data(array $data): void
    {
        new ValidMatrix($data);
    }

    /**
     * Data providers
     */

    /**
     * @return array
     */
    public function valid_matrices(): array
    {
        return [
            'simple_matrix' => [
                [
                    [1, 1, 1],
                    [1, 1, 1],
                    [1, 1, 1]
                ],
            ],
            'one_row_column_matrix' => [
                [
                    [1],
                ],
            ],
            'big_complicated_matrix' => [
                [
                    [1, 2, 3, 4],
                    [5, 6, 7, 8],
                    [9, 10, 11, 12],
                ],
            ],
            'matrix_with_numeric_strings' => [
                [
                    [1, 2, '3'],
                    ['1', '2', '3'],
                    ['1', 2, '3'],
                ]
            ]
        ];
    }

    /**
     * @returns array
     */
    public function invalid_matrices_data(): array
    {
        return [
            'invalid_second_row' => [
                [
                    [1, 2],
                    [1, 2, 3],
                    [1, 2],
                    [1, 2],
                ]
            ],
            'empty_matrix' => [
                []
            ],
            'complex_invalid_rows' => [
                [
                    [1, 2, 3],
                    [],
                    [1,]
                ]
            ],
            'multiple_invalid_rows' => [
                [
                    [1],
                    [1, 2],
                    [1, 2, 3],
                ]
            ],
            'has_a_non_array_row' => [
                [
                    [1, 2],
                    [1, 2],
                    1,
                ]
            ],
            'has_a_character_item' => [
                [
                    ['a']
                ]
            ],
        ];
    }
}
