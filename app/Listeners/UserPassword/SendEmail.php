<?php

namespace EmberGrep\Listeners\UserPassword;

use EmberGrep\Events\UserRequestPasswordReset;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @param \Illuminate\Contracts\Mail\Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  UserRequestPasswordReset  $event
     * @return void
     */
    public function handle(UserRequestPasswordReset $event)
    {
        $title = 'Your password reset';

        $this->mailer->send('emails.reset-password', ['title' => $title, 'token' => $event->token], function($m) use ($event, $title) {
            $m->to($event->email)->subject($title);
        });
    }
}
