<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubmissionConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $detail;
    public $subject;

    public function __construct($data,$detail,$subject)
    {
        //
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
        $duty_date = $this->data['duty_date'];
        $staff_name = $this->data['staff_name'];
        $claim_referenceNo = $this->data['claim_referenceNo'];
        $claim_type = $this->data['claim_type'];
        $claim_link = $this->data['claim_link'];
        
        return $this->from($address = $this->detail['sender_email'], $name = $this->detail['app_name'])
                    ->subject($this->subject)->view('mail.submissionConfirmed')
                    ->with([
                    'duty_date'         => $duty_date,
                    'staff_name'        => $staff_name,
                    'claim_referenceNo' => $claim_referenceNo,
                    'claim_type'        => $claim_type,
                    'claim_link'        => $claim_link,
                ]);
    }

}