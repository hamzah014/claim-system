<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClaimApprovalPending extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $detail;
    public $subject;

    public function __construct($data,$detail,$subject)
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
        $staff_name     = $this->data['staff_name'];
        $approver_name  = $this->data['approver_name'];
        $submit_date    = $this->data['submit_date'];
        $duty_date      = $this->data['duty_date'];
        $total_amount   = $this->data['total_amount'];
        $claim_link     = $this->data['claim_link'];
        
        return $this->from($address = $this->detail['sender_email'], $name = $this->detail['app_name'])
                    ->subject($this->subject)->view('mail.claimApprovalPending')
                    ->with([
                    'staff_name'         => $staff_name,
                    'approver_name'         => $approver_name,
                    'submit_date'         => $submit_date,
                    'duty_date'         => $duty_date,
                    'total_amount'         => $total_amount,
                    'claim_link'         => $claim_link,
                ]);
    }
}