<?php


namespace App\Interfaces;

use App\Classes\ValidMatrix;

interface MatrixCreatorInterface
{
    public function __construct(ValidMatrix $matrix);

    public function update(ValidMatrix $matrix): MatrixInterface;
}
