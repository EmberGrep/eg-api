<?php

use EmberGrep\Models\User;

class ResetPasswordTest extends AcceptanceTestCase
{
    protected $user;
    protected $passwordToken;

    public function setUp()
    {
        parent::setUp();

        $this->passwordToken = Password::getRepository()->create($this->user);
    }

    public function testRequestValidToken()
    {
        $this->call('POST', "/password-reset/{$this->passwordToken}", [
            'email' => 'admin@example.com',
            'password' => 'foobar',
            'token' => $this->passwordToken,
        ]);

        $passwordChanged = Auth::validate([
            'email' => 'admin@example.com',
            'password' => 'foobar',
        ]);

        $this->assertTrue($passwordChanged);
        $this->assertResponseStatus(204);
    }
}
