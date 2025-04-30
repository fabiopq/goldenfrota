<?php

namespace App\Http\Controllers;

use App\Atendente;
use App\Autorizacao;
use App\Bico;
use App\Cliente;
use App\Motorista;
use App\PostoAbastecimento;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AutorizacaoController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'data_autorizacao' => ['label' => 'Data/Hora', 'type' => 'datetime'],

        'num_bico' => 'Bico',
        'placa' => 'Veículo',
        'km_veiculo' => ['label' => 'Odômetro', 'type' => 'decimal', 'decimais' => 1],
        'nome_atendente' => 'Atendente',
        'nome' => 'Motorista',


    );

    public function index(Request $request)
    {

        // $autorizacoes = Autorizacao::where('ativo', true)->get();
        if (Auth::user()->canListarAutorizacao()) {



            $data_inicial = $request->data_inicial;
            $data_final = $request->data_final;

            if ($data_inicial && $data_final) {
                $whereData = 'autorizacoes.data_autorizacao between \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s') . '\' and \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s') . '\'';
            } elseif ($data_inicial) {
                $whereData = 'autorizacoes.data_autorizacao >= \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s') . '\'';
            } elseif ($data_final) {
                $whereData = 'autorizacoes.data_autorizacao <= \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s') . '\'';
            } else {
                $whereData = '1 = 1'; //busca qualquer coisa
            }

            if (isset($request->searchField)) {
            } else {
                $autorizacoes = DB::table('autorizacoes')
                    ->select('autorizacoes.*', 'bicos.num_bico', 'veiculos.placa', 'atendentes.nome_atendente', 'motoristas.nome')
                    ->leftJoin('bicos', 'bicos.id', 'autorizacoes.bico_id')
                    ->leftJoin('veiculos', 'veiculos.id', 'autorizacoes.veiculo_id')
                    ->leftJoin('atendentes', 'atendentes.id', 'autorizacoes.atendente_id')
                    ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                    ->leftJoin('motoristas', 'motoristas.id', 'autorizacoes.motorista_id')
                    ->whereRaw($whereData)

                    ->orderBy('autorizacoes.data_autorizacao', 'desc')
                    ->paginate();
            }


            return View('autorizacao.index', [
                'autorizacoes' => $autorizacoes->appends(Input::except('page')),
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


        if (Auth::user()->canCadastrarAutorizacao()) {

            $bicos = Bico::select(
                DB::raw("concat('Bico: ', bicos.num_bico, ' - ',combustiveis.descricao,' - Posto: ', posto_abastecimentos.nome) as num_bico"),
                'bicos.id'
            )
                ->join('tanques', 'tanques.id', 'bicos.tanque_id')
                ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                ->join('posto_abastecimentos', 'posto_abastecimentos.id', 'tanques.posto_abastecimento_id')

                ->where('tanques.ativo', true)
                ->get();
            $atendentes = Atendente::where('ativo', true)
                ->get();
            $motoristas = Motorista::where('ativo', true)
                ->get();
            $clientes = Cliente::where('ativo', true)->get();

            return View('autorizacao.create', [

                'clientes' => $clientes,
                'bicos' => $bicos,
                'atendentes' => $atendentes,
                'motoristas' => $motoristas,

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


        if (Auth::user()->canCadastrarAutorizacao()) {
            /*$this->validate($request, [

                'veiculo_id' => 'required',
                'bico_id' => 'required',
            ]);
*/
            $validator = Validator::make($request->all(), [
                'veiculo_id' => 'required',
                'bico_id' => 'required',
            ]);
            
            $validator->after(function ($validator) use ($request) {
                $existe = DB::table('autorizacoes')
                    ->where('veiculo_id', $request->veiculo_id)
                    ->where('bico_id', $request->bico_id)
                    ->whereNull('data_encerramento')
                    ->exists();
            
                if ($existe) {
                    $validator->errors()->add('bico_id', 'Já existe uma autorização ativa para este bico e veículo.');
                }
            });
            
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            try {
                $autorizacao = new Autorizacao($request->all());

                if ($autorizacao->save()) {
                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.autorizacao'),
                        'name' => $autorizacao->num_bico
                    ]));
                    return redirect()->action('AutorizacaoController@index');
                }
            } catch (\Exception $e) {
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return redirect()->back()->withInput();
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bico  $bico
     * @return \Illuminate\Http\Response
     */
    public function edit(Autorizacao $autorizacao)
    {

        if (Auth::user()->canAlterarAutorizacao()) {

            $cliente = Cliente::select('clientes.id')
                ->leftJoin('veiculos', 'veiculos.cliente_id', 'clientes.id')
                ->where('veiculos.id', $autorizacao->veiculo_id)
                ->get()->first();

            $bicos = Bico::select(
                DB::raw("concat('Bico: ', bicos.num_bico, ' - ',combustiveis.descricao,' - Posto: ', posto_abastecimentos.nome) as num_bico"),
                'bicos.id'
            )
                ->join('tanques', 'tanques.id', 'bicos.tanque_id')
                ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                ->join('posto_abastecimentos', 'posto_abastecimentos.id', 'tanques.posto_abastecimento_id')

                ->where('tanques.ativo', true)
                ->get();
            $atendentes = Atendente::where('ativo', true)
                ->get();
            $motoristas = Motorista::where('ativo', true)
                ->get();
            $postos = PostoAbastecimento::where('ativo', true)
                ->get();

            $clientes = Cliente::where('ativo', true)->get();

            return View('autorizacao.edit')
                ->withAutorizacao($autorizacao)
                ->withAtendentes($atendentes)
                ->withMotoristas($motoristas)
                ->withBicos($bicos)
                ->withCliente($cliente)
                ->withClientes($clientes);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bico  $bico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Autorizacao $autorizacao)
    {
        if (Auth::user()->canAlterarAutorizacao()) {
            $validator = Validator::make($request->all(), [
                'veiculo_id' => 'required',
                'bico_id' => 'required',
            ]);
            
            $validator->after(function ($validator) use ($request) {
                $existe = DB::table('autorizacoes')
                    ->where('veiculo_id', $request->veiculo_id)
                    ->where('bico_id', $request->bico_id)
                    ->whereNull('data_encerramento')
                    ->exists();
            
                if ($existe) {
                    $validator->errors()->add('bico_id', 'Já existe uma autorização ativa para este bico e veículo.');
                }
            });
            
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }


            try {
                $autorizacao->fill($request->all());


                if ($autorizacao->save()) {
                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.autorizacao'),
                        'name' => $autorizacao->num_bico
                    ]));
                    return redirect()->action('AutorizacaoController@index');
                }
            } catch (\Exception $e) {
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));

                return redirect()->back()->withInput();
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bico  $bico
     * @return \Illuminate\Http\Response
     */
    public function destroy(Autorizacao $autorizacao)
    {
        if (Auth::user()->canExcluirAutorizacao()) {
            try {
                if ($autorizacao->delete()) {
                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.autorizacao'),
                        'name' => $autorizacao->num_bico
                    ]));

                    return redirect()->action('AutorizacaoController@index');
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
                return redirect()->action('AutorizacaoController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back()->withInput();
        }
    }
}
