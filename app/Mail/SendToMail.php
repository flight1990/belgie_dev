<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendToMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $email;
    public string $message;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,  $subject, $message)
    {
        $this->email = $email;
        $this->message = $message;
        $this->subject = $subject;
    }

    public function build(): SendToMail
    {
        $data =[
            'message'=>$this->message,
            'email'=>$this->email,
            'subject'=>$this->subject,
        ];

       return $this->markdown('mail.mail')->with($data)->subject($this->subject);
    }
}
