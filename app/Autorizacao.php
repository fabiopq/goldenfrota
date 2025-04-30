<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autorizacao extends Model
{
    protected $table = 'autorizacoes';
  
    public $fillable = [
        'bico_id',
        'endereco',
        'veiculo_id',
        ''
        
    ];
}
