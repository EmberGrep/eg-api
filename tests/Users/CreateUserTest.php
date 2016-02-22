<?php

use EmberGrep\Models\User;

class CreateUserTest extends AcceptanceTestCase
{
    public function testCreateNewUser()
    {
        $this->call('POST', '/register', ['username' => 'admin@example.com', 'password' => 'password', 'password_confirmation' => 'password']);

        $this->assertResponseOk();

        $token = $this->decodeResponseJson()['token'];
        $user = User::first();
        $tokenUser = JWTAuth::toUser($token);

        $this->assertEquals($tokenUser->id, $user->id);
    }

    public function testCannotCreateExistingUser()
    {
        $properties = ['email' => 'admin@example.com', 'password' => bcrypt('password')];
        User::create($properties);

        $this->call('POST', '/register', ['username' => 'admin@example.com', 'password' => 'password', 'password_confirmation' => 'password']);

        $this->assertResponseStatus(400);

        $this->seeJson([
            'errors' => [
                [
                  'status' => '400',
                  'title' => 'Invalid Attribute',
                  'detail' => 'The email has already been taken.',
                ],
            ],
        ]);
    }

    public function testCannotCreateUnconfirmedPassword()
    {
        $this->call('POST', '/register', ['username' => 'admin@example.com', 'password' => 'password', 'password_confirmation' => 'passwordFoo']);

        $this->assertResponseStatus(400);

        $this->seeJson([
            'errors' => [
                [
                  'status' => '400',
                  'title' => 'Invalid Attribute',
                  'detail' => 'The password confirmation does not match.',
                ],
            ],
        ]);
    }
}
