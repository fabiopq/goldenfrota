<?php

namespace App\Http\Controllers;

use App\Bico;
use App\Tanque;
use App\Afericao;
use App\AjusteTanque;
use App\Abastecimento;
use App\Combustivel;
use App\EntradaTanque;
use Illuminate\Http\Request;
use App\MovimentacaoCombustivel;
use App\Parametro;
use App\TipoMovimentacaoCombustivel;
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
            // dd($e);
            throw new \Exception($e);
        }
    }

    static public function saidaAbastecimentoAjuste(Abastecimento $abastecimento)
    {


        try {
            $bico = Bico::select('tanque_id')
                ->where('id', $abastecimento->bico_id)
                ->first();

            $abastecimento->movimentacao_combustivel()->create([
                'tanque_id' => $bico->tanque_id,
                'tipo_movimentacao_combustivel_id' => '6', /* Abastecimento */
                'quantidade' => $abastecimento->volume_abastecimento,
                'abastecimento_id' => $abastecimento->id
            ]);

            return true;
        } catch (\Exception $e) {
            // dd($e);
            throw new \Exception($e);
        }
    }

    static public function entradaAbastecimentoAuste(Abastecimento $abastecimento)
    {


        try {
            $bico = Bico::select('tanque_id')
                ->where('id', $abastecimento->bico_id)
                ->first();

            $abastecimento->movimentacao_combustivel()->create([
                'tanque_id' => $bico->tanque_id,
                'tipo_movimentacao_combustivel_id' => '5', /* Abastecimento */
                'quantidade' => $abastecimento->volume_abastecimento,
                'abastecimento_id' => $abastecimento->id
            ]);

            return true;
        } catch (\Exception $e) {
            // dd($e);
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

    public function paramRelatorioMovimentacaoCombustivel()
    {
        $tipo_movimentacao = TipoMovimentacaoCombustivel::all();
        $combustiveis = Combustivel::where('ativo', true)->get();
        return View('relatorios.movimentacao.combustivel_param')->withCombustiveis($combustiveis)->withtipoMovimentacaoCombustivel($tipo_movimentacao);
    }



    public function relatorioMovimentacaoCombustivel(Request $request)
    {
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $tipo_relatorio = $request->tipo_relatorio;
        $tipo_movimentacao = $request->tipo_movimentacao_combustivel_id;
        $parametros = array();
        $estoquesId = array();



        $fornecedor_id = $request->fornecedor_id;
        $combustivel_id = $request->combustivel_id;


        if ($combustivel_id > 0) {
            array_push($parametros, 'Combustivel: ' . Combustivel::find($combustivel_id)->descricao);
            $whereCombustivel = 'tanques.combustivel_id = ' . $request->combustivel_id;
        } else {
            $parametros[] = 'Combutivel: Todos';
            $whereCombustivel = '1 = 1';
        }

        $whereTipoMovimentacao = null;
        if (!empty($tipo_movimentacao)) {
            $parametros[] = 'Tipo de Movimentação: ' . $tipo_movimentacao;
            $whereTipoMovimentacao = $tipo_movimentacao;
        } else {
            $parametros[] = 'Tipo de Movimentação: Todos';
        }

        //dd($whereTipoMovimentacao);


        if ($data_inicial && $data_final) {
            $dataInicio = date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s');
            $dataFim = date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s');
        } elseif ($data_inicial) {
            $dataInicio = date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s');
            $dataFim = null;
        } elseif ($data_final) {
            $dataInicio = null;
            $dataFim = date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s');
        } else {
            $dataInicio = null;
            $dataFim = null;
        }


        $movimentacoesAnalitico = DB::table('movimentacao_combustiveis')
            ->join('tipo_movimentacao_combustiveis', 'movimentacao_combustiveis.tipo_movimentacao_combustivel_id', '=', 'tipo_movimentacao_combustiveis.id')
            ->join('tanques', 'movimentacao_combustiveis.tanque_id', '=', 'tanques.id')
            ->join('combustiveis', 'tanques.combustivel_id', '=', 'combustiveis.id')
            ->select(
                'movimentacao_combustiveis.created_at',
                'tipo_movimentacao_combustiveis.tipo_movimentacao_combustivel',
                'tipo_movimentacao_combustiveis.eh_entrada',
                'tanques.descricao_tanque as tanque',
                'combustiveis.descricao as combustivel',
                'movimentacao_combustiveis.quantidade'
            )
            ->whereBetween('movimentacao_combustiveis.created_at', [$dataInicio, $dataFim])
            ->orderBy('movimentacao_combustiveis.created_at')
            ->get();


        if ($request->tipo_relatorio == 1) {
            // Relatório sintético

            // Movimentações de ENTRADA
            $movimentacoesEntrada = DB::table('movimentacao_combustiveis as m')
                ->join('tipo_movimentacao_combustiveis as t', 'm.tipo_movimentacao_combustivel_id', '=', 't.id')
                ->where('t.eh_entrada', 1)
                ->when($dataInicio, function ($query) use ($dataInicio) {
                    return $query->where('m.created_at', '>=', $dataInicio);
                })
                ->when($dataFim, function ($query) use ($dataFim) {
                    return $query->where('m.created_at', '<=', $dataFim);
                })
                ->when($whereTipoMovimentacao, function ($query) use ($whereTipoMovimentacao) {
                    return $query->where('t.id', $whereTipoMovimentacao);
                })
                ->select('t.tipo_movimentacao_combustivel', DB::raw('SUM(m.quantidade) as total_quantidade'))
                ->groupBy('m.tipo_movimentacao_combustivel_id', 't.tipo_movimentacao_combustivel')
                ->get();

            // Movimentações de SAÍDA
            $movimentacoesSaida = DB::table('movimentacao_combustiveis as m')
                ->join('tipo_movimentacao_combustiveis as t', 'm.tipo_movimentacao_combustivel_id', '=', 't.id')
                ->where('t.eh_entrada', 0)
                ->when($dataInicio, function ($query) use ($dataInicio) {
                    return $query->where('m.created_at', '>=', $dataInicio);
                })
                ->when($dataFim, function ($query) use ($dataFim) {
                    return $query->where('m.created_at', '<=', $dataFim);
                })
                ->when($whereTipoMovimentacao, function ($query) use ($whereTipoMovimentacao) {
                    return $query->where('t.id', $whereTipoMovimentacao);
                })
                ->select('t.tipo_movimentacao_combustivel', DB::raw('SUM(m.quantidade) as total_quantidade'))
                ->groupBy('m.tipo_movimentacao_combustivel_id', 't.tipo_movimentacao_combustivel')
                ->get();


            return view('relatorios.movimentacao.combustivel_sintetico')
                ->withMovimentacoesEntrada($movimentacoesEntrada)
                ->withMovimentacoesSaida($movimentacoesSaida)
                ->withParametros($parametros)
                ->withTitulo('Movimentações de Combustível - Sintético')
                ->withParametro(Parametro::first());
        } else {
            // Relatório analítico
            $entradasAgrupadas = DB::table('movimentacao_combustiveis')
                ->join('tipo_movimentacao_combustiveis', 'movimentacao_combustiveis.tipo_movimentacao_combustivel_id', '=', 'tipo_movimentacao_combustiveis.id')
                ->join('tanques', 'movimentacao_combustiveis.tanque_id', '=', 'tanques.id')
                ->join('combustiveis', 'tanques.combustivel_id', '=', 'combustiveis.id')
                ->select(
                    'tipo_movimentacao_combustiveis.tipo_movimentacao_combustivel as tipo',
                    'movimentacao_combustiveis.created_at',
                    'tanques.descricao_tanque as tanque',
                    'combustiveis.descricao as combustivel',
                    'movimentacao_combustiveis.quantidade'
                )
                ->where('tipo_movimentacao_combustiveis.eh_entrada', 1)
                ->when($whereTipoMovimentacao, function ($query) use ($whereTipoMovimentacao) {
                    return $query->where('tipo_movimentacao_combustiveis.id', $whereTipoMovimentacao);
                })
                ->whereBetween('movimentacao_combustiveis.created_at', [$dataInicio, $dataFim])
                ->orderBy('tipo')
                ->orderBy('movimentacao_combustiveis.created_at')
                ->get()
                ->groupBy('tipo');

            $saidasAgrupadas = DB::table('movimentacao_combustiveis')
                ->join('tipo_movimentacao_combustiveis', 'movimentacao_combustiveis.tipo_movimentacao_combustivel_id', '=', 'tipo_movimentacao_combustiveis.id')
                ->join('tanques', 'movimentacao_combustiveis.tanque_id', '=', 'tanques.id')
                ->join('combustiveis', 'tanques.combustivel_id', '=', 'combustiveis.id')
                ->select(
                    'tipo_movimentacao_combustiveis.tipo_movimentacao_combustivel as tipo',
                    'movimentacao_combustiveis.created_at',
                    'tanques.descricao_tanque as tanque',
                    'combustiveis.descricao as combustivel',
                    'movimentacao_combustiveis.quantidade'
                )
                ->where('tipo_movimentacao_combustiveis.eh_entrada', 0)
                ->when($whereTipoMovimentacao, function ($query) use ($whereTipoMovimentacao) {
                    return $query->where('tipo_movimentacao_combustiveis.id', $whereTipoMovimentacao);
                })
                ->whereBetween('movimentacao_combustiveis.created_at', [$dataInicio, $dataFim])
                ->orderBy('tipo')
                ->orderBy('movimentacao_combustiveis.created_at')
                ->get()
                ->groupBy('tipo');

            return view('relatorios.movimentacao.combustivel_analitico')
                ->withEntradasAgrupadas($entradasAgrupadas)
                ->withSaidasAgrupadas($saidasAgrupadas)
                ->withParametros($parametros)
                ->withTitulo('Movimentações de Combustível - Analítico')
                ->withParametro(Parametro::first());
        }
    }
}
