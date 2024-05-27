<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\Types\This;
use stdClass;

class newEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $contato;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(stdClass $contato )
    {
        $this->$contato = $contato;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject($this->$contato->assunto);
        $this->to('goldenservicenet@gmail.com','Golden');
        
        return $this->markdown('mail.new_email');
    }
}
