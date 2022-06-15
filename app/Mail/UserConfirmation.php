<?php

namespace App\Mail;

use App\Models\User;
use App\Models\verificationToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;

        $this->subject('Your account has been confirmed');
        $this->attach(public_path('img/logoTextWhite2.png'));

        return $this->view('mail.mailConfirmation', compact('user'));
    }
}
