<?php

namespace App\Interfaces;

interface MatrixTransformerInterface
{
    public static function transform(MatrixInterface $matrix): array;
}
