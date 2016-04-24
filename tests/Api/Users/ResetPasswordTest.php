<?php

use EmberGrep\Models\User;

class ResetPasswordTest extends AcceptanceTestCase
{
    protected $user;
    protected $token;

    public function setup()
    {
        parent::setUp();
        $properties = ['email' => 'admin@example.com', 'password' => bcrypt('password')];
        $this->user = User::create($properties);
        $this->token = Password::getRepository()->create($this->user);
    }

    public function testRequestValidToken()
    {
        $this->call('POST', "/password-reset/{$this->token}", [
            'email' => 'admin@example.com',
            'password' => 'foobar',
            'token' => $this->token,
        ]);

        $passwordChanged = Auth::validate([
            'email' => 'admin@example.com',
            'password' => 'foobar',
        ]);

        $this->assertTrue($passwordChanged);
        $this->assertResponseStatus(204);
    }
}
