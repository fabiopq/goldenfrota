<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMovimentacaoCredito extends Model
{
    protected $table = 'tipo_movimentacao_credito';

    protected $fillable = [
        'tipo_movimentacao_credito'
    ];
}
