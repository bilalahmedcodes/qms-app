<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CriticalAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $voice_audit;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($voice_audit)
    {
        $this->voice_audit = $voice_audit;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('QA Escalation Alert')->view('vendor.mail.critical-alert');
    }
}
