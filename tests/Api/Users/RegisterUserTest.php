<?php

use EmberGrep\Models\User;

class RegisterUserTest extends AcceptanceTestCase
{
    public function testRegisterUser()
    {
        $this->expectsEvents(EmberGrep\Events\UserRegistered::class);

        $this->call('POST', '/register', [
            'username' => 'admin@example.com',
            'password' => 'password',
            'user_data' => '{"password_confirmation": "password"}',
        ]);

        $this->assertResponseOk();

        $userCount = User::count();

        $this->assertEquals($userCount, 1, 'There should be one user in the system');
    }
}
