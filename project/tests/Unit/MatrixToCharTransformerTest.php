<?php

namespace Tests\Unit;

use App\Classes\Matrix;
use App\Classes\ValidMatrix;
use App\Transformers\MatrixCharTransformer;
use PHPUnit\Framework\TestCase;

class MatrixToCharTransformerTest extends TestCase
{
    /**
     * @test
     * @dataProvider transformers_data
     * @param array $matrix
     * @param array $expected
     */
    public function matrix_items_can_be_transform_to_chars(array $matrix, array $expected)
    {
        $matrix = new Matrix(new ValidMatrix($matrix));

        $char_matrix = MatrixCharTransformer::transform($matrix);

        $this->assertEqualsCanonicalizing($expected, $char_matrix);
    }

    /**
     * Data providers
     */
    public function transformers_data()
    {
        return [
            'valid-transformation' => [
                [
                    [1, 2, 3,],
                    [26, 27, 28],
                ],
                [
                    ['A', 'B', 'C'],
                    ['Z', 'AA', 'AB']
                ]
            ],
            'non included' => [
                [
                    [1, 2, -1,],
                    [26, 0, 28],
                ],
                [
                    ['A', 'B', 'non'],
                    ['Z', 'non', 'AB']
                ],
            ]
        ];
    }
}
