<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketPrioridade extends Model
{
    protected $table = 'ticket_prioridade';

    protected $fillable = [
        'descricao',
        'ativo'
    ];
}
