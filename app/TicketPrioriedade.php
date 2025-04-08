<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketPrioriedade extends Model
{
    protected $table = 'ticket_prioridade';

    protected $fillable = [
        'descricao',
        'ativo'
    ];
}
