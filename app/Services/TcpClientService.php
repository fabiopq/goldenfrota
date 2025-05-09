<?php
// app/Services/TcpClientService.php
namespace App\Services;

class TcpClientService
{
    protected $ip;
    protected $port;

    public function __construct($ip, $port)
    {
        $this->ip = $ip;
        $this->port = $port;
    }

    public function sendAndReceive(string $message): ?string
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$socket) {
            throw new \Exception("Não foi possível criar o socket.");
        }

        $connection = socket_connect($socket, $this->ip, $this->port);
        if (!$connection) {
            throw new \Exception("Não foi possível conectar ao hardware.");
        }

        socket_write($socket, $message, strlen($message));
        $response = socket_read($socket, 2048);

        socket_close($socket);

        return $response;
    }
}
