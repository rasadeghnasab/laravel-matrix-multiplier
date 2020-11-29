<?php declare(strict_types=1);

namespace App\Transformers;

use App\Interfaces\{MatrixInterface, MatrixTransformerInterface};

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
        $order_a = ord('A');
        $order_z = ord('Z');

        $length = $order_z - $order_a + 1;
        $output = "";
        while ($number >= 0) {
            $output = chr($number % $length + $order_a) . $output;
            $number = floor($number / $length) - 1;
        }

        $number = empty($output) ? 'non' : $output;
    }
}
