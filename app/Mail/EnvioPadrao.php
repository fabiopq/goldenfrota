<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;

class EnvioPadrao extends Mailable
{
    use Queueable, SerializesModels;

    public $assunto;
    public $mensagemTexto;
    public $anexos;

    public function __construct($assunto, $mensagemTexto, $anexos = [])
    {
        $this->assunto = $assunto;
        $this->mensagemTexto = $mensagemTexto;
        $this->anexos = $anexos;
    }

    public function build()
    {
        $email = $this->subject($this->assunto)
            ->view('email.template-padrao')
            ->with(['mensagemTexto' => $this->mensagemTexto]);

        foreach ($this->anexos as $anexo) {
            if ($anexo instanceof UploadedFile) {
                $email->attach($anexo->getRealPath(), [
                    'as' => $anexo->getClientOriginalName(),
                    'mime' => $anexo->getClientMimeType(),
                ]);
            } elseif ($anexo instanceof File) {
                $email->attach($anexo->getRealPath(), [
                    'as' => basename($anexo->getPathname()),
                    'mime' => mime_content_type($anexo->getPathname()),
                ]);
            }
        }

        return $email;
    }
}
