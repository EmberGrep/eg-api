<?php namespace EmberGrep\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use EmberGrep\Http\Controllers\Controller;
use EmberGrep\Models\User;

use Tymon\JWTAuth\JWTAuth;

use Illuminate\Validation\ValidationException;

class Register extends Controller
{
    protected $rules = [
        'email' => 'required|unique:users|email',
        'password' => 'required|min:5|confirmed',
    ];

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function store(Request $req)
    {
        $userData = json_decode($req->get('user_data'));
        $credentials = [
            'email' => $req->get('username'),
            'password' => $req->get('password'),
            'password_confirmation' => isset $userData['password_confirmation'] ? $userData['password_confirmation'] : '',
        ];

        $this->validateAttributes($credentials, $this->rules);

        $user = User::create($credentials);

        $token = $this->auth->fromUser($user);

        return new JsonResponse(['token' => $token]);
    }

    protected function validateAttributes(array $attrs, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = app('validator')->make($attrs, $rules, $messages, $customAttributes);


        if ($validator->fails()) {
            $this->throwValidationException($validator);
        }
    }

}
