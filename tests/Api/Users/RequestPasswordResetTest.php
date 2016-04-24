<?php

use EmberGrep\Models\User;

class RequestPasswordResetTest extends AcceptanceTestCase
{
    protected $user;

    public function setup()
    {
        parent::setUp();
        $properties = ['email' => 'admin@example.com', 'password' => bcrypt('password')];
        $this->user = User::create($properties);
    }

    public function testRequestExistingUser()
    {
        $this->expectsEvents(EmberGrep\Events\UserRequestPasswordReset::class);

        $this->call('POST', '/password-reset', [
            'email' => 'admin@example.com',
        ]);

        $resetEvent = $this->getFiredEventInstance(EmberGrep\Events\UserRequestPasswordReset::class);

        $this->assertResponseStatus(201);

        $this->assertEquals($resetEvent->email, $this->user->email, 'The email should be sent to the correct user');
        $this->assertTrue(Password::getRepository()->exists($this->user, $resetEvent->token));
    }
}
