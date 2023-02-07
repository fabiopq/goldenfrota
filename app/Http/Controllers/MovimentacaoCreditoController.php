<?php

namespace App\Http\Controllers;

use App\Bico;
use App\Cliente;
use App\Combustivel;
use App\TipoMovimentacaoCredito;
use App\Atendente;
use App\Parametro;
use App\Departamento;
use App\Abastecimento;
use App\TanqueMovimentacao;
use Illuminate\Http\Request;
use App\Events\NovoAbastecimento;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\BicoController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\AfericaoController;
use App\Http\Controllers\MovimentacaoCombustivelController;
use App\MovimentacaoCredito;
use CreateTipoMovimentacaoCredito;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use phpDocumentor\Reflection\Types\Boolean;

class MovimentacaoCreditoController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'data_movimentacao' => ['label' => 'Data/Hora', 'type' => 'datetime'],
        'nome_razao' => 'Cliente',
        //'placa' => 'Veículo',
       // 'valor_litro' => ['label' => 'Valor Litro', 'type' => 'decimal', 'decimais' => 3],
        //'volume_abastecimento' => ['label' => 'Qtd. Abast.', 'type' => 'decimal', 'decimais' => 2],
        'valor' => ['label' => 'Valor', 'type' => 'decimal', 'decimais' => 3],
        
        //'km_veiculo' => ['label' => 'Odômetro/Horímetro', 'type' => 'decimal', 'decimais' => 1],
        //'media_veiculo' => ['label' => 'Média', 'type' => 'decimal', 'decimais' => 2],
        //'nome_atendente' => 'Atendente',
        //'abastecimento_local' => ['label' => 'Abast. Local', 'type' => 'bool'],
        //'eh_afericao' => ['label' => 'Aferição', 'type' => 'bool']
        //'ativo' => ['label' => 'Ativo', 'type' => 'bool'],

    );
    public function index(Request $request)
    {
        if (Auth::user()->canListarAbastecimento()) {
            $data_inicial = $request->data_inicial;
            $data_final = $request->data_final;

            if ($data_inicial && $data_final) {
                $whereData = 'movimentacao_creditos.data_movimentacao between \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s') . '\' and \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s') . '\'';
            } elseif ($data_inicial) {
                $whereData = 'movimentacao_creditos.data_movimentacao >= \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s') . '\'';
            } elseif ($data_final) {
                $whereData = 'movimentacao_creditos.data_movimentacao <= \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s') . '\'';
            } else {
                $whereData = '1 = 1'; //busca qualquer coisa
            }

            if (isset($request->searchField)) {
                $movimentacao = DB::table('movimentacao_creditos')
                    ->select('movimentacao_creditos.*', 'clientes.nome_razao')
                   // ->leftJoin('veiculos', 'veiculos.id', 'movimentacao_creditos.veiculo_id')
                    //->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                    ->leftJoin('clientes', 'clientes.id', 'movimentacao_creditos.cliente_id')
                    //->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
                    ->whereRaw($whereData)
                  //  ->where('veiculos.placa', 'like', '%' . $request->searchField . '%')
                    ->orWhere('clientes.nome_razao', 'like', '%' . $request->searchField . '%')
                    //->orWhere('atendentes.nome_atendente', 'like', '%' . $request->searchField . '%')
                    /* ->orderBy('abastecimentos.id', 'desc') */
                    ->orderBy('movimentacao_creditos.data_movimentacao', 'desc')
                    ->paginate();
            } else {
                $movimentacao = DB::table('movimentacao_creditos')
                    ->select('movimentacao_creditos.*', 'clientes.nome_razao')
                   // ->leftJoin('veiculos', 'veiculos.id', 'movimentacao_creditos.veiculo_id')
                    //->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                    ->leftJoin('clientes', 'clientes.id', 'movimentacao_creditos.cliente_id')
                    //->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
                    ->whereRaw($whereData)
                    /* ->orderBy('abastecimentos.id', 'desc') */
                    ->orderBy('movimentacao_creditos.data_movimentacao', 'desc')
                    ->paginate();
            }

            return View('movimentacao_credito.index', [
                'movimentacao_creditos' => $movimentacao->appends(Input::except('page')),
                'fields' => $this->fields
            ]);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function create()
    {
        if (Auth::user()->canCadastrarAtendente()) {
            
            $combustiveis = Combustivel::where('ativo',true)->get();
            $clientes = Cliente::where('ativo', true)->get();
            $tipomovimentacao = TipoMovimentacaoCredito::where('ativo', true)->get();
            return View('movimentacao_credito.create')
                ->withclientes($clientes)->withcombustiveis($combustiveis)->withtipomovimentacao( $tipomovimentacao);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        

        if (Auth::user()->canCadastrarAbastecimento()) {
            
            $this->validate($request, [
                'data_movimentacao' => 'required',
                'cliente_id' => 'required',
                'quantidade_movimentada' => 'required|numeric|min:0',
                'valor_litro' => 'required|numeric|min:0',
                'valor_total' => 'required|numeric|min:0',
                'combustivel_id' => 'required'
            ]);


            try {
                //DB::beginTransaction();

                $movimentacao = new MovimentacaoCredito();
                //dd($request->data_movimentacao);
                $data_movimentacao = \DateTime::createFromFormat('d/m/Y H:i', $request->data_movimentacao);
                $movimentacao->data_movimentacao = $data_movimentacao->format('Y-m-d H:i:s');
                $movimentacao->cliente_id = $request->cliente_id;
                //$movimentacao->veiculo_id = $request->veiculo_id;
                $movimentacao->combustivel_id = $request->combustivel_id;
                $movimentacao->quantidade_movimentada = str_replace(',', '.', $request->quantidade_movimentada);
                $movimentacao->valor_unitario = str_replace(',', '.', $request->valor_litro);
                $movimentacao->valor = str_replace(',', '.', $request->valor_total);
                $movimentacao->user_id = Auth::user()->id;
                $movimentacao->tipo_movimentacao_produto_id = 1;
                $movimentacao->observacao = $request->observacao;
             
                /* Calcula a média do veículo, caso seja informado um veículo */
                

                if ($movimentacao->save()) {

                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.movimentacao_credito'),
                        'name' => $movimentacao->valor
                    ]));
                    return redirect()->action('MovimentacaoCreditoController@index');
                        
                }

                                    
            } catch (\Exception $e) {
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return redirect()->back()->withInput();
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function getSaldoCredito($id)
    {
        return response()->json(Combustivel::ativo()->where('id', $id)->get());
    }

}
