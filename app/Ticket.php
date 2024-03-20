<?php

namespace App;

use App\User;
use App\TicketStatus;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'cliente_id',
        'cliente_nome',
        'data_abertura',
        'data_ultima_alteracao',
        'atendente_atribuido_id',
        'user_id',
        'titulo',
        'ticket_status_id',
        'ticket_prioridade_id',
        'problema',
        'solucao',
        'ticket_grupo_id',
        

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
