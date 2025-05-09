<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\EnvioPadrao;

class EmailController extends Controller
{
    public function enviar(Request $request)
    {
        $request->validate([
            'destinatario' => 'required|email',
            'assunto' => 'required|string',
            'mensagem' => 'required|string',
            'anexos.*' => 'file|max:5120', // Máx. 5MB por arquivo
        ]);

        $attachments = [];
        if ($request->hasFile('anexos')) {
            foreach ($request->file('anexos') as $file) {
                $attachments[] = $file;
            }
        }

        Mail::to($request->destinatario)->send(new EnvioPadrao(
            $request->assunto,
            $request->mensagem,
            $attachments
        ));

        return back()->with('success', 'E-mail enviado com sucesso!');
    }
}
