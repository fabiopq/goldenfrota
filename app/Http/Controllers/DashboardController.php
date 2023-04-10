<?php

namespace App\Http\Controllers;

use App\Tanque;
use App\Veiculo;
use App\Cliente;
use App\OrdemServico;
use App\Abastecimento;
use Illuminate\Http\Request;
use App\MovimentacaoCombustivel;
use Illuminate\Support\Facades\DB;
use ConsoleTVs\Charts\Facades\Charts;
use App\Http\Controllers\TanqueMovimentacaoController;
use App\Motorista;

use function GuzzleHttp\Promise\each;

class DashboardController extends Controller
{
    public function index()
    {
        return View('teste', [
            'tanques' => $this->movimentacaoCombustiveis()
        ]);
    }

    public function movTanque()
    {
        $dataFinal = new \DateTime();
        $dataInicial = new \Datetime();
        $dataInicial->sub(new \DateInterval('P15D'));
        $tanques = Tanque::Ativo()->get();

        if (!$tanques) {
            return;
        }

        $grafico = array();
        $colors = [
            'rgba(45, 195, 21, 0.2)',
            'rgba(195, 45, 21, 0.3)',
            'rgba(45, 21, 195, 0.4)',
            'rgba(195, 195, 21, 0.5)',
            'rgba(195, 21, 195, 0.6)',
            'rgba(21, 195, 195, 0.7)',
            'rgba(195, 21, 195, 0.8)'
        ];

        while ($dataInicial <= $dataFinal) {
            $grafico['labels'][] = $dataInicial->format('d/m');

            $i = 0;
            foreach ($tanques as $tanque) {
                $grafico['datasets'][$i]['label'] = $tanque->descricao_tanque . ' - ' . $tanque->combustivel->descricao;
                $grafico['datasets'][$i]['backgroundColor'] = $colors[$i];
                $grafico['datasets'][$i]['data'][] = (new TanqueMovimentacaoController)->getPosicaoTanque($tanque, $dataInicial);
                $i++;
            }

            $dataInicial->add(new \DateInterval('P1D'));
        }

        if ($dataInicial > $dataFinal) {
            $grafico['labels'][] = $dataFinal->format('d/m');
            $i = 0;
            foreach ($tanques as $tanque) {
                $grafico['datasets'][$i]['label'] = $tanque->descricao_tanque . ' - ' . $tanque->combustivel->descricao;
                $grafico['datasets'][$i]['backgroundColor'] =  $colors[$i];
                $grafico['datasets'][$i]['data'][] = (new TanqueMovimentacaoController)->getPosicaoTanque($tanque, $dataFinal);
                $i++;
            }
        }

        return response()->json($grafico);
    }

    public function ultimasEntradasComb()
    {
        $entradas = DB::table('movimentacao_combustiveis')
            ->select('movimentacao_combustiveis.*', 'tanques.descricao_tanque', 'combustiveis.descricao', 'entrada_tanques.nr_docto', 'entrada_tanques.serie', 'entrada_tanques.data_entrada')
            ->join('tipo_movimentacao_combustiveis', 'tipo_movimentacao_combustiveis.id', 'movimentacao_combustiveis.tipo_movimentacao_combustivel_id')
            ->join('tanques', 'tanques.id', 'movimentacao_combustiveis.tanque_id')
            ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
            ->join('entrada_tanques', 'entrada_tanques.id', 'movimentacao_combustiveis.entrada_tanque_id')
            ->where('tipo_movimentacao_combustiveis.eh_entrada', true)
            ->orderBy('movimentacao_combustiveis.created_at', 'desc')
            ->take(5)
            ->get();

        return response()->json($entradas);
    }
    public function saldoTanques2($data)
    {
        $posicao = DB::table('movimentacao_combustiveis')
            ->select(
                DB::raw(
                    'tanques.id, tanques.descricao_tanque,tanques.capacidade,
                        
                    ROUND(SUM(
                    CASE tipo_movimentacao_combustiveis.eh_entrada
                        WHEN 1 THEN
                            movimentacao_combustiveis.quantidade
                        WHEN 0 THEN
                            movimentacao_combustiveis.quantidade * -1
                    END
                    ),3) as posicao'
                )
            )
            ->leftJoin('tanques', 'tanques.id', 'movimentacao_combustiveis.tanque_id')
            ->leftJoin('tipo_movimentacao_combustiveis', 'tipo_movimentacao_combustiveis.id', 'movimentacao_combustiveis.tipo_movimentacao_combustivel_id')

            ->where('movimentacao_combustiveis.created_at', '<', $data)
            ->groupBy('tanques.id')
            ->get();





        return ($posicao->posicao) ? $posicao->posicao : 0;
    }

