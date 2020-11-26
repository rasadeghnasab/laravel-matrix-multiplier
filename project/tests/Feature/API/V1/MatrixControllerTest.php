<?php

namespace Tests\Feature\API\V1;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MatrixControllerTest extends TestCase
{
    protected string $uri = '/api/v1/matrix/multiply';

    /**
     * Tests the post call to retrieve
     * a matrix product from input.
     *
     * @test
     * @dataProvider multiplication_data
     *
     * @param array $first_matrix
     * @param array $second_matrix
     * @param int $status The HTTP status expected from call
     *                          response from call
     * @param array $expected
     * @return void
     */
    public function matrix_multiplication(array $first_matrix, array $second_matrix, int $status, array $expected): void
    {
        $response = $this->json('POST', $this->uri, [
            'first_matrix' => $first_matrix,
            'second_matrix' => $second_matrix
        ]);

        $response
            ->assertStatus($status)
            ->assertJson($expected);
    }

    /**
     * Created data for different scenarios.
     *
     * @return array
     */
    public function multiplication_data(): array
    {
        return [
            'unequal matrixA' => [
                [
                    [2, 4],
                    [3, 5, 6]
                ],
                [
                    [5, 6, 7],
                    [4, 3, 6]
                ],
                422,
                [
                    'errors' => [
                        "first_matrix" => ["The first matrix is not a valid matrix."]
                    ]
                ]
            ],
            'unequal matrixB' => [
                [
                    [3, 6, 5],
                    [6, 8, 7]
                ],
                [
                    [1],
                    [4, 6, 7],
                    [5, 7, 8]
                ],
                422,
                [
                    'errors' => ["second_matrix" => ["The second matrix is not a valid matrix."]]
                ]
            ],
            'string numeric values Both matrices' => [
                [
                    ['8', 12]
                ],
                [
                    [25, '18'],
                    [8, 4]
                ],
                200,
                [
                    'data' => [['KJ', 'GJ']]
                ]
            ],
            'nonnumeric values both matrices' => [
                [
                    [2, 5, 6, 'F']
                ],
                [
                    [5],
                    [6],
                    ['M'],
                    [9]
                ],
                422,
                [
                    'errors' => [
                        'first_matrix' => [
                            "The first matrix is not a valid matrix.",
                            "The first matrix must only contain integers(whole numbers).",
                        ],
                        'second_matrix' => [
                            "The second matrix is not a valid matrix.",
                            "The second matrix must only contain integers(whole numbers)."
                        ]
                    ]
                ]
            ],
            'nonnumeric values MatrixA' => [
                [
                    [2, 5, 6, 'K']
                ],
                [
                    [5],
                    [6],
                    [8],
                    [9]
                ],
                422,
                [
                    'errors' => [
                        'first_matrix' => [
                            "The first matrix is not a valid matrix.",
                            "The first matrix must only contain integers(whole numbers).",
                        ],
                    ]
                ]
            ],
            'unequal row to col' => [
                [
                    [2, 4, 5, 6]
                ],
                [
                    [2],
                    [5],
                    [7]
                ],
                422,
                [
                    'errors' => [
                        'first_matrix' => ["The second matrix rows must be equal to the first matrix columns."]
                    ]
                ]
            ],
            'small complete matrices' => [
                [
                    [8,12]
                ],
                [
                    [25, 18],
                    [8,4]
                ],
                200,
                [
                    'data' => [['KJ', 'GJ']]
                ]
            ],
            'medium complete matrices' => [
                [
                    [10,20,10,15],
                    [5,6,7,15]
                ],
                [
                    [2,4],
                    [6,8],
                    [10,12],
                    [16,18]
                ],
                200,
                [
                    'data' => [ ['RL', 'VR'], ['MR','PF']]
                ]
            ],
            'big complete matrices' => [
                [
                    [10,20,10,15],
                    [5,6,7,15],
                    [30,16,17,35]
                ],
                [
                    [2,4],
                    [26,8],
                    [10,12],
                    [36,48]
                ],
                200,
                [
                    'data' => [ ['ASJ','AMZ'], ['ACV', 'AGN'], ['BUH', 'CCZ']],
                ]
            ]
        ];
    }
}
