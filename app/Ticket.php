<?php

namespace App;

use App\User;
use App\TicketStatus;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'cliente_id',
        'user_id',
        'titulo',
        'data_abertura',
        'data_fechamento',
        'ticket_status_id',
        'ticket_prioridade_id',

    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function ticket_status()
    {
        return $this->belongsTo(TicketStatus::class);
    }
}
