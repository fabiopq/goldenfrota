<?php

namespace App;

use App\Cliente;
use App\Departamento;
use App\GrupoVeiculo;
use App\OrdemServico;
use App\Abastecimento;
use App\ModeloVeiculo;
use App\VencimentoProduto;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    public $fillable = ['id','placa', 'tag', 'grupo_veiculo_id', 'cliente_id', 'departamento_id', 'modelo_id', 'ano', 'renavam', 'chassi', 'hodometro', 'media_minima', 'hodometro_decimal','ativo'];

    public function abastecimentos() {
        return $this->hasMany(Abastecimento::class)->orderBy('data_hora_abastecimento', 'asc');
    }

    public function modelo_veiculo() {
        return $this->belongsTo(ModeloVeiculo::class);
    }

    public function grupo_veiculo() {
        return $this->belongsTo(GrupoVeiculo::class);
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function departamento() {
        return $this->belongsTo(Departamento::class);
    }

    public function ordem_servicos() {
        return $this->hasMany(OrdemServico::class);
    }

    public function vencimento_produtos() {
        return $this->hasMany(VencimentoProduto::class);
    }

    public function scopeAtivo($query, $ativo = true) {
        return $query->where('ativo', $ativo);
    }
}
