<?php

namespace App;

use App\PrecoCliente;
use Illuminate\Database\Eloquent\Model;

class PrecoClienteItem extends Model
{
    protected $fillable = [
        'id',
        'preco_cliente_id',
        'combustivel_id',
        'valor_unitario',
        'valor_acrescimo',
        'perc_desconto',
        'perc_acrescimo',
    ];

    public function preco_cliente() {
        return $this->belongsTo(PrecoCliente::class);
    }

    public function combustivel() {
        return $this->belongsTo(Combustivel::class);
    }
    public function precoCliente()
    {
        return $this->belongsTo(PrecoCliente::class);
    }
    
}
