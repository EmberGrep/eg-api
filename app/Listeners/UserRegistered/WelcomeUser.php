<?php

namespace EmberGrep\Listeners\UserRegistered;

use EmberGrep\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Contracts\Mail\Mailer;

class WelcomeUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $this->mailer->send('emails.welcome', [], function($m) use ($event) {
            $m->to($event->user->email)->subject('Welcome to EmberGrep.com');
        });
    }
}
