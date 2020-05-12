<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaHabilitacao extends Model
{
    public $fillable = ['categoria_habilitacao'];

    public function clientes() {
        return $this->hasMany(Motorista::class);
    }
}

