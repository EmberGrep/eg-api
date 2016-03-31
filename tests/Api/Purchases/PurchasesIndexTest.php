<?php

use Carbon\Carbon;

use EmberGrep\Models\Course;
use EmberGrep\Models\Purchase;
use EmberGrep\Models\User;

class PurchasesIndexTest extends AcceptanceTestCase
{
    protected $invalidToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvYXV0aC10b2tlbiIsImlhdCI6MTQ1OTQ0NTQ3MiwiZXhwIjoxNDU5NDQ5MDcyLCJuYmYiOjE0NTk0NDU0NzIsImp0aSI6IjUwZGQwNWE3ZTdmZjhkNjY5MTM5NGUwODU4NTQzOTYwIn0.Gsl3eOgDQa_WlRbRt2ZgJGxqZOkhkaNXk2dEzcOV-fk";

    public function setupData()
    {
        $this->userAttrs = ['email' => 'admin@example.com', 'password' => bcrypt('password')];
        $this->user = User::create($this->userAttrs);
        $this->token = JWTAuth::fromUser($this->user);

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
            'created_at' => Carbon::now()->subDay(),
            'course_id' => 1,
            'user_id' => $this->user->id,
        ];
    }

    public function testRequiresAuth()
    {
        $this->call('GET', '/purchases', [], [], [], $this->bearer($this->invalidToken));

        $this->assertResponseStatus(401);

        $this->seeJson([
            'error' => 'user_not_found',
        ]);
    }

    // public function testAllPurchases()
    // {
    //     $this->setupData();
    //     $this->call('GET', '/purchases', [], [], ['Authorization' => 'Bearer {$this->token}']);
    //
    //     $this->assertResponseOk();
    //
    //     $this->seeJson([
    //         'data' => [
    //             [
    //                 'type' => 'purchases',
    //                 'id' => '1',
    //                 'attributes' => [
    //                     'purchase-price' => 400,
    //                     'course'        => 'first-name',
    //                     'date'          => $this->purchaseAttrs['created_at']->toIso8601String(),
    //                     'notifications' => true,
    //                 ],
    //             ],
    //         ],
    //     ]);
    // }
}
