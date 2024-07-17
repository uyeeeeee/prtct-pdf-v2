<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormattedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $bodyContent;
    public $pdfs;

    public function __construct($subject, $bodyContent, $pdfs)
    {
        $this->subject = $subject;
        $this->bodyContent = $bodyContent;
        $this->pdfs = $pdfs;
    }

    public function build()
    {
        $mail = $this->subject($this->subject)
                     ->view('emails.formatted')
                     ->with(['bodyContent' => $this->bodyContent]);

        foreach ($this->pdfs as $pdf) {
            $mail->attach($pdf->getRealPath(), [
                'as' => $pdf->getClientOriginalName(),
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}