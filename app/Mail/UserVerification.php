<?php

namespace App\Mail;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use App\Models\verificationToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserVerification extends Mailable
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

        $mail = VerificationToken::create([
            'user_id' => $user->id,
            'token' => base64_encode($user->id . '+' . (time() + 3600)),
            ]
        );

        $this->subject('Confirm your account');
        $this->attach(public_path('img/logoTextWhite2.png'));

        return $this->view('mail.mailVerification', compact('user', 'mail'));
    }
}
