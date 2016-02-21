<?php

use EmberGrep\Models\User;

class CreateUserTest extends AcceptanceTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->call('POST', '/register', ['username' => 'admin@example.com', 'password' => 'password', 'password_confirmation' => 'password']);

        Log::info($this->response->getContent());
        $this->assertResponseOk();

        $token = $this->decodeResponseJson()['token'];
        $user = User::first();
        $tokenUser = JWTAuth::toUser($token);

        $this->assertEquals($tokenUser->id, $user->id);
    }
}
