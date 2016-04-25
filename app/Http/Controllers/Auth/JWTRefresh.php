<?php namespace EmberGrep\Http\Controllers\Auth;

use Illuminate\Http\Request;
use EmberGrep\Http\Controllers\Controller;

use Tymon\JWTAuth\JWTAuth;

class JWTRefresh extends Controller
{
    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function store(Request $req)
    {
        $token = $req->json('token');
        $newToken = $this->auth->refresh($token);

        $user = $this->auth->toUser($newToken);

        $token = $this->auth->fromUser($user, $user->toArray());
        \Log::info($user);

        return response()->json(compact('token'));
    }

}
