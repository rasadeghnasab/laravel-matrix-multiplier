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
     * @param array $matrixA The first input matrix
     * @param array $matrixB The second input matrix
     * @param int $status The HTTP status expected from call
     *                          response from call
     * @param array $expected
     * @return void
     */
    public function matrix_multiplication(array $matrixA, array $matrixB, int $status, array $expected): void
    {
        $response = $this->json('POST', $this->uri, [
            'firstMatrix' => $matrixA,
            'secondMatrix' => $matrixB
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
                        "firstMatrix" => ["The first matrix is not a valid matrix."]
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
                    'errors' => ["secondMatrix" => ["The second matrix is not a valid matrix."]]
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
                    'data' => [['KS', 'GJ']]
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
                        'firstMatrix' => [
                            "The first matrix is not a valid matrix.",
                            "The first matrix must only contain integers(whole numbers).",
                        ],
                        'secondMatrix' => [
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
                        'firstMatrix' => [
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
                        'secondMatrix' => ["The second matrix must contain 4 items."]
                    ]
                ]
            ],
//            'small complete matrices' => [
//                [
//                    [8,12]
//                ],
//                [
//                    [25, 18],
//                    [8,4]
//                ],
//                200,
//                [
//                    'data' => [['KJ', 'GJ']]
//                ]
//            ],
//            'medium complete matrices' => [
//                [
//                    [10,20,10,15],
//                    [5,6,7,15]
//                ],
//                [
//                    [2,4],
//                    [6,8],
//                    [10,12],
//                    [16,18]
//                ],
//                200,
//                [
//                    'data' => [ ['RL', 'VR'], ['MR','PF']]
//                ]
//            ]
        ];
    }
}
