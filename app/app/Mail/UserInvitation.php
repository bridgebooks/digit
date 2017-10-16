<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Org;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $msg;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $message, string $url)
    {
        $this->msg = $message;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Collaborate on Bridge Books')
            ->view('emails.users.invitation');
    }
}
