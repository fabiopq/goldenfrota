<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\EnvioPadrao;
use Illuminate\Support\Facades\Log;

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

        // Anexos manuais enviados via formulário
        if ($request->hasFile('anexos')) {
            foreach ($request->file('anexos') as $file) {
                $attachments[] = $file;
            }
        }

        // Anexos do servidor (PDF gerado previamente e salvo em public/storage)
        if ($request->has('anexos_servidor')) {
            
            foreach ($request->input('anexos_servidor') as $relativePath) {
                
                if (!empty($relativePath)) {
                    $fullPath = storage_path('app/public/' . $relativePath);
                     
                    if (file_exists($fullPath)) {
                      //dd($fullPath);  
                        $attachments[] = new \Illuminate\Http\File($fullPath);
                    } else {
                        Log::warning("Arquivo não encontrado para anexo: $fullPath");
                    }
                }
            }
        }

        // Envia o e-mail com os anexos
        Mail::to($request->destinatario)->send(new EnvioPadrao(
            $request->assunto,
            $request->mensagem,
            $attachments
        ));

        return back()->with('success', 'E-mail enviado com sucesso!');
    }
}
