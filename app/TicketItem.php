<?php

namespace App;

use App\Ticket;
use Illuminate\Database\Eloquent\Model;

class TicketItem extends Model
{
    protected $table = 'ticket_item';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'resposta',
        'data',

    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
