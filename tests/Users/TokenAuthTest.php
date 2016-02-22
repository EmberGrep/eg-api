<?php

use EmberGrep\Models\User;

class TokenAuthTest extends AcceptanceTestCase
{
    public function testCreateNewUser()
    {
        $properties = ['email' => 'admin@example.com', 'password' => bcrypt('password')];
        User::create($properties);

        $this->call('POST', '/auth-token', ['username' => 'admin@example.com', 'password' => 'password']);

        $this->assertResponseOk();

        return Log::info($this->response->getContent());

        $token = $this->decodeResponseJson()['token'];
        $user = User::first();
        $tokenUser = JWTAuth::toUser($token);

        $this->assertEquals($tokenUser->id, $user->id);
    }

    public function testInvalidUsername()
    {
        $properties = ['email' => 'admin@example.com', 'password' => bcrypt('password')];
        User::create($properties);

        $this->call('POST', '/auth-token', ['username' => 'notuser@example.com', 'password' => 'password', 'password_confirmation' => 'password']);

        $this->assertResponseStatus(400);

        $this->seeJson([
            'code' => '400',
            'error' => 'invalid_credentials',
            'error_description' => 'User credentials are invalid'
        ]);
    }
}
