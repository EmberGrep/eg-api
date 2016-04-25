<?php namespace EmberGrep\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use EmberGrep\Http\Controllers\Controller;
use EmberGrep\Models\User;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Auth\AuthManager;

class JWTToken extends Controller
{
    public function __construct(AuthManager $guard, JWTAuth $auth)
    {
        $this->guard = $guard;
        $this->auth = $auth;
    }

    public function store(Request $req)
    {
        $credentials = [
            'email' => $req->get('username'),
            'password' => $req->get('password'),
        ];

        if($this->guard->attempt($credentials)) {
            $user = $this->guard->user();

            $token = $this->auth->fromUser($user, $user->toArray());

            return new JsonResponse(['token' => $token]);
        }

        return new JsonResponse([
            'code' => '400',
            'error' => 'invalid_credentials',
            'error_description' => 'User credentials are invalid'
        ], 400);
    }

}
