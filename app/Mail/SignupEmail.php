<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignupEmail extends Mailable
{
  
    
    use Queueable, SerializesModels;
    
    /**
    * Create a new message instance.
    *
    * @return void
    */
    public function __construct($data)
    {
      $this->email=$data;
    }
    
    /**
    * Build the message.
    *
    * @return $this
    */
    public function build()
    {
        return $this->from('artnepal9@gmail.com','CubeHall')->subject('New Profile Created')
        ->view('mail.signup_email',['email_data'=>$this->email]);
    }
    
}