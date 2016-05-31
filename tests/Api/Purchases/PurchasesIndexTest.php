<?php

use Carbon\Carbon;

use EmberGrep\Models\Course;
use EmberGrep\Models\Purchase;
use EmberGrep\Models\User;

class PurchasesIndexTest extends AcceptanceTestCase
{
    public function setupData()
    {
        $this->courseAttrsOne = [
            'name' => 'First Name',
            'price' => 200,
            'release_date' => Carbon::now()->subDay(),
            'description' => 'lorem pixum',
            'is_published' => true,
            'description_long' => 'Lorem ipsum dolor sit amet',
            'coming_soon' => false,
        ];

        $this->courseAttrsTwo = [
            'name' => 'Last Name',
            'price' => 400,
            'release_date' => Carbon::now()->subDay(),
            'description' => 'exej pixum',
            'is_published' => true,
            'description_long' => 'Foo Bar',
            'coming_soon' => false,
        ];

        $this->courseOne = Course::create($this->courseAttrsOne);
        $this->courseTwo = Course::create($this->courseAttrsTwo);

        $this->purchaseAttrs = [
            'course_id' => 1,
            'user_id' => $this->user->id,
        ];
    }

    public function testRequiresAuth()
    {
        $this->jsonWithInvalidAuth('GET', '/purchases');

        $this->assertResponseStatus(401);
    }

    public function testAllPurchases()
    {
        $this->setupData();

        $p = Purchase::create([
            'user_id' => $this->user->id,
            'course_id' => $this->courseOne->id,
            'charge_amount' => 400,
            'card_brand' => 'VISA',
            'charge_id' => 'BARTER',
        ]);


        $this->jsonWithValidAuth('GET', '/purchases');

        $this->assertResponseOk();

        $this->seeJson([
            'data' => [
                [
                    'type' => 'purchases',
                    'id' => '1',
                    'attributes' => [
                        'purchase-price' => 400,
                        'date'          => $p->created_at->toIso8601String(),
                        'notifications' => true,
                    ],
                    'relationships' => [
                        "course" => [
                            "data" => [
                                "id" => "first-name","type"=> "courses"
                            ]
                        ]
                    ],
                ],
            ],
        ]);

        $this->seeJson([
            'included' => [
                [
                        "attributes" => [
                        "active" => true,
                        "coming-soon" => false,
                        "description" => "lorem pixum",
                        "long-description" => "Lorem ipsum dolor sit amet",
                        "name" => "First Name",
                        "price" => 200,
                        "purchased" => false,
                        "release-date" => $this->courseOne->release_date->toIso8601String(),
                        "time" => 0,
                    ],
                    "id" => "first-name",
                    "type" => "courses",
                ],
            ],
        ]);
    }
}
