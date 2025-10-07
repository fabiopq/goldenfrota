<?php

namespace App;

use App\Tanque;
use Illuminate\Database\Eloquent\Model;

class Bico extends Model
{
    public $fillable = [
        'num_bico', 'tanque_id', 'bomba_id', 'encerrante',
        'permite_insercao', 'endereco', 'ativo','ppl','com_defeito'
    ];

    public function tanque()
    {
        return $this->belongsTo(Tanque::class);
    }
}
