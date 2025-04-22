<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrecoCliente extends Model
{
    public $fillable = [
        'id',
        'cliente_id',
        'obs_preco',
        'ativo'



    ];

    public function preco_cliente_items() {
        return $this->hasMany(PrecoClienteItem::class);
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    
}
