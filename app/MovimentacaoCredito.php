<?php

namespace App;

use App\Produto;
use App\TipoMovimentacaoProduto;
use App\Veiculo;
use App\Cliente;
use Illuminate\Database\Eloquent\Model;

class MovimentacaoCredito extends Model
{
    //protected $table = 'movimentacao_creditos';
    public $fillable = [
        'id',
        'data_movimentacao',
        'cliente_id',
        'combustivel_id',
        'tipo_movimentacao_produto_id',
        'quantidade_movimentada',
        'valor_unitario',
        'valor',
        'observacao',

    ];

    
    public function tipo_movimentacao_produto() {
        return $this->belongsTo(TipoMovimentacaoProduto::class);
    }

    public function produto() {
        return $this->belongsTo(Produto::class);
    }

    public function veiculo() {
        return $this->belongsTo(Veiculo::class);
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }


    
}
