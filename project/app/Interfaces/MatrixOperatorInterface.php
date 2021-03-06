<?php declare(strict_types=1);

namespace App\Interfaces;

interface MatrixOperatorInterface
{
    public function __construct(MatrixCreatorInterface $matrixInterface);

    public function calculate(MatrixInterface $m1, MatrixInterface $m2): MatrixInterface;
}
