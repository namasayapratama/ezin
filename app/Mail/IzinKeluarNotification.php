<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IzinKeluarNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $izin;

    public function __construct($izin)
    {
        $this->izin = $izin;
    }

    public function build()
    {
        return $this->subject('Konfirmasi Izin Keluar')
            ->view('emails.izin-keluar');
    }
}
