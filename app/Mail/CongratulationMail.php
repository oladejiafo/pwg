<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CongratulationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($formData)
    {
        $this->mailData = $formData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        $title = $this->mailData['title'];
        return $this->view('emails.partner-congratulation')->subject($title)->with(['data' => $this->mailData]);
    }
}