    public function saldoTanques()
    {

        $tanques = Tanque::select('tanques.*', 'combustiveis.descricao')
            ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
            ->where('tanques.ativo', true)->get();


        //$dataAtual = (new \DateTime())->format('d/m/Y');
        //$dataInicial = (new \DateTime('-1 day'))->format('d/m/Y');

        //dd($dataAtual);
        $dataInicio = date_format(date_create_from_format('d/m/Y H:i:s', (new \DateTime())->format('d/m/Y') . '00:00:00'), 'Y-m-d H:i:s');
        $dataFim = date_format(date_create_from_format('d/m/Y H:i:s', (new \DateTime())->format('d/m/Y') . '23:59:59'), 'Y-m-d H:i:s');

      // dd($tanques);
        // return ($posicao->posicao) ? $posicao->posicao : 0;
        $result = array();
        foreach ($tanques as $tanque) {
            $posicaoInicio = DB::table('movimentacao_combustiveis')
            ->select(
                DB::raw(
                    'ROUND(SUM(
                CASE tipo_movimentacao_combustiveis.eh_entrada
                    WHEN 1 THEN
                        movimentacao_combustiveis.quantidade
                    WHEN 0 THEN
                        movimentacao_combustiveis.quantidade * -1
                END
                ),3) as posicao_inicial'
                )
            )
            ->leftJoin('tanques', 'tanques.id', 'movimentacao_combustiveis.tanque_id')
            ->leftJoin('tipo_movimentacao_combustiveis', 'tipo_movimentacao_combustiveis.id', 'movimentacao_combustiveis.tipo_movimentacao_combustivel_id')
            ->where('movimentacao_combustiveis.created_at', '<', $dataInicio)
            ->where('movimentacao_combustiveis.tanque_id', '=', $tanque->id)
            ->groupBy('tanques.id')
            ->get();

            $posicaoFim =  DB::table('movimentacao_combustiveis')
            ->select(
                DB::raw(
                    'ROUND(SUM(
                CASE tipo_movimentacao_combustiveis.eh_entrada
                    WHEN 1 THEN
                        movimentacao_combustiveis.quantidade
                    WHEN 0 THEN
                        movimentacao_combustiveis.quantidade * -1
                END
                ),3) as posicao_final'
                )
            )
            ->leftJoin('tanques', 'tanques.id', 'movimentacao_combustiveis.tanque_id')
            ->leftJoin('tipo_movimentacao_combustiveis', 'tipo_movimentacao_combustiveis.id', 'movimentacao_combustiveis.tipo_movimentacao_combustivel_id')
            ->where('movimentacao_combustiveis.created_at', '<', $dataFim)
            ->where('movimentacao_combustiveis.tanque_id', '=', $tanque->id)
            ->groupBy('tanques.id')
            ->get();
            

            $result[] = [
                'id' => $tanque->id,
                'descricao_tanque' => $tanque->descricao_tanque,
                'capacidade' => $tanque->capacidade,
                'posicao_inicial' => $posicaoInicio[0]->posicao_inicial,
                'posicao_final' => $posicaoFim[0]->posicao_final
            ];
        }

        return response()->json($result);
    }

    public function totalVeiculosFrota()
    {
        $veiculos['total_veiculos_frota'] = Veiculo::where('ativo', true)->count();

        return response()->json($veiculos);
    }


    public function totalClientesCadastrados()
    {
        $clientes['clientes_cadastrados'] = Cliente::where('ativo', true)->count();

        return response()->json($clientes);
    }

    public function totalMotoristasCadastrados()
    {
        $motoristas['motoristas_cadastrados'] = Motorista::where('ativo', true)->count();

        return response()->json($motoristas);
    }

    public function abastecimentosHoje()
    {
        $data = new \Datetime();

        $abastecimentos['abastecimentos_hoje'] = Abastecimento::whereDate('data_hora_abastecimento', $data->format('Y-m-d'))->count();

        return response()->json($abastecimentos);
    }

    public function osEmAberto()
    {
        $oss = OrdemServico::with('user')
            ->with('veiculo')
            ->whereHas('ordem_servico_status', function ($query) {
                $query->where('em_aberto', true);
            })
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->get();

        $result = array();
        foreach ($oss as $os) {
            $daysAgo = (new \Datetime())->diff((new \DateTime($os->created_at)))->format("%a");
            $result[] = [
                'id' => $os->id,
                'veiculo' => $os->veiculo->placa,
                'usuario' => $os->user->name ?? '',
                'dias_em_aberto' => $daysAgo
            ];
        }

        return response()->json($result);
    }

    /* public function produtosAbaixoEstoqueMinimo() {
        $produtos = DB::table('produtos')
                ->select('produtos.*', 'estoques.estoque', )
    } */
}
