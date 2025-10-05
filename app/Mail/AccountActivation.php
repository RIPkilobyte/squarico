<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountActivation extends Mailable
{
    use Queueable, SerializesModels;
    protected $username;
    protected $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->username.', your account activation link')
            ->markdown('emails.account_activation',[
                'username' => $this->username,
                'password' => $this->password,
            ]);
    }
}
