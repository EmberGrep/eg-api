<?php  namespace EmberGrep\Events;

use EmberGrep\Events\Event;

class UserRequestPasswordReset extends Event
{
    /**
     * @var
     */
    public $email;

    /**
     * @var
     */
    public $token;

    public function __construct($email, $token)
    {

        $this->email = $email;
        $this->token = $token;
    }
}
