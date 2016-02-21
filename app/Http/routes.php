<?php

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use EmberGrep\Models\User;

$router->post('/register', function (Request $req) {
    $user = User::create(['email' => $req->get('username'), 'password' => $req->get('password')]);

    $token = JWTAuth::fromUser($user);

    return new JsonResponse(['token' => $token]);
});
