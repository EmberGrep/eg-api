<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AcceptanceTestCase extends TestCase
{
    use DatabaseMigrations;

    protected function jwtForUser($user)
    {
        return JWTAuth::fromUser($user);
    }
}
