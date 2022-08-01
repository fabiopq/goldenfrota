<?php

namespace App;

use App\Uf;
use App\Veiculo;
use App\Parametro;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public $fillable = [
        'nome_razao', 
        'fantasia', 
        'cpf_cnpj', 
        'rg_ie', 
        'tipo_pessoa_id', 
        'fone1', 
        'fone2', 
        'email1', 
        'email2',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'uf_id',
        'cep',
        'site',
        'ativo'
    ];

    public function uf() {
        return $this->belongsTo(Uf::class);
    }

    public function departamentos() {
        return $this->hasMany(Departamento::class);
    }

    public function veiculos() {
        return $this->hasMany(Veiculo::class);
    }

    public function scopeAtivo($query, $ativo = true) {
        return $query->where('ativo', $ativo);
    }

    /* public function parametro() {
        return $this->belongsTo(Parametro::class);
    } */
 }
