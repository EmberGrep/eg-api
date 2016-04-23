<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;

abstract class AcceptanceTestCase extends TestCase
{
    use DatabaseMigrations;

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
}
