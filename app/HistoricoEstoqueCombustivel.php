<?php

namespace App;

use App\Tanque;
use App\Combustivel;
use Illuminate\Database\Eloquent\Model;

class HistoricoEstoqueCombustivel extends Model
{
    protected $table = 'historico_Estoque_combustivel';

    protected $fillable = [
        'tanque_id',
        'combustivel_id',
        'quantidade',
        'data'

    ];

    public function tanque()
    {
        return $this->belongsTo(Tanque::class);
    }

    public function combustivel()
    {
        return $this->belongsTo(Combustivel::class);
    }
}
