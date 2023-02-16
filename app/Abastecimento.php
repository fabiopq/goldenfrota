<?php

namespace App;

use App\Bico;
use App\Veiculo;
use App\TanqueMovimentacao;
use App\MovimentacaoCombustivel;
use Illuminate\Database\Eloquent\Model;

class Abastecimento extends Model
{
    public $fillable = [
        'id_automacao',
        'ns_automacao',
        'bico_id',
        'encerrante_inicial',
        'encerrante_final',
        'valor_abastecimento',
        'valor_litro',
        'volume_abastecimento',
        'atendente_id',
        'veiculo_id',
        'km_veiculo',
        'requisicao_abastecimento',
        'data_hora_abastecimento',
        'ativo',
        'abastecimento_local',
        'eh_afericao'
    ];

    public function tanque_movimentacao() {
        return $this->hasOne(TanqueMovimentacao::class);
    }

    public function veiculo() {
        return $this->belongsTo(Veiculo::class);
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function movimentacao_combustivel() {
        return $this->hasOne(MovimentacaoCombustivel::class);
    }

    public function bico() {
        return $this->belongsTo(Bico::class);
    }

    public function scopeUltimoDoVeiculo($query, $veiculo_id, $dataHoraAbastecimentoAtual = false) {
        
        if ($dataHoraAbastecimentoAtual) {
            return $query->where('veiculo_id', $veiculo_id)
                ->where('data_hora_abastecimento', '<', $dataHoraAbastecimentoAtual)
                ->orderBy('data_hora_abastecimento', 'desc')
                ->firstOrFail();    
        } 
        //dd($query);
        return $query->where('veiculo_id', $veiculo_id)
            ->orderBy('data_hora_abastecimento', 'desc')
            ->firstOrFail();
    }

    public function movimentacao_credito() {
        return $this->hasOne(MovimentacaoCredito::class);
    }
}
