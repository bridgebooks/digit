<?php

namespace App\Listeners;

use Mail;
use App\Events\UserInvited;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\UserInvitation;

class UserInvitedListener implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserInvited  $event
     * @return void
     */
    public function handle(UserInvited $event)
    {
        $message = $event->params['message'];
        $baseUrl = config('app.validate_account_url') .'/%s?token=%s&invited=%s&org=%s';
        $url = sprintf($baseUrl, $event->user->id, $event->user->getVerificationToken(), 'true', $event->params['org']->id);

        $mail = new UserInvitation($message, $url);

        Mail::to($event->user->email)->send($mail);
    }
}
