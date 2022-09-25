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

class DashboardController extends Controller
{
    public function index() {
        return View('teste', [
            'tanques' => $this->movimentacaoCombustiveis()
        ]);
    }

    public function movTanque() {
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
                $grafico['datasets'][$i]['label'] = $tanque->descricao_tanque.' - '.$tanque->combustivel->descricao;
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
                $grafico['datasets'][$i]['label'] = $tanque->descricao_tanque.' - '.$tanque->combustivel->descricao;
                $grafico['datasets'][$i]['backgroundColor'] =  $colors[$i];
                $grafico['datasets'][$i]['data'][] = (new TanqueMovimentacaoController)->getPosicaoTanque($tanque, $dataFinal);
                $i++;
            }
        }

        return response()->json($grafico);
    }

    public function ultimasEntradasComb() {
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

    public function totalVeiculosFrota() {
        $veiculos['total_veiculos_frota'] = Veiculo::where('ativo', true)->count();

        return response()->json($veiculos);
    }

    
    public function totalClientesCadastrados() {
        $clientes['clientes_cadastrados'] = Cliente::where('ativo', true)->count();

        return response()->json($clientes);
    }

    public function abastecimentosHoje() {
        $data = new \Datetime();

        $abastecimentos['abastecimentos_hoje'] = Abastecimento::whereDate('data_hora_abastecimento', $data->format('Y-m-d'))->count();

        return response()->json($abastecimentos);
    }

    public function osEmAberto() {
        $oss = OrdemServico::with('user')
        ->with('veiculo')
        ->whereHas('ordem_servico_status', function($query) {
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
