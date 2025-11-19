<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubmissionDeadlineReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $detail;
    public $subject;

    public function __construct($data, $detail, $subject)
    {
        $this->data = $data;
        $this->detail = $detail;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->detail['sender_email'], $this->detail['app_name'])
            ->subject($this->subject)
            ->view('mail.submissionDeadlineReminder')
            ->with([
                'staff_name'    => $this->data['staff_name'],
                'date_salary'   => $this->data['date_salary'],
                'dateline'      => $this->data['dateline'],
                'claim_link'    => $this->data['claim_link'],
            ]);
    }
    
}