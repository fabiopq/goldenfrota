<?php

namespace App;

use App\Veiculo;
use App\MarcaVeiculo;
use App\TipoControleVeiculo;
use Illuminate\Database\Eloquent\Model;

class ModeloVeiculo extends Model
{
    public $fillable = [
        'modelo_veiculo',
        'marca_veiculo_id',
        'tipo_controle_veiculo_id',
        'capacidade_tanque',
        'ativo',
        'tipo_controle_bloqueio',
        'media_ideal',
        'variacao_negativa',
        'variacao_positiva'
    ];

    public function marca_veiculo()
    {
        return $this->belongsTo(MarcaVeiculo::class);
    }

    public function veiculos()
    {
        return $this->hasMany(Veiculo::class);
    }

    public function tipo_controle_veiculo()
    {
        return $this->belongsTo(TipoControleVeiculo::class);
    }

    public function controlePorKmRodados()
    {
        return $this->tipo_controle_veiculo_id == 1;
    }

    public function scopeAtivo($query, $ativo = true)
    {
        return $query->where('ativo', $ativo);
    }
}
