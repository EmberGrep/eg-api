<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use EmberGrep\Models\User;

abstract class AcceptanceTestCase extends TestCase
{
    use DatabaseMigrations;
    protected $invalidToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvYXV0aC10b2tlbiIsImlhdCI6MTQ1OTQ0NTQ3MiwiZXhwIjoxNDU5NDQ5MDcyLCJuYmYiOjE0NTk0NDU0NzIsImp0aSI6IjUwZGQwNWE3ZTdmZjhkNjY5MTM5NGUwODU4NTQzOTYwIn0.Gsl3eOgDQa_WlRbRt2ZgJGxqZOkhkaNXk2dEzcOV-fk";
    protected $userAttrs;
    protected $user;
    protected $token;
    protected $loginUser = true;

    protected function jwtForUser($user)
    {
        return JWTAuth::fromUser($user);
    }

    protected function bearer($token)
    {
        return $this->transformHeadersToServerVars(['Authorization' => "Bearer {$token}"]);
    }

    protected function getFiredEventInstance($className)
    {
        $needle = $className;
        $haystack = new Collection($this->firedEvents);

        return $haystack->first(function($index, $event) use ($needle) {
            return $event instanceof $needle;
        });
    }

    protected function setUp()
    {
        parent::setUp();

        if ($this->loginUser) {
            $this->userAttrs = ['email' => 'admin@example.com', 'password' => bcrypt('password')];
            $this->user = User::create($this->userAttrs);
            $this->token = JWTAuth::fromUser($this->user);
        }
    }
}
