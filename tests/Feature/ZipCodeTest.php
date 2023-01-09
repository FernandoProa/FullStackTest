<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ZipCodeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function searchTest()
    {
        $response = $this->get('/api/zipcode/' . 77560);
        $response->assertStatus(200)->assertJsonStructure(

            ["zip_code",
                "locality",
                "federal_entity" => [
                    "key",
                    "name",
                    "code"
                ],
                "settlements" => [
                    '*' => [
                        "key",
                        "name",
                        "zone_type",
                        "settlement_type" => [
                            "name"
                        ],
                    ],
                ],
                "municipality" => [
                    "key",
                    "name",
                ]

            ]
        );
    }

    public function notFoundTest()
    {
        $response = $this->get('/api/zipcode/' . 9999);
        $response->assertStatus(400);
    }

    public function formatErrorTest()
    {
        $response = $this->get('/api/zipcode/' . 'string');
        $response->assertStatus(500);
    }
}
