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
            [
                [
                    [1, 1, 1],
                    [1, 1, 1],
                    [1, 1, 1]
                ],
            ],
            [
                [
                    [1],
                ],
            ],
            [
                [
                    [1, 2, 3, 4],
                    [5, 6, 7, 8],
                    [9, 10, 11, 12],
                ],
            ]
        ];
    }

    /**
     * @returns array
     */
    public function invalid_matrices_data(): array
    {
        return [
            [
                [
                    [1, 2],
                    [1, 2, 3],
                    [1, 2],
                    [1, 2],
                ],
                [],
                [
                    [1, 2, 3],
                    [],
                    [1,]
                ],
                [
                    [1],
                    [1, 2],
                    [1, 2, 3],
                ],
                [
                    [1, 2],
                    [1, 2],
                    1,
                ],
            ],
        ];
    }
}
