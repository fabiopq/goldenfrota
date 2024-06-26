<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atendente extends Model
{
    public $fillable = ['id','nome_atendente', 'usuario_atendente', 'senha_atendente', 'veiculo_id','ativo','senha_atendente_app'];
    
    public function veiculos() {
        return $this->hasMany(Veiculo::class);
    }
}
