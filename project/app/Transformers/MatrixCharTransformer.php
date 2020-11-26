<?php

namespace App\Transformers;

use App\Classes\ValidMatrix;
use App\Interfaces\MatrixInterface;
use App\Interfaces\MatrixTransformerInterface;

class MatrixCharTransformer implements MatrixTransformerInterface
{
    /**
     * @param MatrixInterface $matrix
     * @return MatrixInterface
     */
    public static function transform(MatrixInterface $matrix): MatrixInterface
    {
        $matrix_value = $matrix->toArray();

        array_walk_recursive($matrix_value, array(self::class, 'toChar'));

        $matrix->update(new ValidMatrix($matrix_value));

        return $matrix;
    }

    private static function toChar(int &$number): void
    {
        $number = $number - 1;
        $ordA = ord('A');
        $ordZ = ord('Z');

        $len = $ordZ - $ordA + 1;
        $output = "";
        while($number >= 0) {
            $output = chr($number % $len + $ordA) . $output;
            $number = floor($number / $len) - 1;
        }

        $number = $output;
    }
}
