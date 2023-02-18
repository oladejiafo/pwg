<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyMail extends Mailable
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
      if($this->mailData['status'] == "payment"){
        return $this->view('emails.payment-success')->subject($title)->with(['data' => $this->mailData]);
      } else if($this->mailData['status'] == "application"){
        return $this->view('emails.application-submitted')->subject($title)->with(['data' => $this->mailData]);
      } else if($this->mailData['status'] == "reminder") {
        return $this->view('emails.Reminder-template')->subject($title)->with(['data' => $this->mailData]);
      } else if($this->mailData['status'] == "workpermit") {
        return $this->view('emails.workpermit-template')->subject($title)->with(['data' => $this->mailData]);
      } else {
        $body = $this->mailData['body'];
        return $this->view('emails.notify')->subject($title)->with(['data' => $this->mailData]);
      }
    }
}
