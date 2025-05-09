<?php
// app/Http/Controllers/HardwareController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TcpClientService;

class HardwareController extends Controller
{
    public function communicate(Request $request)
    {
        $ip = '192.168.3.126';  // Substitua pelo IP do hardware
        $port = 1771;          // Substitua pela porta correta

        $tcp = new TcpClientService($ip, $port);

        try {
            $resposta = $tcp->sendAndReceive("(a)");
        } catch (\Exception $e) {
            $resposta = "Erro: " . $e->getMessage();
        }

        return view('hardware.resposta', compact('resposta'));
    }
}