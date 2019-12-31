<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FactuurMail extends Mailable
{
    use Queueable, SerializesModels;
    public $naam;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($naam)
    {
        $this->naam = $naam;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('boekhouding.brief')->attach('temp/testpdf.pdf');
    }
}
