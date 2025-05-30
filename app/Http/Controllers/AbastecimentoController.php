<?php

namespace App\Http\Controllers;

use App\Bico;
use App\Cliente;
use App\Veiculo;
use App\Afericao;
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
use App\Motorista;
use App\MovimentacaoCredito;
use App\PostoAbastecimento;
use App\PrecoCliente;
use App\Tanque;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use phpDocumentor\Reflection\Types\Boolean;

use function Psy\bin;

class AbastecimentoController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'num_bico' => 'Bico',
        'data_hora_abastecimento' => ['label' => 'Data/Hora', 'type' => 'datetime'],
        'volume_abastecimento' => ['label' => 'Qtd. Abast.', 'type' => 'decimal', 'decimais' => 2],
        'valor_litro' => ['label' => 'Valor Litro', 'type' => 'decimal', 'decimais' => 3],
        'valor_abastecimento' => ['label' => 'Valor Total', 'type' => 'decimal', 'decimais' => 3],
        'placa' => 'Veículo',
        'km_veiculo' => ['label' => 'Odômetro', 'type' => 'decimal', 'decimais' => 1],
        'media_veiculo' => ['label' => 'Média', 'type' => 'decimal', 'decimais' => 2],
        //'posto_abastecimentos_id' => 'Posto id',
        'posto' => 'Posto de Abastecimentos',
        'nome_atendente' => 'Atendente',
        'nome' => 'Motorista',
        'abastecimento_local' => ['label' => 'Abast. Local', 'type' => 'bool'],
        'eh_afericao' => ['label' => 'Aferição', 'type' => 'bool']
        //'ativo' => ['label' => 'Ativo', 'type' => 'bool'],

    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $posto_abastecimentos = PostoAbastecimento::where('ativo', true)->get();
        if (Auth::user()->canListarAbastecimento()) {


            $posto_abastecimentos_id = isset($request->posto_abastecimentos_id) ? $request->posto_abastecimentos_id : -1;
            if (is_null($posto_abastecimentos_id)) {

                $posto_abastecimentos_id = -1;
            }

            $data_inicial = $request->data_inicial;
            $data_final = $request->data_final;

            if ($data_inicial && $data_final) {
                $whereData = 'abastecimentos.data_hora_abastecimento between \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s') . '\' and \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s') . '\'';
            } elseif ($data_inicial) {
                $whereData = 'abastecimentos.data_hora_abastecimento >= \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s') . '\'';
            } elseif ($data_final) {
                $whereData = 'abastecimentos.data_hora_abastecimento <= \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s') . '\'';
            } else {
                $whereData = '1 = 1'; //busca qualquer coisa
            }

            if (isset($request->searchField)) {
                $abastecimentos = DB::table('abastecimentos')
                    ->select('abastecimentos.*', 'bicos.num_bico', 'veiculos.placa', 'atendentes.nome_atendente', 'motoristas.nome', 'posto_abastecimentos.nome as posto')
                    ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                    ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                    ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                    ->leftJoin('motoristas', 'motoristas.id', 'abastecimentos.motorista_id')
                    ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                    ->leftJoin('posto_abastecimentos', 'posto_abastecimentos.id', 'abastecimentos.posto_abastecimentos_id')
                    ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
                    ->whereRaw('((abastecimentos.posto_abastecimentos_id = ' . $posto_abastecimentos_id . ') or (' .  $posto_abastecimentos_id . ' = -1))')
                    ->whereRaw($whereData)
                    ->where('veiculos.placa', 'like', '%' . $request->searchField . '%')
                    //->orWhere('clientes.nome_razao', 'like', '%' . $request->searchField . '%')
                    ->orWhere('atendentes.nome_atendente', 'like', '%' . $request->searchField . '%')
                    ->orWhere('posto_abastecimentos.nome', 'like', '%' . $request->searchField . '%')
                    /* ->orderBy('abastecimentos.id', 'desc') */
                    ->orderBy('abastecimentos.data_hora_abastecimento', 'desc')
                    ->paginate();
            } else {
                $abastecimentos = DB::table('abastecimentos')
                    ->select('abastecimentos.*', 'bicos.num_bico', 'veiculos.placa', 'atendentes.nome_atendente', 'motoristas.nome', 'posto_abastecimentos.nome as posto')
                    ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                    ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                    ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                    ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                    ->leftJoin('motoristas', 'motoristas.id', 'abastecimentos.motorista_id')
                    ->leftJoin('posto_abastecimentos', 'posto_abastecimentos.id', 'abastecimentos.posto_abastecimentos_id')
                    ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
                    ->whereRaw('((abastecimentos.posto_abastecimentos_id = ' . $posto_abastecimentos_id . ') or (' .  $posto_abastecimentos_id . ' = -1))')
                    ->whereRaw($whereData)
                    /* ->orderBy('abastecimentos.id', 'desc') */
                    ->orderBy('abastecimentos.data_hora_abastecimento', 'desc')
                    ->paginate();
            }


            return View('abastecimento.index', [
                'abastecimentos' => $abastecimentos->appends(Input::except('page')),
                'posto_abastecimentos' => $posto_abastecimentos,

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


        if (Auth::user()->canCadastrarAbastecimento()) {

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

            //$clientes = Cliente::where('ativo', true)->get();
            $clientes = Cliente::get();

            // $bicos = Bico::where('permite_insercao', true)->where('ativo', true)->get();
            // return View('abastecimento.create')->withClientes($clientes)->withBicos($bicos);
            return View('abastecimento.create', [

                'clientes' => $clientes,
                'bicos' => $bicos,
                'atendentes' => $atendentes,
                'motoristas' => $motoristas,
                'postos' => $postos
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

        if (Auth::user()->canCadastrarAbastecimento()) {

            $this->validate($request, [
                'data_hora_abastecimento' => 'required|date_format:d/m/Y H:i:s',
                'cliente_id' => 'required_if:eh_afericao,false|required_without:eh_afericao',
                'veiculo_id' => 'required_if:eh_afericao,false|required_without:eh_afericao',
                'km_veiculo' => 'required_if:eh_afericao,false|required_without:eh_afericao',
                'volume_abastecimento' => 'required|numeric|min:0',
                'valor_litro' => 'required|numeric|min:0',
                'valor_abastecimento' => 'required|numeric|min:0',
                'bico_id' => 'required_if:eh_afericao,true'
            ]);


            try {
                DB::beginTransaction();

                $abastecimento = new Abastecimento;
                $abastecimento->data_hora_abastecimento = \DateTime::createFromFormat('d/m/Y H:i:s', $request->data_hora_abastecimento)->format('Y-m-d H:i:s');
                $abastecimento->veiculo_id = $request->veiculo_id;
                $abastecimento->km_veiculo = $request->km_veiculo;
                $abastecimento->volume_abastecimento = str_replace(',', '.', $request->volume_abastecimento);
                $abastecimento->valor_litro = str_replace(',', '.', $request->valor_litro);
                $abastecimento->valor_abastecimento = str_replace(',', '.', $request->valor_abastecimento);
                $abastecimento->abastecimento_local = false;
                $abastecimento->bico_id = $request->bico_id;
                $abastecimento->encerrante_inicial = $request->encerrante_inicial;
                $abastecimento->encerrante_final = $request->encerrante_final;
                $abastecimento->atendente_id = $request->atendente_id;
                $abastecimento->motorista_id = $request->motorista_id;
                $abastecimento->posto_abastecimentos_id = $request->posto_abastecimentos_id;
                $abastecimento->abastecimento_local = 1;

                $abastecimento->abastecimento_local = (bool)$request->abastecimento_local;


                $preco = DB::table('combustiveis')
                    ->select('combustiveis.valor')
                    ->leftJoin('tanques', 'tanques.combustivel_id', 'combustiveis.id')
                    ->leftJoin('bicos', 'bicos.tanque_id', 'tanques.id')
                    ->where('bicos.id', '=', trim($request->bico_id))
                    ->first();

                if (!$preco) {
                } else {
                    $abastecimento->custo_litro = $preco->valor;
                }


                /* Calcula a média do veículo, caso seja informado um veículo */

                if ($request->veiculo_id) {
                    $abastecimento->media_veiculo = $this->obterMediaVeiculo(Veiculo::find($request->veiculo_id), $abastecimento, false);
                } else {
                    $abastecimento->media_veiculo = 0;
                }
                $abastecimento->eh_afericao = (bool)$request->eh_afericao;

                if ($abastecimento->save()) {

                    VeiculoController::atualizaKmVeiculo(Veiculo::find($request->veiculo_id), $abastecimento, false);


                    if ($request->bico_id) {

                        /* Se for aferição, faz a movimentação de saída e entrada por aferição */
                        if (isset($request->eh_afericao) && ($request->eh_afericao)) {

                            $afericao = Afericao::create([
                                'abastecimento_id' => $abastecimento->id,
                                'user_id' => Auth::user()->id
                            ]);

                            // Executa movimentação apenas se abastecimento_local for verdadeiro
                            if ($abastecimento->abastecimento_local) {
                                MovimentacaoCombustivelController::cadastroAfericao($afericao);
                            }

                            //MovimentacaoCombustivelController::cadastroAfericao($afericao);
                        } else {
                            /* Se informado o bico, movimenta o estoque do tanque */

                            MovimentacaoCreditoController::saidaCredito2($abastecimento);
                            if ($abastecimento->abastecimento_local) {
                                MovimentacaoCombustivelController::saidaAbastecimento($abastecimento);
                            }
                            //MovimentacaoCombustivelController::saidaAbastecimento($abastecimento);
                        }

                        // Atualiza encerrante apenas se abastecimento_local for verdadeiro
                        if ($abastecimento->abastecimento_local) {
                            if (!BicoController::atualizarEncerranteBico($request->bico_id, $request->encerrante_final)) {
                                throw new \Exception(__('messages.exception', [
                                    'exception' => 'Não foi possível atualizar o encerrante do bico'
                                ]));
                            }
                        }
                    }

                    //Log::debug('Abastecimento Inserido: '.$abastecimento);

                    DB::commit();

                    event(new NovoAbastecimento($abastecimento));

                    //Ajusta médias futuras
                    if (!$this->ajustarMediaAbastecimentosFuturos($abastecimento)) {
                        throw new \Exception(__('messages.exception', [
                            'exception' => 'Não foi possível atualizar as médias futuras do veículo'
                        ]));
                    }

                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.abastecimento'),
                        'name' => $abastecimento->id
                    ]));
                    return redirect()->action('AbastecimentoController@index');
                }
            } catch (\Exception $e) {
                DB::rollback();
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return Redirect::back()->withInput(Input::all());
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Abastecimento  $abastecimento
     * @return \Illuminate\Http\Response
     */
    public function edit(Abastecimento $abastecimento)
    {
        if (Auth::user()->canAlterarAbastecimento()) {
            $abastecimento = Abastecimento::find($abastecimento->id);

            $cliente = Cliente::select('clientes.id')
                ->leftJoin('veiculos', 'veiculos.cliente_id', 'clientes.id')
                ->where('veiculos.id', $abastecimento->veiculo_id)
                ->get()->first();

            $clientes = Cliente::select('clientes.*')
                ->leftJoin('veiculos', 'veiculos.cliente_id', 'clientes.id')
                ->where('clientes.ativo', true)
                ->orWhere('veiculos.id', $abastecimento->veiculo_id)
                ->distinct()
                ->get();

            $bicos = Bico::where('ativo', true)
                ->orWhere('id', $abastecimento->bico_id)
                ->get();

            $veiculos = Veiculo::where('ativo', true)
                ->orWhere('id', $abastecimento->veiculo_id)
                ->get();

            $atendentes = Atendente::where('ativo', true)
                ->orWhere('id', $abastecimento->atendente_id)
                ->get();
            $motoristas = Motorista::where('ativo', true)
                ->orWhere('id', $abastecimento->motorista_id)
                ->get();

            return View('abastecimento.edit', [
                'abastecimento' => $abastecimento,
                'clientes' => $clientes,
                'cliente' => $cliente,
                'bicos' => $bicos,
                'veiculos' => $veiculos,
                'atendentes' => $atendentes,
                'motoristas' => $motoristas
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
     * @param  \App\Abastecimento  $abastecimento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Abastecimento $abastecimento)
    {
        if (Auth::user()->canAlterarAbastecimento()) {
            /* Se for aferição não é permitido alteração, direciona de volta a tela de consulta */
            if ($abastecimento->eh_afericao) {
                return redirect()->action('AbastecimentoController@index');
            }
            //utiliza o volume anterior a alteração para realizar a entrar e posteriormente a saida da nova quatidade
            $volume_old = $abastecimento->volume_abastecimento;
            $this->validate($request, [
                'data_hora_abastecimento' => 'required|date_format:d/m/Y H:i:s',
                'veiculo_id' => 'required|numeric|',
                //'km_veiculo' => 'required|numeric|min:0',
                //'volume_abastecimento' => 'required|numeric|min:0',
                'valor_litro' => 'required|numeric|min:0',
                'valor_abastecimento' => 'required|numeric|min:0',
                'atendente_id' => 'required_with:id_automacao'
            ]);

            try {

                $abastecimento->veiculo_id = $request->veiculo_id;
                $abastecimento->data_hora_abastecimento = \DateTime::createFromFormat('d/m/Y H:i:s', $request->data_hora_abastecimento)->format('Y-m-d H:i:s');

                $abastecimento->km_veiculo = $request->km_veiculo;
                $abastecimento->volume_abastecimento = str_replace(',', '.', $request->volume_abastecimento);
                $abastecimento->valor_litro = str_replace(',', '.', $request->valor_litro);
                $abastecimento->valor_abastecimento = str_replace(',', '.', $request->valor_abastecimento);

                $abastecimento->media_veiculo = $this->obterMediaVeiculo(Veiculo::find($request->veiculo_id), $abastecimento, true);

                $abastecimento->atendente_id = $request->atendente_id;
                $abastecimento->motorista_id = $request->motorista_id;
                //$abastecimento->bico_id = $request->bico_id;
                //$abastecimento->encerrante_inicial= $request->encerrante_inicial;
                //$abastecimento->encerrante_final = $request->encerrante_final;
                $abastecimento->inconsistencias_importacao = $this->existemInconsisteciasImportacao($abastecimento);

                if ($abastecimento->inconsistencias_importacao) {
                    $abastecimento->obs_abastecimento = 'Ainda existem inconsistências relacionadas a importação deste abastecimento. Verifique.';
                } else {
                    $abastecimento->obs_abastecimento = '';
                }
                $abastecimento->obs_abastecimento = 'Alteração de Volume de ' . $volume_old . ' para ' . $abastecimento->volume_abastecimento;

                /*
                if ($abastecimento->abastecimento_local) {
                    DB::transaction(function () use ($abastecimento) {
                        $movimentacao = TanqueMovimentacao::find($abastecimento->tanque_movimentacao_id);
                
                        if (!$movimentacao) {
                            throw new \Exception('Movimentação de tanque não encontrada para o abastecimento ' . $abastecimento->id);
                        }
                
                        $movimentacao->quantidade_combustivel = $abastecimento->volume_abastecimento;
                        $movimentacao->save();
                        $abastecimento->save();
                    });
                
                    Session::flash('success', 'Abastecimento ' . $abastecimento->id . ' alterado com sucesso.');
                    return redirect()->action('AbastecimentoController@index');
                } else {
                    */

                if ($abastecimento->save()) {
                    VeiculoController::atualizaKmVeiculo(Veiculo::find($request->veiculo_id), $abastecimento, true);
                    if ($abastecimento->abastecimento_local) {
                        if ($volume_old != $abastecimento->volume_abastecimento) {
                            MovimentacaoCombustivelController::saidaAbastecimentoAjuste($abastecimento);
                            $abastecimento->volume_abastecimento = $volume_old;
                            MovimentacaoCombustivelController::entradaAbastecimentoAuste($abastecimento);
                        }
                    }

                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.abastecimento'),
                        'name' => $abastecimento->id
                    ]));
                    //return redirect(url()->previous());

                    return redirect()->action('AbastecimentoController@index', $request->query->all() ?? []);
                } else {
                    Session::flash('error', __('messages.update_error', [
                        'model' => 'models.abastecimento',
                        'name' => $abastecimento->id
                    ]));

                    return redirect()->back()->withInput();
                }
                // }
            } catch (\Exception $e) {
                Log::error($e);
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return redirect()->back();
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Abastecimento  $abastecimento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Abastecimento $abastecimento)
    {
        if (Auth::user()->canExcluirAbastecimento()) {
            try {
                $abastecimento = Abastecimento::find($abastecimento->id);
                if ($abastecimento->abastecimento_local) {
                    //abastecimento local, tem movimentação de estoque. Remove a movimentação e a abastecida
                    $movimentacao = TanqueMovimentacao::find($abastecimento->tanque_movimentacao_id);
                    if ($movimentacao) {
                        if ($movimentacao->delete()) {
                            Session::flash('success', __('messages.delete_success', [
                                'model' => __('models.abastecimento'),
                                'name' => $abastecimento->id
                            ]));

                            return redirect()->action('AbastecimentoController@index', json_decode($request->backUrlParams, true));
                        }
                    } else {
                        //abastecimento local, porém não tem movimentação de estoque... pq???
                        return $this->removeAbastecimento($abastecimento);
                    }
                } else {
                    //abastecimento externo, não tem movimentação de estoque, por isso remove somente a abastecida
                    return $this->removeAbastecimento($abastecimento);
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
                return redirect()->action('AbastecimentoController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    protected function removeAbastecimento(Abastecimento $abastecimento)
    {
        if ($abastecimento->delete()) {
            Session::flash('success', __('messages.delete_success', [
                'model' => __('models.abastecimento'),
                'name' => $abastecimento->id
            ]));

            return redirect()->action('AbastecimentoController@index');
        }
    }

    protected function existemInconsisteciasImportacao(Abastecimento $abastecimento)
    {
        if ($abastecimento->abastecimento_local) {
            if (!$abastecimento->bico_id) {
                return true;
            }
            if (!$abastecimento->veiculo_id) {
                return true;
            }
            if (!$abastecimento->atendente_id) {
                return true;
            }
            if ($abastecimento->km_veiculo <= 0) {
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function obterMediaVeiculo(Veiculo $veiculo, Abastecimento $abastecimentoAtual, $ehUpdate = false)
    {

        try {
            if (App::environment('local')) {
                Log::debug('AbastecimentoController::obterMediaVeiculo');
            }
            if ($ehUpdate) {
                $ultimoAbastecimento =  $this->ObterUltimoAbastecimentoVeiculo($veiculo, $abastecimentoAtual);
            } else {
                $ultimoAbastecimento = $this->ObterUltimoAbastecimentoVeiculo($veiculo);
            }

            if (App::environment('local')) {
                Log::debug('obterMediaVeiculo - ehUpdate => ' . ($ehUpdate) ? 'Sim' : 'Não');
                Log::debug('obterMediaVeiculo - ultimoAbastecimento => ' . $ultimoAbastecimento);
            }

            if (!$ultimoAbastecimento) {
                //primeiro abastecimento deste veiculo;
                Log::debug('obterMediaVeiculo - primeiro abastecimento do veículo, não é possível calcular média.');
                return 0;
            } else {
                //veiculo já abasteceu antes

                if ($veiculo->modelo_veiculo->tipo_controle_veiculo_id == 1) {
                    if (App::environment('local')) {
                        Log::debug('obterMediaVeiculo - Controle por KM');
                    }
                    /* controle de km rodados */
                    if ($abastecimentoAtual->km_veiculo > 0) {
                        //km informada
                        if (App::environment('local')) {
                            Log::debug('obterMediaVeiculo - KM informado > 0');
                            Log::debug('obterMediaVeiculo - abastecimentoAtual->km_veiculo => ' . $abastecimentoAtual->km_veiculo);
                            Log::debug('obterMediaVeiculo - ultimoAbastecimento->km_veiculo => ' . $ultimoAbastecimento->km_veiculo);
                            Log::debug('obterMediaVeiculo - abastecimentoAtual->volume_abastecimento => ' . $abastecimentoAtual->volume_abastecimento);
                            Log::debug('obterMediaVeiculo - Média calculada => ' . ($abastecimentoAtual->km_veiculo - $ultimoAbastecimento->km_veiculo) / $abastecimentoAtual->volume_abastecimento);
                        }
                        if (($abastecimentoAtual->km_veiculo == $ultimoAbastecimento->km_veiculo) && (!$ehUpdate)) {
                            Log::debug('Odômetro/Horímetro informado igual ao do último abastecimento');
                            return 0;
                            // throw new \Exception('Odômetro/Horímetro informado igual ao do último abastecimento');
                        }
                        return ($abastecimentoAtual->km_veiculo - $ultimoAbastecimento->km_veiculo) / $abastecimentoAtual->volume_abastecimento;
                    } else {
                        //km não informada
                        return 0;
                    }
                } else {

                    /* controle de horas trabalhadas */
                    if ($abastecimentoAtual->km_veiculo > 0) {
                        //horas trabalhadas informada
                        if (App::environment('local')) {
                            Log::debug('obterMediaVeiculo - Controle por Horas trabalhadas');
                        }
                        if (($abastecimentoAtual->km_veiculo == $ultimoAbastecimento->km_veiculo) && (!$ehUpdate)) {
                            Log::debug('Odômetro/Horímetro informado igual ao do último abastecimento');
                            return 0;
                            // throw new \Exception('Odômetro/Horímetro informado igual ao do último abastecimento');
                        }
                        return $abastecimentoAtual->volume_abastecimento / ($abastecimentoAtual->km_veiculo - $ultimoAbastecimento->km_veiculo);
                    } else {
                        //horas trabalhadas não informada
                        return 0;
                    }
                }
            }
        } catch (\Exception $e) {
            // Log::debug($e);
            throw new \Exception($e->getMessage());
        }
    }

    public function parametrosRelatorio()
    {
        $clientes = Cliente::all();
        $posto_abastecimentos = PostoAbastecimento::all();
        $departamentos = Departamento::all();

        $veiculos = Veiculo::select(DB::raw("concat(veiculos.placa, ' - ', marca_veiculos.marca_veiculo, ' ', modelo_veiculos.modelo_veiculo) as veiculo"), 'veiculos.id')
            ->join('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
            ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
            ->where('veiculos.ativo', true)
            ->get();

        return View('abastecimento.relatorio_param')->withClientes($clientes)->withVeiculos($veiculos)->withPostos($posto_abastecimentos)->withDepartamentos($departamentos);
    }

    public function relatorioAbastecimentos(Request $request)
    {

        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $parametros = array();

        if ($data_inicial && $data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento between \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s') . '\' and \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s') . '\'';
            array_push($parametros, 'Período de ' . $data_inicial . ' até ' . $data_final);
        } elseif ($data_inicial) {
            $whereData = 'abastecimentos.data_hora_abastecimento >= \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s') . '\'';
            array_push($parametros, 'A partir de ' . $data_inicial);
        } elseif ($data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento <= \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s') . '\'';
            array_push($parametros, 'Até ' . $data_final);
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
        $posto_abastecimento_id = $request->posto_abastecimento_id;

        /*
        if ($veiculo_id > 0) {
            $whereParam = 'veiculos.id = ' . $veiculo_id;
        } else {
            if ($departamento_id > 0) {
                $whereParam = 'veiculos.departamento_id = ' . $departamento_id;
            } else {
                if ($cliente_id > 0) {
                    $whereParam = 'veiculos.cliente_id = ' . $cliente_id;
                } else {
                    $whereParam = '1 = 1';
                }
            }
        }

        if ($posto_abastecimento_id > 0) {
            $whereParam = 'posto_abastecimentos_id = ' . $posto_abastecimento_id;
        } else {
            if ($departamento_id > 0) {
                $whereParam = 'veiculos.departamento_id = ' . $departamento_id;
            } else {
                if ($cliente_id > 0) {
                    $whereParam = 'veiculos.cliente_id = ' . $cliente_id;
                } else {
                    $whereParam = '1 = 1';
                }
            }
        }
*/
        if ($cliente_id > 0) {
            array_push($parametros, 'Cliente: ' . Cliente::find($cliente_id)->nome_razao);
            $whereParam = 'clientes.id = ' . $cliente_id;
        }

        if ($departamento_id > 0) {
            array_push($parametros, 'Departamento: ' . Departamento::find($departamento_id)->departamento);
            if (empty($whereParam)) {
                $whereParam =  ' veiculos.departamento_id = ' . $departamento_id;
            } else {
                $whereParam = $whereParam . ' and veiculos.departamento_id = ' . $departamento_id;
            }
        }

        if ($veiculo_id > 0) {
            //array_push($parametros, 'Veículo: ' . Veiculo::find($veiculo_id)->placa);
            if (empty($whereParam)) {
                $whereParam =  ' veiculos.id = ' . $veiculo_id;
            } else {
                $whereParam = $whereParam . ' and veiculos.id = ' . $veiculo_id;
            }
        }

        if ($posto_abastecimento_id > 0) {
            array_push($parametros, 'Posto de Abastecimentos: ' . PostoAbastecimento::find($posto_abastecimento_id)->nome);
            if (isset($whereParam)) {
                $whereParam = $whereParam . ' and posto_abastecimentos_id = ' . $posto_abastecimento_id;
            } else {
                array_push($parametros, 'Posto de Abastecimentos: Todos');
                $whereParam = 'posto_abastecimentos_id = ' . $posto_abastecimento_id;
            }
        }

        if (empty($whereParam)) {
            $whereParam = '1 = 1';
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

        $clientes = DB::table('abastecimentos')
            ->select('clientes.*')
            ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
            ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
            ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
            ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
            //->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
            ->where('abastecimentos.eh_afericao', false) 
            //->whereRaw('clientes.ativo = true')
            ->whereRaw('clientes.id is not null')
            ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
            
            ->whereRaw($whereData)
            ->whereRaw($whereParam)
            ->whereRaw($whereTipoAbastecimento)
            ->orderBy('clientes.nome_razao', 'asc')
            ->distinct()
            ->get();


        $clientesNullo = DB::table('abastecimentos')
            ->select(

                DB::raw('MIN(abastecimentos.km_veiculo) AS km_inicial'),
                DB::raw('MAX(abastecimentos.km_veiculo) AS km_final'),
                DB::raw('SUM(abastecimentos.volume_abastecimento) AS consumo'),
                DB::raw('SUM(abastecimentos.valor_abastecimento) AS valor'),
                DB::raw('AVG(abastecimentos.media_veiculo) AS media')
            )
            //->select('abastecimentos.*')
            ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
            ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
            ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
            ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
            ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
            ->where('abastecimentos.eh_afericao', false) 
            //->whereRaw('clientes.ativo = true')
            ->whereRaw('clientes.id is null')
            ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
            ->whereRaw($whereData)
            ->whereRaw($whereParam)
            ->whereRaw($whereTipoAbastecimento)
            ->groupBy('abastecimentos.veiculo_id')
            //->orderBy('clientes.nome_razao', 'asc')
            ->distinct()
            ->get();

        $clientesNulloAnalitico = DB::table('abastecimentos')
            ->select('abastecimentos.*')
            ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
            ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
            ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
            ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
            ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
            ->where('abastecimentos.eh_afericao', false) 
           // ->whereRaw('clientes.ativo = true')
            ->whereRaw('clientes.id is null')
            ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
            ->whereRaw($whereData)
            ->whereRaw($whereParam)
            ->whereRaw($whereTipoAbastecimento)

            // ->orderBy('clientes.nome_razao', 'asc')
            ->distinct()
            ->get();

        if ($request->tipo_relatorio == 1) {
            /* relatório Sintético */

            /*
            
            foreach ($clientes as $cliente) {


                $abastecimentos = DB::table('abastecimentos')
                    ->select(
                        'veiculos.placa',
                        DB::raw('MIN(abastecimentos.km_veiculo) AS km_inicial'),
                        DB::raw('MAX(abastecimentos.km_veiculo) AS km_final'),
                        DB::raw('SUM(abastecimentos.volume_abastecimento) AS consumo'),
                        DB::raw('SUM(abastecimentos.valor_abastecimento) AS valor'),
                        DB::raw('AVG(abastecimentos.media_veiculo) AS media')
                    )
                    ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                    ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                    ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                    ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                    ->leftJoin('posto_abastecimentos', 'posto_abastecimentos.id', 'abastecimentos.posto_abastecimentos_id')

                    //->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                    ->whereRaw('clientes.id is not null')
                    ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
                    ->whereRaw($whereData)
                    ->whereRaw($whereParam)
                    ->whereRaw($whereTipoAbastecimento)
                    ->where('veiculos.cliente_id', $cliente->id)
                    ->groupBy('veiculos.placa')
                    ->get();
                //->toSql();
//dd($abastecimentos);
                if ($abastecimentos) {
                    $cliente->abastecimentos = $abastecimentos;
                }
            }
*/
            //  $data_inicial_formatada = date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s');

            $data_inicial_formatada = date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s');
            $data_final_formatada = date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s');
            foreach ($clientes as $cliente) {
                $abastecimentos = DB::table('abastecimentos')
                    ->select(
                        'veiculos.placa',
                        'modelo_veiculos.modelo_veiculo',
                        'modelo_veiculos.tipo_controle_veiculo_id',
                        DB::raw('SUM(abastecimentos.volume_abastecimento) AS consumo'),
                        DB::raw('SUM(abastecimentos.valor_abastecimento) AS valor'),
                        DB::raw('AVG(abastecimentos.media_veiculo) AS media'),
                        DB::raw('COUNT(abastecimentos.id) AS total_abastecimentos'),
                        DB::raw('(SELECT a2.km_veiculo
                                  FROM abastecimentos AS a2
                                  WHERE a2.veiculo_id = abastecimentos.veiculo_id
                                    AND a2.data_hora_abastecimento BETWEEN "' . $data_inicial_formatada . '" AND "' . $data_final_formatada . '"
                                  ORDER BY a2.data_hora_abastecimento DESC
                                  LIMIT 1) AS km_final')
                    )
                    ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                    ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                    ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                    ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                    ->leftJoin('modelo_veiculos', 'veiculos.modelo_veiculo_id', 'modelo_veiculos.id')
                    ->leftJoin('posto_abastecimentos', 'posto_abastecimentos.id', 'abastecimentos.posto_abastecimentos_id')
                    /*
                    ->whereRaw('clientes.id is not null')
                    ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
                    ->whereRaw($whereData)
                    ->whereRaw($whereParam)
                    ->whereRaw($whereTipoAbastecimento)
                    ->where('veiculos.cliente_id', $cliente->id)
                    ->groupBy('veiculos.placa', 'veiculos.id', 'abastecimentos.veiculo_id', 'modelo_veiculos.modelo_veiculo', 'modelo_veiculos.tipo_controle_veiculo_id')
                    ->orderBy('veiculos.placa')
                    ->get();
                    */
                    
                    ->where('abastecimentos.eh_afericao', false) 
                   // ->whereRaw('clientes.ativo = true')
                    ->whereRaw('clientes.id is not null')
                    ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
                    ->whereRaw($whereData)
                    ->whereRaw($whereParam)
                    ->whereRaw($whereTipoAbastecimento)
                    ->where('veiculos.cliente_id', $cliente->id)
                    ->groupBy('veiculos.placa', 'veiculos.id', 'abastecimentos.veiculo_id', 'modelo_veiculos.modelo_veiculo', 'modelo_veiculos.tipo_controle_veiculo_id')
                    ->orderBy('veiculos.placa')
                    ->get();
                    

                foreach ($abastecimentos as $abastecimento) {
                    // Buscar valor inicial (km_veiculo) ANTES do período
                    $valor_inicial = DB::table('abastecimentos')
                        ->join('veiculos', 'veiculos.id', '=', 'abastecimentos.veiculo_id')
                        ->where('veiculos.placa', $abastecimento->placa)
                        ->where('abastecimentos.data_hora_abastecimento', '<', $data_inicial_formatada)
                        ->orderBy('abastecimentos.data_hora_abastecimento', 'desc')
                        ->value('km_veiculo');

                    // Se não houver antes, buscar o primeiro DENTRO do período
                    if (is_null($valor_inicial)) {
                        $valor_inicial = DB::table('abastecimentos')
                            ->join('veiculos', 'veiculos.id', '=', 'abastecimentos.veiculo_id')
                            ->where('veiculos.placa', $abastecimento->placa)
                            ->whereBetween('abastecimentos.data_hora_abastecimento', [$data_inicial_formatada, $data_final_formatada])
                            ->orderBy('abastecimentos.data_hora_abastecimento', 'asc')
                            ->value('km_veiculo');
                    }

                    $abastecimento->km_inicial = $valor_inicial ?? $abastecimento->km_final;

                    // Cálculo da média considerando tipo de controle
                    $diferenca = $abastecimento->km_final - $abastecimento->km_inicial;

                    if (
                        isset($abastecimento->km_inicial) &&
                        isset($abastecimento->km_final) &&
                        $diferenca > 0 &&
                        $abastecimento->consumo > 0
                    ) {
                        if ($abastecimento->tipo_controle_veiculo_id == 1) {
                            // Controle por KM - média em KM/L
                            $abastecimento->media = $diferenca / $abastecimento->consumo;
                        } elseif ($abastecimento->tipo_controle_veiculo_id == 2) {
                            // Controle por Horímetro - média em L/hora
                            $abastecimento->media = $abastecimento->consumo / $diferenca;
                        } else {
                            $abastecimento->media = null;
                        }
                    } else {
                        $abastecimento->media = null;
                    }
                }

                if ($abastecimentos) {
                    $cliente->abastecimentos = $abastecimentos;
                }
            }


            return View('relatorios.abastecimentos.relatorio_abastecimentos')->withClientes($clientes)->withClientesNullo($clientesNullo)->withTitulo('Relatório de Abastecimentos - Sintético')->withParametros($parametros)->withParametro(Parametro::first());
        } else if ($request->tipo_relatorio == 2) {
            /* relatório Analítico */

            /*  foreach ($clientes as $cliente) {



                $abastecimentos = DB::table('abastecimentos')
                    ->select('abastecimentos.*', 'veiculos.placa', 'posto_abastecimentos.nome')
                    ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                    ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                    ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                    ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                    ->leftJoin('posto_abastecimentos', 'posto_abastecimentos.id', 'abastecimentos.posto_abastecimentos_id')

                    //->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                    ->whereRaw('clientes.id is not null')
                    ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
                    ->whereRaw($whereData)
                    ->whereRaw($whereParam)
                    ->whereRaw($whereTipoAbastecimento)
                    ->where('veiculos.cliente_id', $cliente->id)
                    ->orderBy('veiculos.placa', 'asc')
                    ->orderBy('abastecimentos.data_hora_abastecimento', 'desc')
                    // ->orderBy('abastecimentos.id', 'desc') 
                    ->distinct()
                    ->get();
                $cliente->abastecimentos = $abastecimentos;
            }
            */
            foreach ($clientes as $cliente) {
                $abastecimentos = DB::table('abastecimentos')
                    ->select(
                        'abastecimentos.*',
                        'veiculos.placa',
                        'veiculos.modelo_veiculo_id',
                        'modelo_veiculos.tipo_controle_veiculo_id',
                        'posto_abastecimentos.nome'
                    )
                    ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                    ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                    ->leftJoin('modelo_veiculos', 'veiculos.modelo_veiculo_id', 'modelo_veiculos.id')
                    ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                    ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                    ->leftJoin('posto_abastecimentos', 'posto_abastecimentos.id', 'abastecimentos.posto_abastecimentos_id')
                    ->where('abastecimentos.eh_afericao', false) 
                    //->whereRaw('clientes.ativo = true')
                    ->whereRaw('clientes.id is not null')
                    ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
                    ->whereRaw($whereData)
                    ->whereRaw($whereParam)
                    ->whereRaw($whereTipoAbastecimento)
                    ->where('veiculos.cliente_id', $cliente->id)
                    ->orderBy('veiculos.placa', 'asc')
                    ->orderBy('abastecimentos.data_hora_abastecimento', 'desc')
                    ->distinct()
                    ->get();
                //dd($abastecimentos);
                foreach ($abastecimentos as $abastecimento) {
                    // Inicializa a propriedade para evitar erro na view
                    $abastecimento->media_calculada = null;

                    // Buscar o km anterior
                    $km_inicial = DB::table('abastecimentos')
                        ->join('veiculos', 'veiculos.id', '=', 'abastecimentos.veiculo_id')
                        ->where('veiculos.placa', $abastecimento->placa)
                        ->where('abastecimentos.data_hora_abastecimento', '<', $abastecimento->data_hora_abastecimento)
                        ->orderBy('abastecimentos.data_hora_abastecimento', 'desc')
                        ->value('km_veiculo');

                    // Se não houver valor anterior, usar o próprio km atual
                    if (is_null($km_inicial)) {
                        $km_inicial = $abastecimento->km_veiculo;
                    }

                    // Define o km_inicial para uso em exibição, se necessário
                    $abastecimento->km_inicial = $km_inicial;

                    // Cálculo da média
                    $diferenca = $abastecimento->km_veiculo - $km_inicial;

                    if (
                        isset($km_inicial) &&
                        isset($abastecimento->km_veiculo) &&
                        $diferenca > 0 &&
                        $abastecimento->volume_abastecimento > 0
                    ) {
                        if ($abastecimento->tipo_controle_veiculo_id == 1) {
                            // Controle por KM
                            $abastecimento->media_calculada = $diferenca / $abastecimento->volume_abastecimento;
                        } elseif ($abastecimento->tipo_controle_veiculo_id == 2) {
                            // Controle por Horímetro
                            $abastecimento->media_calculada = $abastecimento->volume_abastecimento / $diferenca;
                        }
                    }
                }

                $cliente->abastecimentos = $abastecimentos;
            }


            return View('relatorios.abastecimentos.relatorio_abastecimentos_analitico')->withClientes($clientes)->withClientesNulloAnalitico($clientesNulloAnalitico)->withTitulo('Relatório de Abastecimentos - Analítico')->withParametros($parametros)->withParametro(Parametro::first());
        } else if ($request->tipo_relatorio == 3) {
            foreach ($clientes as $cliente) {
                /* relatório Resumido */

                $abastecimentos = DB::table('abastecimentos')
                    ->select(
                        'clientes.id',
                        'clientes.nome_razao',
                        'clientes.limite',
                        DB::raw('MIN(abastecimentos.km_veiculo) AS km_inicial'),
                        DB::raw('MAX(abastecimentos.km_veiculo) AS km_final'),
                        DB::raw('SUM(abastecimentos.volume_abastecimento) AS consumo'),
                        DB::raw('SUM(abastecimentos.valor_abastecimento) AS valor'),
                        DB::raw('AVG(abastecimentos.media_veiculo) AS media')
                    )
                    ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                    ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                    ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                    ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                    //->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                    ->whereRaw('clientes.id is not null')
                    ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
                    ->whereRaw($whereData)
                    ->whereRaw($whereParam)
                    ->whereRaw($whereTipoAbastecimento)
                    ->where('veiculos.cliente_id', $cliente->id)
                    ->groupBy('clientes.id')
                    ->groupBy('clientes.nome_razao')
                    ->groupBy('clientes.limite')
                    ->get();
                //->toSql();

                if ($abastecimentos) {
                    $cliente->abastecimentos = $abastecimentos;
                }
            }


            return View('relatorios.abastecimentos.relatorio_abastecimentos_resumido')->withClientes($clientes)->withClientesNullo($clientesNullo)->withTitulo('Relatório de Abastecimentos - Sintético')->withParametros($parametros)->withParametro(Parametro::first());
        }
    }
    public function relatorioAbastecimentosDepartamento(Request $request)
    {

        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $parametros = array();

        if ($data_inicial && $data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento between \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s') . '\' and \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s') . '\'';
            array_push($parametros, 'Período de ' . $data_inicial . ' até ' . $data_final);
        } elseif ($data_inicial) {
            $whereData = 'abastecimentos.data_hora_abastecimento >= \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s') . '\'';
            array_push($parametros, 'A partir de ' . $data_inicial);
        } elseif ($data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento <= \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s') . '\'';
            array_push($parametros, 'Até ' . $data_final);
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
            $whereParam = 'veiculos.id = ' . $veiculo_id;
        } else {
            if ($departamento_id > 0) {
                $whereParam = 'veiculos.departamento_id = ' . $departamento_id;
            } else {
                if ($cliente_id > 0) {
                    $whereParam = 'veiculos.cliente_id = ' . $cliente_id;
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

        $clientes = DB::table('abastecimentos')
            ->select('clientes.*')
            ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
            ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
            ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
            ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
            ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
            ->whereRaw('clientes.id is not null')
            ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
            ->whereRaw($whereData)
            ->whereRaw($whereParam)
            ->whereRaw($whereTipoAbastecimento)
            ->orderBy('clientes.nome_razao', 'asc')
            ->distinct()
            ->get();

        $clientesNullo = DB::table('abastecimentos')
            ->select(

                DB::raw('MIN(abastecimentos.km_veiculo) AS km_inicial'),
                DB::raw('MAX(abastecimentos.km_veiculo) AS km_final'),
                DB::raw('SUM(abastecimentos.volume_abastecimento) AS consumo'),
                DB::raw('SUM(abastecimentos.valor_abastecimento) AS valor'),
                DB::raw('AVG(abastecimentos.media_veiculo) AS media')
            )
            //->select('abastecimentos.*')
            ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
            ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
            ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
            ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
            ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
            ->whereRaw('clientes.id is null')
            ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
            ->whereRaw($whereData)
            ->whereRaw($whereParam)
            ->whereRaw($whereTipoAbastecimento)
            ->groupBy('abastecimentos.veiculo_id')
            //->orderBy('clientes.nome_razao', 'asc')
            ->distinct()
            ->get();

        $clientesNulloAnalitico = DB::table('abastecimentos')
            ->select('abastecimentos.*')
            ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
            ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
            ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
            ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
            ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
            ->whereRaw('clientes.id is null')
            ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
            ->whereRaw($whereData)
            ->whereRaw($whereParam)
            ->whereRaw($whereTipoAbastecimento)

            // ->orderBy('clientes.nome_razao', 'asc')
            ->distinct()
            ->get();
        // dd($clientesNullo);

        if ($request->tipo_relatorio == 1) {
            /* relatório Sintético */

            foreach ($clientes as $cliente) {
                $departamentos = DB::table('abastecimentos')
                    ->select('departamentos.*')
                    //->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                    ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                    //->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                    ->leftJoin('clientes',         'clientes.id', 'veiculos.cliente_id')
                    ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                    ->whereRaw('clientes.id is not null')
                    ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
                    ->whereRaw($whereData)
                    ->whereRaw($whereParam)
                    ->whereRaw($whereTipoAbastecimento)
                    ->where('departamentos.cliente_id', $cliente->id)
                    ->orderBy('departamentos.departamento', 'asc')
                    ->distinct()
                    ->get();


                $cliente->departamentos = $departamentos;



                foreach ($cliente->departamentos as $departamento) {
                    $abastecimentos = DB::table('abastecimentos')
                        ->select(
                            'veiculos.placa',
                            DB::raw('MIN(abastecimentos.km_veiculo) AS km_inicial'),
                            DB::raw('MAX(abastecimentos.km_veiculo) AS km_final'),
                            DB::raw('SUM(abastecimentos.volume_abastecimento) AS consumo'),
                            DB::raw('SUM(abastecimentos.valor_abastecimento) AS valor'),
                            DB::raw('AVG(abastecimentos.media_veiculo) AS media')
                        )
                        ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                        ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                        ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                        ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                        ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                        ->whereRaw('clientes.id is not null')
                        ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
                        ->whereRaw($whereData)
                        ->whereRaw($whereParam)
                        ->whereRaw($whereTipoAbastecimento)
                        ->where('departamentos.id', $departamento->id)

                        ->groupBy('veiculos.placa')
                        ->get();
                    //->toSql();

                    $departamento->abastecimentos = $abastecimentos;
                }
            }
            //dd($clientes);
            return View('relatorios.abastecimentos.relatorio_abastecimentos')->withClientes($clientes)->withClientesNullo($clientesNullo)->withTitulo('Relatório de Abastecimentos - Sintético')->withParametros($parametros)->withParametro(Parametro::first());
        } else {
            /* relatório Analítico */
            foreach ($clientes as $cliente) {
                $departamentos = DB::table('abastecimentos')
                    ->select('departamentos.*')
                    ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                    ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                    ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                    ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                    ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                    ->whereRaw('clientes.id is not null')
                    ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
                    ->whereRaw($whereData)
                    ->whereRaw($whereParam)
                    ->whereRaw($whereTipoAbastecimento)
                    ->where('clientes.id', $cliente->id)
                    ->orderBy('departamentos.departamento', 'asc')
                    ->distinct()
                    ->get();
                $cliente->departamentos = $departamentos;
                foreach ($cliente->departamentos as $departamento) {
                    $abastecimentos = DB::table('abastecimentos')
                        ->select('abastecimentos.*', 'veiculos.placa')
                        ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                        ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                        ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                        ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                        ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                        ->whereRaw('clientes.id is not null')
                        ->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
                        ->whereRaw($whereData)
                        ->whereRaw($whereParam)
                        ->whereRaw($whereTipoAbastecimento)
                        ->where('departamentos.id', $departamento->id)
                        ->orderBy('veiculos.placa', 'asc')
                        ->orderBy('abastecimentos.data_hora_abastecimento', 'desc')
                        /* ->orderBy('abastecimentos.id', 'desc') */
                        ->distinct()
                        ->get();
                    $departamento->abastecimentos = $abastecimentos;
                }
            }

            return View('relatorios.abastecimentos.relatorio_abastecimentos_analitico')->withClientes($clientes)->withClientesNulloAnalitico($clientesNulloAnalitico)->withTitulo('Relatório de Abastecimentos - Analítico')->withParametros($parametros)->withParametro(Parametro::first());
        }
    }



    public function relatorioAbastecimentosBicoParam()
    {
        $bicos = Bico::where('ativo', true)->get();

        return View('relatorios.abastecimentos.relatorio_abastecimentos_bico_param')->withBicos($bicos);
    }

    public function relatorioAbastecimentosBico(Request $request)
    {

        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $media = $request->mostra_media;
        $parametros = array();

        if ($data_inicial && $data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento between \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s') . '\' and \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s') . '\'';
            array_push($parametros, 'Período de ' . $data_inicial . ' até ' . $data_final);
        } elseif ($data_inicial) {
            $whereData = 'abastecimentos.data_hora_abastecimento >= \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s') . '\'';
            array_push($parametros, 'A partir de ' . $data_inicial);
        } elseif ($data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento <= \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s') . '\'';
            array_push($parametros, 'Até ' . $data_final);
        } else {
            $whereData = '1 = 1'; //busca qualquer coisa
        }

        if ($request->bico_id > 0) {
            $whereBico = 'abastecimentos.bico_id = ' . $request->bico_id;
            array_push($parametros, 'Bico: ' . Bico::find($request->bico_id)->num_bico);
        } else {
            $whereBico = '1 = 1';
        }

        $bicos = DB::table('abastecimentos')
            ->select('bicos.id', 'bicos.num_bico', 'tanques.descricao_tanque', 'combustiveis.descricao')
            ->join('bicos', 'bicos.id', 'abastecimentos.bico_id')
            ->join('tanques', 'tanques.id', 'bicos.tanque_id')
            ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
            ->whereRaw($whereData)
            ->whereRaw($whereBico)
            ->distinct()
            ->orderBy('bicos.num_bico', 'asc')
            ->get();


        foreach ($bicos as $bico) {
            $bico->abastecimentos = DB::table('abastecimentos')
                ->select('abastecimentos.*', 'veiculos.placa')
                ->leftjoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                ->where('abastecimentos.bico_id', '=', $bico->id)
                ->whereRaw($whereData)
                /* ->orderBy('abastecimentos.id', 'asc') */
                ->orderBy('abastecimentos.data_hora_abastecimento', 'asc')
                ->get();
        }


        return View('relatorios.abastecimentos.relatorio_abastecimentos_bico')
            ->withBicos($bicos)
            ->withMedia($media)
            ->withParametros($parametros)
            ->withTitulo('Relatório de Abastecimentos - Bicos')
            ->withParametro(Parametro::first());
    }

    public function ajustarMediaAbastecimentosFuturos(Abastecimento $abastecimento)
    {
        try {
            $abastFuturos = Abastecimento::where('veiculo_id', $abastecimento->veiculo_id)
                ->where('data_hora_abastecimento', '>', $abastecimento->data_hora_abastecimento)
                ->orderBy('data_hora_abastecimento', 'asc')->get();

            $veiculo = Veiculo::find($abastecimento->veiculo_id);

            DB::beginTransaction();
            foreach ($abastFuturos as $abastFuturo) {
                $abastFuturo->media_veiculo = $this->obterMediaVeiculo($veiculo, $abastFuturo);
                $abastFuturo->save();
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    static public function ObterUltimoAbastecimentoVeiculo(Veiculo $veiculo, Abastecimento $abastecimentoAtual = null)
    {

        if ($abastecimentoAtual) {
            Log::debug($abastecimentoAtual);
            try {

                return Abastecimento::UltimoDoVeiculo($veiculo->id, $abastecimentoAtual->data_hora_abastecimento);
            } catch (ModelNotFoundException $e) {
                Log::error($e);
                //throw new \Exception('Não foi possível localizar o último abastecimento deste veículo para cálculo de média...');
                return null;
            }
        } else {

            try {

                return Abastecimento::UltimoDoVeiculo($veiculo->id);
            } catch (ModelNotFoundException $e) {
                return null;
            }
        }
    }

    public function ObterUltimoAbastecimentoData(Abastecimento $abastecimentoAtual = null)
    {

        if ($abastecimentoAtual) {
            try {

                return Abastecimento::UltimoDoBico($abastecimentoAtual->volume_abastecimento, $abastecimentoAtual->data_hora_abastecimento);
            } catch (ModelNotFoundException $e) {
                Log::error($e);
                //throw new \Exception('Não foi possível localizar o último abastecimento deste veículo para cálculo de média...');
                return null;
            }
        } else {

            return null;
        }
    }

    public function show(Abastecimento $abastecimento)
    {


        if (Auth::user()->canListarOrdemServico()) {
            $combustivel = DB::table('combustiveis')
                ->select('combustiveis.*')
                ->join('tanques', 'tanques.combustivel_id', 'combustiveis.id')
                ->join('bicos', 'bicos.tanque_id', 'tanques.id')
                ->where('bicos.id', '=', $abastecimento->bico_id)
                ->get();
            return View('abastecimento.show')
                ->withabastecimento($abastecimento)
                ->withCombustivel($combustivel)
                ->withTitulo('Abastecimento')
                //->withParametros($parametros)
                ->withParametro(Parametro::first());
        }
    }



    public function apiAbastecimentos(Request $request)
    {
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $parametros = array();

        $posto_abastecimentos_id = isset($request->posto_abastecimentos_id) ? $request->posto_abastecimentos_id : -1;
        if (is_null($posto_abastecimentos_id)) {

            $posto_abastecimentos_id = -1;
        }

        if ($data_inicial && $data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento between \'' . $data_inicial . ' 00:00:00' . '\' and \'' .  $data_final . ' 23:59:59' . '\'';
        } elseif ($data_inicial) {
            $whereData = 'abastecimentos.data_hora_abastecimento >= \'' . $data_inicial . ' 00:00:00' . '\'';
        } elseif ($data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento <= \'' . $data_final . ' 23:59:59' . '\'';
        } else {
            $whereData = '1 = 1'; //busca qualquer coisa
        }

        //dd($whereData);

        //dd($whereData);
        // parametro de data precisa ser entre as datas. necessario data inicial e final

        return response()->json(DB::table('abastecimentos')
            ->select('abastecimentos.*', 'combustiveis.descricao as combustivel', 'veiculos.placa', 'clientes.nome_razao', 'veiculos.cliente_id')
            ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
            ->leftJoin('tanques', 'tanques.id', 'bicos.tanque_id')
            ->leftJoin('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
            ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
            //->leftJoin('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
            ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
            ->leftJoin('clientes',         'clientes.id', 'veiculos.cliente_id')
            ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
            ->leftJoin('posto_abastecimentos', 'posto_abastecimentos.id', 'abastecimentos.posto_abastecimentos_id')
            //->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
            ->whereRaw('((abastecimentos.posto_abastecimentos_id = ' . $posto_abastecimentos_id . ') or (' .  $posto_abastecimentos_id . ' = -1))')

            ->whereRaw($whereData)
            //->whereBetween('abastecimentos.data_hora_abastecimento', [$request->data_inicial, $request->data_final])
            ->orderBy('abastecimentos.data_hora_abastecimento', 'desc')
            ->get());
    }

    public function apiAbastecimentosSemPlaca(Request $request)
    {
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $parametros = array();
        $posto_abastecimentos_id = isset($request->posto_abastecimentos_id) ? $request->posto_abastecimentos_id : -1;
        if (is_null($posto_abastecimentos_id)) {

            $posto_abastecimentos_id = -1;
        }

        if ($data_inicial && $data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento between \'' . $data_inicial . ' 00:00:00' . '\' and \'' .  $data_final . ' 23:59:59' . '\'';
        } elseif ($data_inicial) {
            $whereData = 'abastecimentos.data_hora_abastecimento >= \'' . $data_inicial . ' 00:00:00' . '\'';
        } elseif ($data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento <= \'' . $data_final . ' 23:59:59' . '\'';
        } else {
            $whereData = '1 = 1'; //busca qualquer coisa
        }
        return response()->json(DB::table('abastecimentos')
            ->select('abastecimentos.*', 'combustiveis.descricao as combustivel')
            ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
            ->leftJoin('tanques', 'tanques.id', 'bicos.tanque_id')
            ->leftJoin('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
            ->leftJoin('posto_abastecimentos', 'posto_abastecimentos.id', 'abastecimentos.posto_abastecimentos_id')
            //->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
            ->whereRaw('((abastecimentos.posto_abastecimentos_id = ' . $posto_abastecimentos_id . ') or (' .  $posto_abastecimentos_id . ' = -1))')

            ->whereNull('abastecimentos.veiculo_id')
            ->orderByDesc('abastecimentos.id')
            ->whereRaw($whereData)
            //->whereBetween('abastecimentos.data_hora_abastecimento', [$request->data_inicial, $request->data_final])
            ->orderBy('abastecimentos.data_hora_abastecimento', 'desc')
            //->where('abastecimentos.id', '<', '104')

            ->get());
    }

    public function apiAbastecimento($id)
    {
        return response()->json(Abastecimento::ativo()->where('id', $id)->get());
    }

    public function apiStore(Request $request)

    {


        try {
            // utiliza preco deo cadastro de combustivel como preco de venda
            $cfgPreco = DB::table('settings')
                ->select('settings.value')
                ->where('settings.key', 'automacao_valor_combustivel')
                ->first();

            DB::beginTransaction();

            $abastecimento = new Abastecimento;


            //$veiculo = new Veiculo();
            $atendente = new Atendente();

            if ($request->data_hora_abastecimento) {

                $abastecimento->data_hora_abastecimento = $request->data_hora_abastecimento;
            } else {
                $abastecimento->data_hora_abastecimento =  new \DateTime(now());
            }

            //$abastecimento->data_hora_abastecimento = \DateTime::createFromFormat('d/m/Y H:i:s', $request->data_hora_abastecimento)->format('Y-m-d H:i:s');

            $abastecimento->id_automacao = $request->id;
            //campo com id do abastecimento na memoria

            if ($request->veiculo_id > 0) {
                $abastecimento->veiculo_id = $request->veiculo_id;
            }

            if ($request->bico_id > 0) {
                $bico = Bico::where('num_bico', '=', $request->bico_id)->first();
                if ($bico) {

                    $abastecimento->bico_id = $bico->id;
                }
                //  $abastecimento->bico_id = $request->bico_id;
                //  $abastecimento->bico_id = Bico::where('num_bico', '=', $request->bico_id)->first();

            } else {
                $bico = Bico::where('endereco', '=', $request->bico_endereco)->first();

                if ($bico) {

                    $abastecimento->bico_id = $bico->id;
                }
            }

            $preco_custo = DB::table('combustiveis')
                ->select('combustiveis.custo')
                ->leftJoin('tanques', 'tanques.combustivel_id', 'combustiveis.id')
                ->leftJoin('bicos', 'bicos.tanque_id', 'tanques.id')
                ->where('bicos.id', '=', trim($bico->id))
                ->first();
            $preco_venda = DB::table('combustiveis')
                ->select('combustiveis.valor')
                ->leftJoin('tanques', 'tanques.combustivel_id', 'combustiveis.id')
                ->leftJoin('bicos', 'bicos.tanque_id', 'tanques.id')
                ->where('bicos.id', '=', trim($bico->id))
                ->first();




            if (!$preco_custo) {
                $abastecimento->custo_litro = 0;
            } else {
                $abastecimento->custo_litro = $preco_custo->custo ?? 0;
            }

            if (isset($cfgPreco->value) && $cfgPreco->value > 0) {
                if ($preco_venda && isset($preco_venda->valor)) {
                    $abastecimento->valor_abastecimento = ($request->volume_abastecimento * $preco_venda->valor);
                    $abastecimento->valor_litro = $preco_venda->valor;
                } else {
                    // Tratamento alternativo se o valor não estiver disponível
                    $abastecimento->valor_abastecimento = 0;
                    $abastecimento->valor_litro = 0;
                    Log::debug("Erro: Preço de venda não encontrado para o bico " . $request->bico_id);
                }
            } else {

                $abastecimento->valor_litro = str_replace(',', '.', $request->valor_litro);
                $abastecimento->valor_abastecimento = str_replace(',', '.', $request->valor_abastecimento);
            }




            $abastecimento->km_veiculo = $request->km_veiculo;
            $abastecimento->volume_abastecimento = str_replace(',', '.', $request->volume_abastecimento);
            $abastecimento->abastecimento_local = true;
            $abastecimento->media_veiculo = 0;
            $abastecimento->motorista_id = $request->motorista_id;

            if (isset($request->posto_abastecimentos_id)) {
                $abastecimento->posto_abastecimentos_id =   $request->posto_abastecimentos_id;
            }



            $abastecimento->encerrante_inicial = $request->encerrante_inicial;
            $abastecimento->encerrante_final = $request->encerrante_final;

            if ($request->atendente_id) {

                $atendente = Atendente::where('id', '=', $request->atendente_id)->first();
                if ($atendente) {

                    $abastecimento->atendente_id = $request->atendente_id;
                } else if ($request->tag_atendente) {
                    $atendente = Atendente::where('senha_atendente', '=', $request->tag_atendente)->first();

                    if ($atendente) {

                        $abastecimento->atendente_id = $atendente->id;
                    }
                }
            }


            if (!is_null($request->veiculo_id)) {

                $veiculo = Veiculo::where('id', '=', $request->veiculo_id)->first();

                if (isset($veiculo->id)) {

                    $abastecimento->veiculo_id = $veiculo->id;

                    $preco_cliente = PrecoCliente::where('cliente_id', $veiculo->cliente_id)->first();

                    if (isset($preco_cliente)) {

                        $itens = $preco_cliente->preco_cliente_items;

                        if (isset($abastecimento->bico_id)) {

                            $bico = Bico::where('id', $abastecimento->bico_id)->first();

                            $tanque = Tanque::where('id', $bico->tanque_id)->first();


                            if (isset($tanque)) {

                                // Filtra o item de preço pelo combustivel_id do tanque
                                $item_preco = $itens->where('combustivel_id', $tanque->combustivel_id)->first();

                                if ($item_preco) {
                                    $abastecimento->valor_litro = $item_preco->valor_unitario;
                                }
                            }
                        }
                    }
                }
            } else if ($request->tag_atendente) {

                $veiculo = Veiculo::where('tag', '=', $request->tag_atendente)->first();
            } else if ($request->tag_cliente) {

                $veiculo = Veiculo::where('tag', '=', $request->tag_atendente)->first();
            }


            if (isset($veiculo->id)) {

                $abastecimento->veiculo_id = $veiculo->id;


                $abastecimento->media_veiculo = $this->obterMediaVeiculo($veiculo, $abastecimento) ?? 0;
                // $abastecimento->media_veiculo = $this->obterMediaVeiculo(Veiculo::find($abastecimento->veiculo_id), $abastecimento, false);


            } else {

                $abastecimento->veiculo_id = null;
                $abastecimento->media_veiculo = 0;
            }
            Log::debug('Abastecimento recebido na api: ' . json_encode($abastecimento));



            if ($abastecimento->save()) {

                if (isset($veiculo->id)) {

                    try {
                        VeiculoController::atualizaKmVeiculo($veiculo, $abastecimento, false);
                    } catch (\Exception $e) {
                        //log::debug($e);
                        Session::flash('error', 'Ocorreu um erro ao atualizar os dados do veiculo. ' . $e->getMessage());
                    }
                }

                Log::debug('abastecimento salvo  : ' . $abastecimento . 'tag_atendente' . $request->tag_atendente);

                MovimentacaoCreditoController::saidaCredito2($abastecimento);

                if ($abastecimento->bico_id) {


                    /* Se for aferição, faz a movimentação de saída e entrada por aferição */
                    if (isset($abastecimento->eh_afericao) && ($abastecimento->eh_afericao)) {

                        $afericao = Afericao::create([
                            'abastecimento_id' => $abastecimento->id,
                            'user_id' => Auth::user()->id
                        ]);

                        MovimentacaoCombustivelController::cadastroAfericao($afericao);
                    } else {
                        /* Se informado o bico, movimenta o estoque do tanque */

                        MovimentacaoCombustivelController::saidaAbastecimento($abastecimento);
                    }

                    if (!BicoController::atualizarEncerranteBico($abastecimento->bico_id, $request->encerrante_final)) {
                        throw new \Exception(__('messages.exception', [
                            'exception' => 'Não foi possível atualizar o encerrante do bico'
                        ]));
                    }
                }

                //Log::debug('Abastecimento Inserido: '.$abastecimento);

                DB::commit();

                event(new NovoAbastecimento($abastecimento));
                // dd($abastecimento);
                //Ajusta médias futuras
                if (!$this->ajustarMediaAbastecimentosFuturos($abastecimento)) {
                    throw new \Exception(__('messages.exception', [
                        'exception' => 'Não foi possível atualizar as médias futuras do veículo'
                    ]));
                }
                return response()->json($abastecimento, 201);
            } else {

                return response()->json(["Erro" => "Abastecimento nao iserido"], 201);
            }
            //} else {
            //    return response()->json(["Erro" => "Data do abastecimento menor que o ultimo abastecimento inserido"], 201);
            //   Log::debug('Data do abastecimento menor que o ultimo abastecimento inserido ');
            // }
        } catch (\Exception $e) {

            DB::rollback();
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));
            Log::debug($e);

            return response()->json(["Erro" => "Abastecimento nao iserido"], 301);
        }
    }

    public function apiUpdateSemPlaca(Request $request)
    {


        $abastecimento = new Abastecimento;

        try {
            $abastecimento = Abastecimento::find($request->id);
            //  dd($abastecimento);
            $abastecimento->veiculo_id = $request->veiculo_id;
            $abastecimento->km_veiculo = $request->km_veiculo;
            $abastecimento->atendente_id = $request->atendente_id;

            if ($abastecimento->veiculo_id) {
                $abastecimento->media_veiculo = $this->obterMediaVeiculo(Veiculo::find($request->veiculo_id), $abastecimento, false);
            } else {
                $abastecimento->media_veiculo = 0;
            }


            if ($abastecimento->save()) {
                VeiculoController::atualizaKmVeiculo(Veiculo::find($request->veiculo_id), $abastecimento, true);



                return response()->json(true);
            } else {



                return response()->json(false);
            }
            /*  } */
        } catch (\Exception $e) {
            Log::error($e);
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));
            return redirect()->back();
        }
    }

    public function apiAbastecimentosCodigo(Request $request)
    {
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $parametros = array();


        $whereData = 'abastecimentos.id >' . $request->codigo;


        return response()->json(DB::table('abastecimentos')
            ->select(
                'abastecimentos.data_hora_abastecimento as DtAbastecimento',
                'abastecimentos.id as NrDocumento',
                'abastecimentos.km_veiculo as NrQuilometragem',
                // 'abastecimentos.km_veiculo as NrOdometro', 
                // 'abastecimentos.volume_abastecimento as QtdeLitro',
                DB::raw('format(abastecimentos.volume_abastecimento,2) as QtdeLitro'),
                DB::raw('format(abastecimentos.valor_abastecimento,2) as VlrTotal'),
                // 'abastecimentos.valor_abastecimento as VlrTotal',
                DB::raw('replace(veiculos.placa,"-","") as Placa'),
                'motoristas.cpf as CpfMotorista',
                'bicos.id as CdBomba',
                'combustiveis.descricao as TipoCombustivel'
            )
            ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
            ->leftJoin('tanques', 'tanques.id', 'bicos.tanque_id')
            ->leftJoin('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
            ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
            ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
            ->leftJoin('clientes',         'clientes.id', 'veiculos.cliente_id')
            ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
            ->leftJoin('motoristas', 'motoristas.id', 'abastecimentos.motorista_id')
            ->whereRaw($whereData)
            //->whereBetween('abastecimentos.data_hora_abastecimento', [$request->data_inicial, $request->data_final])
            //->orderBy('abastecimentos.id')
            ->get());
    }
}
