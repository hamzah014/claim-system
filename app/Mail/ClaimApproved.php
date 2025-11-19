<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClaimApproved extends Mailable
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

    public function build()
    {
        
        return $this->from($this->detail['sender_email'], $this->detail['app_name'])
                    ->subject($this->subject)
                    ->view('mail.claimApproved')
                    ->with([
                        'duty_date'     => $this->data['duty_date'],
                        'staff_name'   => $this->data['staff_name'],
                        'claim_refno' => $this->data['claim_refno'],
                        'approver_name' => $this->data['approver_name'],
                        'approve_remark' => $this->data['approve_remark'],
                        'claim_link'    => $this->data['claim_link'],
                    ]);
    }

}