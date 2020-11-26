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
     */
    public function matrix_items_can_be_transform_to_chars()
    {
        $matrix = new Matrix(new ValidMatrix([
            [1, 2, 3,],
            [26, 27, 28],
        ]));

        $char_matrix = MatrixCharTransformer::transform($matrix);

        $expected = [
            ['A', 'B', 'C'],
            ['Z', 'AA', 'AB']
        ];

        $this->assertEqualsCanonicalizing($expected, $char_matrix->toArray());
    }
}
