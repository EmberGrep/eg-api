<?php

use Carbon\Carbon;

use EmberGrep\Models\Course;
use EmberGrep\Models\Purchase;
use EmberGrep\Models\User;

class PurchaseAttemptTest extends AcceptanceTestCase
{
    protected $validCard = '4242424242424242';
    protected $invalidCard = '4000000000000002';
    protected $invalidToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvYXV0aC10b2tlbiIsImlhdCI6MTQ1OTQ0NTQ3MiwiZXhwIjoxNDU5NDQ5MDcyLCJuYmYiOjE0NTk0NDU0NzIsImp0aSI6IjUwZGQwNWE3ZTdmZjhkNjY5MTM5NGUwODU4NTQzOTYwIn0.Gsl3eOgDQa_WlRbRt2ZgJGxqZOkhkaNXk2dEzcOV-fk';
    protected $userAttrs;
    protected $token;
    protected $user;
    protected $courseAttrsOne;
    protected $courseAttrsTwo;
    protected $courseOne;
    protected $courseTwo;
    protected $purchaseAttrs;
    protected $payload;

    public function setupData($cardNumber)
    {
        $this->userAttrs = ['email' => 'admin@example.com', 'password' => bcrypt('password')];
        $this->user = User::create($this->userAttrs);
        $this->token = JWTAuth::fromUser($this->user);

        $this->courseAttrsOne = [
            'name'             => 'First Name',
            'price'            => 200,
            'release_date'     => Carbon::now()->subDay(),
            'description'      => 'lorem pixum',
            'is_published'     => true,
            'description_long' => 'Lorem ipsum dolor sit amet',
            'coming_soon'      => false,
        ];

        $this->courseAttrsTwo = [
            'name'             => 'Last Name',
            'price'            => 400,
            'release_date'     => Carbon::now()->subDay(),
            'description'      => 'exej pixum',
            'is_published'     => true,
            'description_long' => 'Foo Bar',
            'coming_soon'      => false,
        ];

        $this->courseOne = Course::create($this->courseAttrsOne);
        $this->courseTwo = Course::create($this->courseAttrsTwo);

        $this->purchaseAttrs = [
            'course_id' => 1,
            'user_id'   => $this->user->id,
        ];

        $token = $this->getTestToken($cardNumber);

        $this->req = [
            'data' => [
                'relationships' => [
                    'course' => ['data' => ['id' => $this->courseOne->slug]],
                ],
                'attributes'    => [
                    'existing' => false,
                    'token'    => $token,
                ]
            ]
        ];
    }

    public function testRequiresAuth()
    {
        $this->call('POST', '/purchase-attempts', [], [], [], $this->bearer($this->invalidToken));

        $this->assertResponseStatus(401);
    }

    public function testNewCoursePurchase()
    {
        $this->setupData($this->validCard);

        $this->json('POST', '/purchase-attempts', $this->req, $this->bearer($this->token));

        $this->assertResponseOk();

        $purchaseCount = Purchase::count();

        $this->assertEquals($purchaseCount, 1, 'There should be one purchase in the system');
    }
    
    protected function getTestToken($cardNumber)
    {
        return Stripe\Token::create([
            'card' => [
                'number'    => $cardNumber,
                'exp_month' => 5,
                'exp_year'  => 2020,
                'cvc'       => '123',
            ],
        ], ['api_key' => env('STRIPE_SECRET')])->id;
    }
}
