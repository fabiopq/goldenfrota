<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VeiculoStatus extends Model
{
    protected $table = 'veiculo_status';
    public $fillable = ['veiculo_id', 'status_id', 'data', 'historico', 'ativo'];

}


