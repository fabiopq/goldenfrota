<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Estoque;
use App\Produto;
use App\Departamento;
use App\Parametro;
use App\SaidaEstoque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MovimentacaoProdutoController;

class SaidaEstoqueController extends Controller
{
    public $fields = [
        'id' => 'ID',
        'nome_cliente' => 'Cliente',
        'data_saida' => [
            'label' => 'Data',
            'type' => 'datetime'
        ],
        'valor_total' => [
            'label' => 'Valor',
            'type' => 'decimal',
            'decimais' => 3
        ],
        'name' => 'Usuário'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarSaidaEstoque()) {
            if ($request->searchField) {
                $saidas = DB::table('saida_estoques')
                                    ->select('saida_estoques.*', 'clientes.nome_razao as nome_cliente', 'users.name')
                                    ->leftJoin('clientes', 'clientes.id', 'saida_estoques.cliente_id')
                                    ->leftJoin('users', 'users.id', 'saida_estoques.user_id')
                                    ->where('saida_estoques.id', $request->searchField)
                                    ->orWhere('clientes.nome_razao', 'like', '%'.$request->searchField.'%')
                                    ->orWhere('clientes.fantasia', 'like', '%'.$request->searchField.'%')
                                    ->orderBy('id', 'desc')
                                    ->paginate();
            } else {
                $saidas = DB::table('saida_estoques')
                                    ->select('saida_estoques.*', 'clientes.nome_razao as nome_cliente', 'users.name')
                                    ->leftJoin('clientes', 'clientes.id', 'saida_estoques.cliente_id')
                                    ->leftJoin('users', 'users.id', 'saida_estoques.user_id')
                                    ->orderBy('id', 'desc')
                                    ->paginate();
            }

            return View('saida_estoque.index', [
                'fields' => $this->fields,
                'saidas' => $saidas
            ]);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->canCadastrarSaidaEstoque()) {
            return View('saida_estoque.create', [
                'clientes' => Cliente::where('ativo', true)->get(),
                'estoques' => Estoque::where('ativo', true)->get(),
                //'produtos' => Produto::where('ativo', true)->get()
            ]);
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
        //dd($request->all());

        if (Auth::user()->canCadastrarSaidaEstoque()) {
            $this->validate($request, [
                'cliente_id' => 'required',
                'estoque_id' => 'required|integer',
                'data_saida' => 'required',
                'items' => 'required|array|min:1'
            ]);

            try {                
                $dataSaida = \DateTime::createFromFormat('d/m/Y H:i', $request->data_saida);

                DB::beginTransaction();
    
                $saidaEstoque = new SaidaEstoque($request->all());
                $saidaEstoque->data_saida = $dataSaida->format('Y-m-d H:i:s');
                $saidaEstoque->user_id = Auth::user()->id;

                if ($saidaEstoque->save()) {
                    $saidaEstoque->saida_estoque_items()->createMany($request->items);

                    //falta a movimentação de estoque!!!
                    MovimentacaoProdutoController::saidaEstoque($saidaEstoque);


                    DB::commit();
                    Session::flash('success', __('messages.create_success_f', [
                        'model' => 'saida_estoque', 
                        'name' => $saidaEstoque->id
                    ]));

                    return redirect()->action('SaidaEstoqueController@index');
                } else {
                    Session::flash('error', __('messages.create_error_f', [
                        'model' => 'saida_estoque',
                        'name' => $saidaEstoque->id
                    ]));
                }
            } catch (\Exception $e) {
                DB::rollback();
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

    /**
     * Display the specified resource.
     *
     * @param  \App\SaidaEstoque  $saidaEstoque
     * @return \Illuminate\Http\Response
     */
    public function show(SaidaEstoque $saidaEstoque)
    {
        if (Auth::user()->canListarSaidaEstoque()) {
            return View('saida_estoque.show')
                    ->withSaidaEstoque($saidaEstoque)
                    ->withTitulo('Saída de Estoque')
                    //->withParametros($parametros)
                    ->withParametro(Parametro::first());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaidaEstoque  $saidaEstoque
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaidaEstoque $saidaEstoque)
    {
        if (Auth::user()->canExcluirSaidaEstoque()) {
            try {
                $saidaEstoque = SaidaEstoque::find($saidaEstoque->id);
                if ($saidaEstoque->delete()) {
                    Session::flash('success', __('messages.delete_success_f', [
                        'model' => __('models.saida_estoque'),
                        'name' => $saidaEstoque->id 
                    ]));
                    return redirect()->action('SaidaEstoqueController@index');
                }
            } catch (\Exception $e) {
                switch ($e->getCode()) {
                    case 23000:
                        Session::flash('error', __('messages.fk_exception'));
                        break;
                    default:
                        Session::flash('error', __('messages.exception', [
                            'exception' => $e->getMessage()
                        ]));
                        break;
                }
                return redirect()->action('SaidaEstoqueController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    //Parametro relatorio de saida de estoque
    public function paramRelatorioSaidaEstoque() {
        $clientes = Cliente::all();
       
        return View('relatorios.estoque.param_relatorio_saida_estoque')->withClientes($clientes);
    }

    public function RelatorioSaidaEstoque(Request $request) {
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $parametros = array();
  
      if($data_inicial && $data_final) {
          $whereData = 'saida_estoques.data_saida between \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\' and \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
          array_push($parametros, 'Período de '.$data_inicial.' até '.$data_final);
      } elseif ($data_inicial) {
          $whereData = 'saida_estoques.data_saida >= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\'';
          array_push($parametros, 'A partir de '.$data_inicial);
      } elseif ($data_final) {
          $whereData = 'saida_estoques.data_saida <= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
          array_push($parametros, 'Até '.$data_final);
      } else {
          $whereData = '1 = 1'; //busca qualquer coisa
      }
  
      
  
      $cliente_id = $request->cliente_id;
      $departamento_id = $request->departamento_id;
      
      
      if ($cliente_id > 0) {
          array_push($parametros, 'Cliente: ' . Cliente::find($cliente_id)->nome_razao);
      }
  
      if ($departamento_id > 0) {
          array_push($parametros, 'Departamento: ' . Departamento::find($departamento_id)->departamento);
      }
  
     
  
      $clientes = DB::table('saida_estoques')
              ->select('clientes.*')
              ->leftJoin('roles', 'roles.id', 'saida_estoques.user_id')
              ->leftJoin('clientes', 'clientes.id', 'saida_estoques.cliente_id')
              ->leftJoin('departamentos', 'departamentos.id', 'saida_estoques.departamento_id')
              ->whereRaw('clientes.id is not null')
              //->whereRaw('((saida_estoques.ordem_servico_status_id = '.(isset($request->ordem_servico_status_id) ? $request->ordem_servico_status_id : -1).') or ('.(isset($request->ordem_servico_status_id) ? $request->ordem_servico_status_id : -1).' = -1))')
              ->whereRaw($whereData)
              //->whereRaw($whereParam)
              //->whereRaw($whereTipoAbastecimento)
              ->orderBy('clientes.nome_razao', 'asc')
              ->distinct()
              ->get();
              
        if ($request->tipo_relatorio == 1){
          /* relatório Sintético */
  
          foreach($clientes as $cliente) {
              $departamentos = DB::table('saida_estoques')
                      ->select('departamentos.*')
                      ->leftJoin('clientes', 'clientes.id', 'saida_estoques.cliente_id')
                      ->leftJoin('departamentos', 'departamentos.id', 'saida_estoques.departamento_id')
                      ->where('clientes.id',$cliente->id)
                     // ->whereRaw('((ordem_servicos.ordem_servico_status_id = '.(isset($request->ordem_servico_status_id) ? $request->ordem_servico_status_id : -1).') or ('.(isset($request->ordem_servico_status_id) ? $request->ordem_servico_status_id : -1).' = -1))')
                      ->whereRaw($whereData)
                      //->whereRaw($whereParam)
                      //->whereRaw($whereTipoAbastecimento)
                      ->orderBy('departamentos.departamento', 'asc')
                      ->distinct()
                      ->get();
              $cliente->departamentos = $departamentos;
            
            foreach($cliente->departamentos as $departamento) {
                $saidaestoques = DB::table('saida_estoques')
                ->select(
                    'produtos.id','produtos.produto_descricao',
                    DB::raw(
                        'SUM(saida_estoque_items.quantidade
                            
                        ) as quantidade'
                    ),
                    DB::raw(
                        'AVG(saida_estoque_items.valor_unitario
                            
                        ) as valor_unitario'
                    )
                )
                ->groupBy('produtos.id','produtos.produto_descricao')
             //->select('saida_estoques.*','produtos.*','saida_estoque_items.*')
             ->leftJoin('saida_estoque_items', 'saida_estoque_items.saida_estoque_id', 'saida_estoques.id')
             ->leftJoin('produtos', 'produtos.id', 'saida_estoque_items.produto_id')
             ->leftJoin('clientes', 'clientes.id', 'saida_estoques.cliente_id')
             ->leftJoin('departamentos', 'departamentos.id', 'saida_estoques.departamento_id')
             ->whereRaw('clientes.id is not null')
             //->whereRaw('((ordem_servicos.ordem_servico_status_id = '.(isset($request->ordem_servico_status_id) ? $request->ordem_servico_status_id : -1).') or ('.(isset($request->ordem_servico_status_id) ? $request->ordem_servico_status_id : -1).' = -1))')
             ->whereRaw($whereData)
             //->whereRaw($whereParam)
             //->whereRaw($whereTipoAbastecimento)
             ->where('departamentos.id', $departamento->id)
            // ->groupBy('saida_estoque_items.produto_id')
             ->orderby('produtos.id')
             //->groupBy('veiculos.placa')
             ->get();
             //->toSql();
             $departamento->saidaestoques = $saidaestoques;
            
             } 
            }
                  
             return View('relatorios.estoque.relatorio_saida_estoque')->withClientes($clientes)->withTitulo('Relatório de Saida de Estoque - Sintético')->withParametros($parametros)->withParametro(Parametro::first());
          } 
      
    }
}
