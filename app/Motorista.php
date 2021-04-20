<?php

namespace App;
use App\Veiculo;

use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    public $fillable = [
        'id',
        'nome',
        'nome',
        'cpf',
        'rg',
        'habilitacao',
        'categoria',
        'data_validade_habilitacao',
        'pontos_habilitacao',
        'observacoes',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'uf_id',
        'cep',
        'fone',
        'email',
        'data_nascimento',
        'data_admissao',
        'estado_civil',
        'tipo_sanquineo',
        'veiculo_id',
        'ativo',
        'tag'
    ];

    public function veiculos() {
        return $this->hasMany(Veiculo::class);
    }

    public function uf() {
        return $this->belongsTo(Uf::class);
    }

}
