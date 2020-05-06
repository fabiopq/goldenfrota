<?php

namespace App\Http\Controllers;

use App\User;
use App\Cliente;
use App\Estoque;
use App\Veiculo;
use App\Produto;
use App\Servico;
use App\Parametro;
use App\OrdemServico;
use App\VencimentoProduto;
use App\Departamento;
use App\OrdemServicoStatus;
use App\MovimentacaoProduto;
use App\OrdemServicoProduto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Events\UtilizadoProdutoControleVencimento;
use App\Http\Controllers\MovimentacaoProdutoController;

class OrdemServicoController extends Controller
{
    public $fields = [
        'id' => 'ID',
        'nome_razao' => 'Cliente',
        'placa' => 'Veículo',
        'name' => 'Usuário',
        'created_at' => ['label' => 'Data', 'type' => 'datetime'],
        'os_status' => 'Status'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarOrdemServico()) {
            if ($request->searchField) {
                $ordemServicos = DB::table('ordem_servicos')
                                ->select('ordem_servicos.*', 'clientes.nome_razao', 'veiculos.placa', 'users.name', 'ordem_servico_status.os_status')
                                ->leftJoin('veiculos', 'veiculos.id', 'ordem_servicos.veiculo_id')
                                ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                                ->leftJoin('users', 'users.id', 'ordem_servicos.user_id')
                                ->leftJoin('ordem_servico_status', 'ordem_servico_status.id', 'ordem_servico_status_id')
                                ->where('ordem_servicos.id', $request->searchField)
                                ->orWhere('clientes.nome_razao', 'like', '%'.$request->searchField.'%')
                                ->orWhere('veiculos.placa', 'like', '%'.$request->searchField.'%')
                                ->orderBy('id', 'desc')
                                ->paginate();
            } else {
                $ordemServicos = DB::table('ordem_servicos')
                                ->select('ordem_servicos.*', 'clientes.nome_razao', 'veiculos.placa', 'users.name', 'ordem_servico_status.os_status')
                                ->leftJoin('veiculos', 'veiculos.id', 'ordem_servicos.veiculo_id')
                                ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                                ->leftJoin('users', 'users.id', 'ordem_servicos.user_id')
                                ->leftJoin('ordem_servico_status', 'ordem_servico_status.id', 'ordem_servico_status_id')
                                ->orderBy('id', 'desc')
                                ->paginate();
            }

            return View('ordem_servico.index', [
                'ordem_servicos' => $ordemServicos,
                'fields' => $this->fields
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
        if (Auth::user()->canCadastrarOrdemServico()) {
            $clientes = Cliente::where('ativo', true)->orderBy('nome_razao', 'asc')->get();
            $estoques = Estoque::where('ativo', true)->orderBy('estoque', 'asc')->get();
            $servicos = Servico::where('ativo', true)->orderBy('servico', 'asc')->get();
            $produtos = Produto::where('ativo', true)->orderBy('produto_descricao', 'asc')->get();
            $ordemServicoStatus = OrdemServicoStatus::orderBy('os_status', 'asc')->get();

            return View('ordem_servico.create', [
                'clientes' => $clientes,
                'estoques' => $estoques,
                'servicos' => $servicos,
                'produtos' => $produtos,
                'ordemServicoStatus' => $ordemServicoStatus
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
        //return redirect()->back()->withInput();
        //dd(Estoque::find($request->estoque_id));
        if (Auth::user()->canCadastrarOrdemServico()) {
            $this->validate($request, [
                'cliente_id' => 'required',
                'veiculo_id' => 'required',
                'km_veiculo' => 'required|numeric|min:0',
                //'servicos' => 'array|size:1',
            ]);
            try {

                DB::beginTransaction();

                $ordemServico = Auth::user()->ordem_servico()->create($request->all());

                //dd($request->all());

                $osStatus = OrdemServicoStatus::find($request->ordem_servico_status_id);
                if (!$osStatus->em_aberto) {
                    $ordemServico->data_fechamento = date('Y-m-d H:i:s');
                }
                
                if (is_array($request->servicos)) {
                    $ordemServico->servicos()->createMany($request->servicos);
                }

                if (is_array($request->produtos)) {
                    $ordemServico->produtos()->createMany($request->produtos);
                
                    /* baixa produtos vencidos que foram trocados */
                    //dd($request->produtos);
                    foreach ($request->produtos as $produto) {
                        if ($produto['produto_vencimento_id']) {
                            $vencimentoProduto = VencimentoProduto::find($produto['produto_vencimento_id']);
                            if ($vencimentoProduto) {
                                $vencimentoProduto->proximo_vencer = false;
                                $vencimentoProduto->vencido = false;
                                $vencimentoProduto->troca_efetuada = true;
                                $vencimentoProduto->ordem_servico_troca_id = $ordemServico->id;
                                $vencimentoProduto->produto_substituto_id = $produto['produto_id'];

                                $vencimentoProduto->save();
                            }
                        }
                    }
                }

                MovimentacaoProdutoController::saidaOrdemServico($ordemServico);

                event(new UtilizadoProdutoControleVencimento($ordemServico));

                DB::commit();

                Session::flash('success', __('messages.create_success_f', [
                    'model' => __('models.ordem_servico'),
                    'name' => 'Ordem de Serviço'
                ]));

                return redirect()->action('OrdemServicoController@index');
                
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
     * @param  \App\OrdemServico  $ordemServico
     * @return \Illuminate\Http\Response
     */
    public function show(OrdemServico $ordemServico)
    {
        if (Auth::user()->canListarOrdemServico()) {
            return View('ordem_servico.show')
                    ->withOrdemServico($ordemServico)
                    ->withTitulo('Ordem de Serviço')
                    //->withParametros($parametros)
                    ->withParametro(Parametro::first());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrdemServico  $ordemServico
     * @return \Illuminate\Http\Response
     */
    public function edit(OrdemServico $ordemServico)
    {
        if (Auth::user()->canAlterarOrdemServico()) {

            /* Não permite alterar OS Fechada */
            $osStatus = OrdemServicoStatus::find($ordemServico->ordem_servico_status_id);
            if (!$osStatus->em_aberto) {
                Session::flash('error', __('messages.edit_not_allowed', [
                    'model' => __('models.ordem_servico'),
                    'status' => __('strings.os_status_fechada')
                ]));
                return redirect()->back();
            }

            
            $servicos = Servico::where('ativo', true)->orderBy('servico', 'asc')->get();
            $produtos = Produto::where('ativo', true)->orderBy('produto_descricao', 'asc')->get(); 
            $estoques = Estoque::where('ativo', true)->orderBy('estoque', 'asc')->get();
            $veiculos = $ordemServico->veiculo->get();
            $clientes = $ordemServico->veiculo->cliente->get();
            $ordemServicoStatus = OrdemServicoStatus::orderBy('os_status', 'asc')->get();

            return View('ordem_servico.edit', [
                'veiculos' => $veiculos,
                'ordemServico' => $ordemServico,
                'estoques' => $estoques,
                'servicos' => $servicos,
                'produtos' => $produtos,
                'ordemServicoStatus' => $ordemServicoStatus
            ]);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrdemServico  $ordemServico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrdemServico $ordemServico)
    {
        if (Auth::user()->canAlterarOrdemServico()) {
            $this->validate($request, [
                'cliente_id' => 'required',
                'veiculo_id' => 'required',
                'km_veiculo' => 'required|numeric|min:0',
                //'servicos' => 'array|size:1',
            ]);
            try {
                DB::beginTransaction();

                $ordemServico->fill($request->all());

                $osStatus = OrdemServicoStatus::find($ordemServico->ordem_servico_status_id);
                if (!$osStatus->em_aberto) {
                    $ordemServico->data_fechamento = date('Y-m-d H:i:s');
                }

                if ($ordemServico->save()) {
                    /* remove produtos */
                    $ordemServico->produtos()->delete();

                    /* remove serviços */
                    $ordemServico->servicos()->delete();

                    /* inclui produtos */
                    if (is_array($request->produtos)) {
                        $ordemServico->produtos()->createMany($request->produtos);
                    }

                    /* inclui serviços */
                    if (is_array($request->servicos)) {
                        $ordemServico->servicos()->createMany($request->servicos);
                    }

                    /* movimenta o estoque dos produtos */
                    MovimentacaoProdutoController::saidaOrdemServico($ordemServico);

                    /* comita a transação */
                    DB::commit();

                    Session::flash('success', __('messages.update_success_f', [
                        'model' => __('models.ordem_servico'),
                        'name' => $ordemServico->id
                    ]));
    
                    return redirect()->action('OrdemServicoController@index');
                } else {
                    DB::rollback();
                    
                    Session::flash('error', __('messages.update_error_f', [
                        'model' => __('models.ordem_servico'),
                        'name' => $ordemServico->id
                    ]));

                    return redirect()->back()->withInput();
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
     * Remove the specified resource from storage.
     *
     * @param  \App\OrdemServico  $ordemServico
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrdemServico $ordemServico)
    {
        if (Auth::user()->canExcluirOrdemServico()) {   
            try {
                if ($ordemServico->delete()) {
                    Session::flash('success', __('messages.delete_success_f', [
                        'model' => __('models.ordem_servico'),
                        'name' => $ordemServico->id
                    ]));
                    return redirect()->action('OrdemServicoController@index');
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
                return redirect()->action('OrdemServicoController@index');        
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function paramRelatorioOrdemServicos() {
        $clientes = Cliente::all();
        $veiculos = Veiculo::select(DB::raw("concat(veiculos.placa, ' - ', marca_veiculos.marca_veiculo, ' ', modelo_veiculos.modelo_veiculo) as veiculo"), 'veiculos.id')
                                ->join('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
                                ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
                                ->where('veiculos.ativo', true)
                                ->get();
        //dd($veiculos);
        return View('relatorios.ordem_servicos.param_relatorio_ordem_servicos')->withClientes($clientes)->withVeiculos($veiculos);
    }

    public function RelatorioOrdemServicos(Request $request) {
      $data_inicial = $request->data_inicial;
      $data_final = $request->data_final;
      $parametros = array();

    if($data_inicial && $data_final) {
        $whereData = 'ordem_servicos.created_at between \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\' and \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
        array_push($parametros, 'Período de '.$data_inicial.' até '.$data_final);
    } elseif ($data_inicial) {
        $whereData = 'ordem_servicos.created_at >= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\'';
        array_push($parametros, 'A partir de '.$data_inicial);
    } elseif ($data_final) {
        $whereData = 'ordem_servicos.created_at <= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
        array_push($parametros, 'Até '.$data_final);
    } else {
        $whereData = '1 = 1'; //busca qualquer coisa
    }

    switch ($request->tipo_abastecimento) {
        case 0:
            $whereTipoAbastecimento = ('abastecimentos.abastecimento_local = 0');
            array_push($parametros, 'Tipo de Abastecimento: Externo');
            break;
        case 1:
            $whereTipoAbastecimento = ('abastecimentos.abastecimento_local = 1');
            array_push($parametros, 'Tipo de Abastecimento: Local');
            break;
        default:
            $whereTipoAbastecimento = ('1 = 1');
            array_push($parametros, 'Tipo de Abastecimento: Todos');
            break;
    }

    $cliente_id = $request->cliente_id;
    $departamento_id = $request->departamento_id;
    $veiculo_id = $request->veiculo_id;

    if ($veiculo_id > 0) {
        $whereParam = 'veiculos.id = '. $veiculo_id;
    } else {
        if ($departamento_id > 0) {
            $whereParam = 'veiculos.departamento_id = '. $departamento_id;
        } else {
            if ($cliente_id > 0) {
                $whereParam = 'veiculos.cliente_id = '. $cliente_id;
            } else {
                $whereParam = '1 = 1';
            }
        }
    }

    if ($cliente_id > 0) {
        array_push($parametros, 'Cliente: ' . Cliente::find($cliente_id)->nome_razao);
    }

    if ($departamento_id > 0) {
        array_push($parametros, 'Departamento: ' . Departamento::find($departamento_id)->departamento);
    }

    if ($veiculo_id > 0) {
        $veiculo_param = Veiculo::select('veiculos.*', 'marca_veiculos.marca_veiculo', 'modelo_veiculos.modelo_veiculo')
                    ->join('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
                    ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
                    ->where([
                        ['veiculos.id', '=', $veiculo_id]
                    ])->first();
        array_push($parametros, 'Veiculo: ' . $veiculo_param->placa . ' - ' . $veiculo_param->marca_veiculo . ' ' . $veiculo_param->modelo_veiculo);
    }

    $clientes = DB::table('ordem_servicos')
            ->select('clientes.*')
            ->leftJoin('veiculos', 'veiculos.id', 'ordem_servicos.veiculo_id')
            ->leftJoin('roles', 'roles.id', 'ordem_servicos.user_id')
            ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
            ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
            ->whereRaw('clientes.id is not null')
            ->whereRaw('((ordem_servicos.ordem_servico_status_id = '.(isset($request->ordem_servico_status_id) ? $request->ordem_servico_status_id : -1).') or ('.(isset($request->ordem_servico_status_id) ? $request->ordem_servico_status_id : -1).' = -1))')
            ->whereRaw($whereData)
            ->whereRaw($whereParam)
            //->whereRaw($whereTipoAbastecimento)
            ->orderBy('clientes.nome_razao', 'asc')
            ->distinct()
            ->get();
            
    if ($request->tipo_relatorio == 1) {
        /* relatório Sintético */

        foreach($clientes as $cliente) {
            $departamentos = DB::table('ordem_servicos')
                    ->select('departamentos.*')
                    ->leftJoin('veiculos', 'veiculos.id', 'ordem_servicos.veiculo_id')
                    ->leftJoin('clientes',         'clientes.id', 'veiculos.cliente_id')
                    ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                    ->where('clientes.id',$cliente->id)
                    ->whereRaw('((ordem_servicos.ordem_servico_status_id = '.(isset($request->ordem_servico_status_id) ? $request->ordem_servico_status_id : -1).') or ('.(isset($request->ordem_servico_status_id) ? $request->ordem_servico_status_id : -1).' = -1))')
                    ->whereRaw($whereData)
                    ->whereRaw($whereParam)
                    //->whereRaw($whereTipoAbastecimento)
                    ->orderBy('departamentos.departamento', 'asc')
                    ->distinct()
                    ->get();
            $cliente->departamentos = $departamentos;
           //dd($cliente->departamentos);
            foreach($cliente->departamentos as $departamento) {
                $ordemservicos = DB::table('ordem_servicos')
                        ->select('veiculos.placa','ordem_servicos.*')
                        ->leftJoin('veiculos', 'veiculos.id', 'ordem_servicos.veiculo_id')
                        ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                        ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                        ->whereRaw('clientes.id is not null')
                        ->whereRaw('((ordem_servicos.ordem_servico_status_id = '.(isset($request->ordem_servico_status_id) ? $request->ordem_servico_status_id : -1).') or ('.(isset($request->ordem_servico_status_id) ? $request->ordem_servico_status_id : -1).' = -1))')
                        ->whereRaw($whereData)
                        ->whereRaw($whereParam)
                        //->whereRaw($whereTipoAbastecimento)
                        ->where('departamentos.id', $departamento->id)
                        ->orderby('ordem_servicos.created_at')
                        //->groupBy('veiculos.placa')
                        ->get();
                        //->toSql();
                        
                $departamento->ordemservicos = $ordemservicos;
               // dd($departamento->ordemservicos);
            }
        }
        
       return View('relatorios.ordem_servicos.relatorio_ordem_servicos')->withClientes($clientes)->withTitulo('Relatório de Ordem de Serviços - Sintético')->withParametros($parametros)->withParametro(Parametro::first());
    } else {
        /* relatório Analítico */
        foreach($clientes as $cliente) {
            $departamentos = DB::table('abastecimentos')
                    ->select('departamentos.*')
                    ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                    ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                    ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                    ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                    ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                    ->whereRaw('clientes.id is not null')
                    ->whereRaw('((abastecimentos.abastecimento_local = '.(isset($request->abast_local) ? $request->abast_local : -1).') or ('.(isset($request->abast_local) ? $request->abast_local : -1).' = -1))')
                    ->whereRaw($whereData)
                    ->whereRaw($whereParam)
                    ->whereRaw($whereTipoAbastecimento)
                    ->where('clientes.id', $cliente->id)
                    ->orderBy('departamentos.departamento', 'asc')
                    ->distinct()
                    ->get();
            $cliente->departamentos = $departamentos;
            foreach($cliente->departamentos as $departamento) {
                $ordemservicos = DB::table('abastecimentos')
                        ->select('abastecimentos.*', 'veiculos.placa')
                        ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                        ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                        ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                        ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                        ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                        ->whereRaw('clientes.id is not null')
                        ->whereRaw('((abastecimentos.abastecimento_local = '.(isset($request->abast_local) ? $request->abast_local : -1).') or ('.(isset($request->abast_local) ? $request->abast_local : -1).' = -1))')
                        ->whereRaw($whereData)
                        ->whereRaw($whereParam)
                        ->whereRaw($whereTipoAbastecimento)
                        ->where('departamentos.id', $departamento->id)
                        ->orderBy('veiculos.placa', 'asc')
                        ->orderBy('abastecimentos.data_hora_abastecimento', 'desc')
                        /* ->orderBy('abastecimentos.id', 'desc') */
                        ->distinct()
                        ->get();
                $departamento->ordemservicos = $abastecimentos;
            }
        }
         return View('relatorios.abastecimentos.relatorio_abastecimentos_analitico')->withClientes($clientes)->withTitulo('Relatório de Abastecimentos - Analítico')->withParametros($parametros)->withParametro(Parametro::first());
    }
}

}
