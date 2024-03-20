<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostoAbastecimento extends Model
{
    public $fillable = [
        'id',
        'nome',
        'ftp_server',
        'ftp_user',
        'ftp_pass',
        'ftp_port',
        'ftp_root',
        'ftp_passive',
        'ftp_ssl',
        'ftp_timeout',
        'automacao_valor_combustivel',
        
    ];
}
