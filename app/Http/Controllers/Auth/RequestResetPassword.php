<?php namespace EmberGrep\Http\Controllers\Auth;

use EmberGrep\Events\UserRequestPasswordReset;
use EmberGrep\Models\User;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\Request;

use EmberGrep\Http\Controllers\Controller;

class RequestResetPassword extends Controller
{
    /**
     * @var \Illuminate\Auth\Passwords\TokenRepositoryInterface
     */
    protected $token;
    /**
     * @var \EmberGrep\Models\User
     */
    protected $user;

    public function __construct(PasswordBroker $password, User $user)
    {
        $this->token = $password->getRepository();
        $this->user = $user;
    }

    public function store(Request $req)
    {
        $email = $req->get('email');

        $user = $this->user->where('email', $email)->first();

        if (!$user) {
            return $this->userNotFoundError();
        }

        $token = $this->token->create($user);

        event(new UserRequestPasswordReset($user->email, $token));

        return response()->json([
            'status' => 201,
            'message' => 'Password reset email sent',
        ], 201);
    }

    protected function userNotFoundError()
    {
        return response()->json([
            'status' => 400,
            'message'=> 'No user with that email exists.',
        ], 400);
    }
}
