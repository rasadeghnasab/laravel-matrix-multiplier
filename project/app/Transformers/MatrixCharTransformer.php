<?php

namespace App\Transformers;

use App\Interfaces\MatrixInterface;
use App\Interfaces\MatrixTransformerInterface;

class MatrixCharTransformer implements MatrixTransformerInterface
{
    /**
     * @param MatrixInterface $matrix
     * @return array
     */
    public static function transform(MatrixInterface $matrix): array
    {
        $matrix_value = $matrix->toArray();

        array_walk_recursive($matrix_value, array(self::class, 'toChar'));

        return $matrix_value;
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
