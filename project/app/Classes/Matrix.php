<?php declare(strict_types=1);

namespace App\Classes;

use App\Interfaces\MatrixCreatorInterface;
use App\Interfaces\MatrixInterface;
use Exception;

class Matrix implements MatrixInterface, MatrixCreatorInterface
{
    /**
     * @var array
     */
    private array $matrix;
    private array $columns = [];

    /**
     * Matrix constructor.
     * @param ValidMatrix $matrix
     */
    public function __construct(ValidMatrix $matrix)
    {
        $this->matrix = $matrix->toArray();
    }

    /**
     * Returns a specific column from the matrix
     *
     * @param int $column_index
     * @return array
     * @throws Exception
     */
    public function column(int $column_index): array
    {
        $columns = $this->columns();

        if (!isset($columns[$column_index])) {
            throw new Exception(sprintf('The matrix has exactly %d columns.', count($this->columns)));
        }

        return $columns[$column_index];
    }

    /**
     * Returns matrix columns
     *
     * @return array
     */
    public function columns(): array
    {
        if (!empty($this->columns)) {
            return $this->columns;
        }

        $columns = [];
        foreach ($this->matrix as $row_index => $row) {
            foreach ($row as $column_index => $item) {
                $columns[$column_index][$row_index] = $item;
            }
        }

        return $this->columns = $columns;
    }

    /**
     * A matrix can be updated by new values
     * @param ValidMatrix $matrix
     * @return $this
     */
    public function update(ValidMatrix $matrix): self
    {
        $this->matrix = $matrix->toArray();

        return $this;
    }

    public function rowCount(): int
    {
        return count($this->matrix);
    }

    public function columnCount(): int
    {
        return count($this->row(0));
    }

    /**
     * Returns a specific row from the matrix
     *
     * @param int $row_index
     * @return array
     * @throws Exception
     */
    public function row(int $row_index): array
    {
        if (!isset($this->matrix[$row_index])) {
            $message = sprintf('The matrix has exactly %d rows.', count($this->matrix));
            throw new Exception($message);
        }
        return $this->matrix[$row_index];
    }

    /**
     * Returns matrix as an array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->matrix;
    }
}
