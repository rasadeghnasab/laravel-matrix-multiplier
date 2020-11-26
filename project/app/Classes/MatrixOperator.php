<?php

namespace App\Classes;

class MatrixOperator
{
    public function multiply($m1, $m2)
    {
        $result = [];
        $total = count($m1);

        foreach ($m1 as $key => $current_row) {
            for ($i = 0; $i < $total; $i++) {
                $current_column = $this->arrayShiftKey($m2, $i);
                $cell_sum = $this->calcSum($current_row, $current_column);

                $final[$key][] = $cell_sum;
            }
        }

        return $result;
    }

    /**
     * Returns an array of keys for
     * an array of arrays.
     *
     * @param array $arr The array of arrays.
     * @param int $index The index to use for
     *                     each array.
     *
     * @return array
     */
    private function arrayShiftKey(array $arr, int $index): array
    {
        $t = [];
        foreach ($arr as $array) {
            $t[] = $array[$index];
        }
        return $t;
    }

    /**
     * Sums the product of two
     * equally-length arrays.
     *
     * @param array $first
     * @param array $second
     *
     * @return int
     */
    private function calcSum(array $first, array $second): int
    {
        $total = 0;
        for ($i = 0; $i < count($first); $i++) {
            $total += $first[$i] * $second[$i];
        }
        return $total;
    }
}
