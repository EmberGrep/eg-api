<?php namespace EmberGrep\Http\Controllers\Auth;

use EmberGrep\Events\UserRequestPasswordReset;
use EmberGrep\Models\User;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\Request;

use EmberGrep\Http\Controllers\Controller;

class ResetPassword extends Controller
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

    public function store(Request $req, $token)
    {
        $email = $req->get('email');
        $password = $req->get('password');
        $user = $this->user->where('email', $email)->first();

        if (!$user || !$this->token->exists($user, $token)) {
            return $this->notFoundError();
        }
        $this->token->delete($token);
        $user->password = bcrypt($password);
        $user->save();

        return response()->json(null, 204);
    }

    protected function notFoundError()
    {
        return response()->json([
            'status' => 400,
            'message'=> 'The token or email combination was not valid.',
        ], 400);
    }
}
