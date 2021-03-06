<?php

namespace App;

use App\Estoque;
use App\Fornecedor;
use App\GrupoProduto;
use App\InventarioItem;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public $fillable = [
        'produto_descricao', 
        'produto_desc_red', 
        'unidade_id', 
        'grupo_produto_id', 
        'valor_custo',
        'valor_venda',
        'vencimento_dias',
        'vencimento_km',
        'vencimento_horas_trabalhadas',
        'controla_vencimento',
        'numero_serie',
        'codigo_barras',
        'ativo'
    ];

    public function fornecedores() {
        return $this->belongsToMany(Fornecedor::class);
    }

    public function estoques() {
        return $this->belongsToMany(Estoque::class)->withPivot('estoque_minimo');
    }

    public function inventario_item() {
        return $this->belongsTo(InventarioItem::class);
    }

    public function movimentacao_produto() {
        return $this->hasMany(MovimentacaoProduto::class);
    }

    public function grupo_produto() {
        return $this->belongsTo(GrupoProduto::class);
    }

    public function scopeAtivo($query, $ativo = true) {
        return $query->where('ativo', $ativo);
    }
}
