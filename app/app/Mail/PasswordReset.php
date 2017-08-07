<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordReset extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $token;
    protected $user;
    protected $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, String $token)
    {
        $this->user = $user;
        $this->token = $token;
        $this->url = config('auth.reset_url') . '?token=' . $this->token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reset your password')
            ->view('emails.auth.password-reset')
            ->with([
                'user' => $this->user,
                'url' => $this->url
            ]);
    }
}
