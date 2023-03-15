<?php

namespace App\Http\Controllers;

use App\Bico;
use App\Tanque;
use App\Afericao;
use App\AjusteTanque;
use App\Abastecimento;
use App\EntradaTanque;
use Illuminate\Http\Request;
use App\MovimentacaoCombustivel;
use Illuminate\Support\Facades\DB;

class MovimentacaoCombustivelController extends Controller
{
    static public function entradaTanque(EntradaTanque $entradaTanque)
    {
        try {
            foreach ($entradaTanque->entrada_tanque_items as $item) {
                $entradaTanque->movimentacao_combustivel()->create([
                    'tanque_id' => $item->tanque_id,
                    'tipo_movimentacao_combustivel_id' => 1,  /* Entrada */
                    'quantidade' => $item->quantidade,
                    'entrada_tanque_id' => $entradaTanque->id
                ]);
            }

            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    static public function saidaAbastecimento(Abastecimento $abastecimento)
    {
       
       //dd($abastecimento);
        try {
            $bico = Bico::select('tanque_id')
                ->where('id', $abastecimento->bico_id)
                ->first();

            $abastecimento->movimentacao_combustivel()->create([
                'tanque_id' => $bico->tanque_id,
                'tipo_movimentacao_combustivel_id' => '2', /* Abastecimento */
                'quantidade' => $abastecimento->volume_abastecimento,
                'abastecimento_id' => $abastecimento->id
            ]);

            return true;
        } catch (\Exception $e) {
            dd($e);
            throw new \Exception($e);
        }
    }

    static public function ajustarSaldoTanque(AjusteTanque $ajusteTanque)
    {
        try {
            /* 
                5: Entrada - Ajuste
                6: Saida - Ajuste
            */
            $tipoMovimentacao = ($ajusteTanque->quantidade_ajuste > 0) ? 5 : 6;
            $volumeAjustado = ($ajusteTanque->quantidade_ajuste > 0) ? $ajusteTanque->quantidade_ajuste : ($ajusteTanque->quantidade_ajuste * -1);

            $ajusteTanque->movimentacao_combustivel()->create([
                'tanque_id' => $ajusteTanque->tanque_id,
                'tipo_movimentacao_combustivel_id' => $tipoMovimentacao,
                'quantidade' => $volumeAjustado
            ]);

            return true;
        } catch (\Exception $e) {
            throw new \Exception('Erro ao ajustar tanque: ' . $e->getMessage());
        }
    }

    static public function converterAbastecimentoEmAfericao(Afericao $afericao)
    {
        try {
            $abastecimento = $afericao->abastecimento()->first();
            $movimentacao = $abastecimento->movimentacao_combustivel()->first();

            $movimentacao->abastecimento_id = null;
            $movimentacao->afericao_id = $afericao->id;
            $movimentacao->tipo_movimentacao_combustivel_id = 4; /* saída aferição */


            return $movimentacao->save();

            return true;
        } catch (\Exception $e) {
            throw new \Exception('Erro ao informar movimentacao de saída por aferição para o Abastecimento: ' . $abastecimento->id);
        }
    }

    static public function entradaAfericao(Afericao $afericao)
    {
        try {

            $afericao->movimentacao_combustivel()->create([
                'tanque_id' => $afericao->abastecimento()->first()->bico()->first()->tanque_id,
                'tipo_movimentacao_combustivel_id' => '3', /* entrada afericao */
                'quantidade' => $afericao->abastecimento()->first()->volume_abastecimento,
                'afericao_id' => $afericao->id
            ]);

            return true;
        } catch (\Exception $e) {
            throw new \Exception('Erro ao incluir movimentacao de entrada por aferição para o Abastecimento: ' . $abastecimento->id);
        }
    }

    static public function saidaAfericao(Afericao $afericao)
    {
        try {

            $afericao->movimentacao_combustivel()->create([
                'tanque_id' => $afericao->abastecimento()->first()->bico()->first()->tanque_id,
                'tipo_movimentacao_combustivel_id' => '4', /* saida afericao */
                'quantidade' => $afericao->abastecimento()->first()->volume_abastecimento,
                'afericao_id' => $afericao->id
            ]);

            return true;
        } catch (\Exception $e) {
            throw new \Exception('Erro ao incluir movimentacao de entrada por aferição para o Abastecimento: ' . $abastecimento->id);
        }
    }

    static public function cadastroAfericao(Afericao $afericao)
    {
        try {
            return (self::saidaAfericao($afericao) && self::entradaAfericao($afericao));
        } catch (\Exception $e) {
            return $e;
        }
    }
}
