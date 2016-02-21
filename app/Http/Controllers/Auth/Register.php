<?php namespace EmberGrep\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use EmberGrep\Http\Controllers\Controller;
use EmberGrep\Models\User;

use Tymon\JWTAuth\JWTAuth;

class Register extends Controller
{
    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function store(Request $req)
    {
        $user = User::create(['email' => $req->get('username'), 'password' => $req->get('password')]);

        $token = $this->auth->fromUser($user);

        return new JsonResponse(['token' => $token]);
    }

}
