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
        $this->call('POST', '/register', ['username' => 'admin@example.com', 'password' => 'password']);

        $this->assertResponseOk();

        $token = $this->decodeResponseJson()['token'];
        $user = User::first();
        $tokenUser = JWTAuth::toUser($token);

        $this->assertEquals($tokenUser->id, $user->id);
    }
}
