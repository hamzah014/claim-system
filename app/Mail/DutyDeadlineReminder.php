<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DutyDeadlineReminder extends Mailable
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
        // this email send for claim that have been on draft and the duty date is nearly expired
        return $this->from($this->detail['sender_email'], $this->detail['app_name'])
            ->subject($this->subject)
            ->view('mail.dutyDeadlineReminder')
            ->with([
                'staff_name'    => $this->data['staff_name'],
                'allow_days'   => $this->data['allow_days'],
                'duty_date'      => $this->data['duty_date'],
                'expired_date'      => $this->data['expired_date'],
                'claim_link'    => $this->data['claim_link'],
            ]);
    }
}