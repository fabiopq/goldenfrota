<?php

namespace App;

use App\Bico;
use App\Combustivel;
use App\Abastecimento;
use App\MovimentacaoCombustivel;
use Illuminate\Database\Eloquent\Model;

class Tanque extends Model
{
    public $fillable = ['num_tanque','posto_abastecimento_id','descricao_tanque', 'capacidade', 'combustivel_id', 'ativo'];


    public function combustivel() {
        return $this->belongsTo(Combustivel::class);
    }

    public function bicos() {
        return $this->hasMany(Bico::class);
    }

    public function movimentacao_combustieveis() {
        return $this->hasMany(MovimentacaoCombustivel::class);
    }

    public function abastecimentos(){
        return $this->hasMany(Abastecimento::class);        
    }

    public function scopeAtivo($query) {
        return $query->where('ativo', true);
    }
}
