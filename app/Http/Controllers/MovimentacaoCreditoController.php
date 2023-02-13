<?php

namespace App\Http\Controllers;

use App\Bico;
use App\Cliente;
use App\Combustivel;
use App\TipoMovimentacaoCredito;
use App\Veiculos;
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
use App\Tanque;
use App\Veiculo;
use CreateTipoMovimentacaoCredito;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use phpDocumentor\Reflection\Types\Boolean;

class MovimentacaoCreditoController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'data_movimentacao' => ['label' => 'Data/Hora', 'type' => 'datetime'],
        'cliente_id' => 'Cod',
        'nome_razao' => 'Cliente',
        'tipo_movimentacao_credito' => 'Tipo de Movimentação ',
        //'tipo_movimentacao_credito' => 'Tipo de Movimentação',
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
                //dd($request->searchField);
                $movimentacao = DB::table('movimentacao_creditos')
                    ->select('movimentacao_creditos.*', 'clientes.nome_razao', 'tipo_movimentacao_credito.tipo_movimentacao_credito')->leftJoin('tipo_movimentacao_credito', 'tipo_movimentacao_credito.id', 'movimentacao_creditos.tipo_movimentacao_produto_id')
                    //->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                    ->leftJoin('clientes', 'clientes.id', 'movimentacao_creditos.cliente_id')
                    //->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
                    ->whereRaw($whereData)
                    //  ->where('veiculos.placa', 'like', '%' . $request->searchField . '%')
                    ->Where('clientes.nome_razao', 'like', '%' . $request->searchField . '%')
                    //->orWhere('atendentes.nome_atendente', 'like', '%' . $request->searchField . '%')
                    /* ->orderBy('abastecimentos.id', 'desc') */
                    ->orderBy('movimentacao_creditos.id', 'desc')
                    ->paginate();
            } else {
                $movimentacao = DB::table('movimentacao_creditos')
                    ->select('movimentacao_creditos.*', 'clientes.nome_razao', 'tipo_movimentacao_credito.tipo_movimentacao_credito')
                    ->leftJoin('tipo_movimentacao_credito', 'tipo_movimentacao_credito.id', 'movimentacao_creditos.tipo_movimentacao_produto_id')
                    //->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                    ->leftJoin('clientes', 'clientes.id', 'movimentacao_creditos.cliente_id')
                    //->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
                    ->whereRaw($whereData)
                    /* ->orderBy('abastecimentos.id', 'desc') */
                    ->orderBy('movimentacao_creditos.id', 'desc')
                    ->paginate();
                //dd($movimentacao);
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

            $combustiveis = Combustivel::where('ativo', true)->get();
            $clientes = Cliente::where('ativo', true)->get();
            $tipomovimentacao = TipoMovimentacaoCredito::where('ativo', true)->get();
            return View('movimentacao_credito.create')
                ->withclientes($clientes)->withcombustiveis($combustiveis)->withtipomovimentacao($tipomovimentacao);
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

                $movimentacao->tipo_movimentacao_produto_id = $request->tipo_movimentacao_credito_id;
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

    public function edit(MovimentacaoCredito $movimentacaoCredito)
    {
        $combustiveis = Combustivel::where('ativo', true)->get();



        if (Auth::user()->canAlterarAtendente()) {
            $combustiveis = Combustivel::where('ativo', true)->get();
            $clientes = Cliente::where('ativo', true)->get();
            $tipomovimentacao = TipoMovimentacaoCredito::where('ativo', true)->get();
            return View('movimentacao_credito.edit', [
                'clientes' => $clientes,
                'combustiveis' => $combustiveis,
                'tipomovimentacao' => $tipomovimentacao,
                'movimentacaoCredito' => $movimentacaoCredito
            ]);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function update(Request $request, MovimentacaoCredito $movimentacaoCredito)
    {


        if (Auth::user()->canAlterarAtendente()) {
            //dd($request);
            /*$this->validate($request, [
                
                'nome_razao' => 'required|string|unique:clientes,id,' . $movimentacaoCredito->id,
                'fantasia' => 'nullable|string',
                'cpf_cnpj' => ['required', new cpfCnpj],
                'rg_ie' => 'required',
                'fone1' =>  ['nullable', new telefoneComDDD],
                'fone2' => ['nullable', new telefoneComDDD],
                'email1' => 'nullable|email',
                'email2' => 'nullable|email',
                //'site' => 'nullable|site',
                'endereco' => 'required|string|min:1|max:200',
                'numero' => 'required',
                'bairro' => 'required|string|min:1|max:200',
                'cidade' => 'required|string|min:1|max:200',
                'cep' => 'required',
                'uf_id' => 'required'
            ]);
*/
            try {
                $movimentacaoCredito->cliente_id = $request->cliente_id;
                $movimentacaoCredito->combustivel_id = $request->combustivel_id;
                $movimentacaoCredito->tipo_movimentacao_produto_id = $request->tipo_movimentacao_credito_id;
                $movimentacaoCredito->quantidade_movimentada = $request->quantidade_movimentada;
                $movimentacaoCredito->valor_unitario = $request->valor_litro;
                $movimentacaoCredito->valor = $request->valor_total;
                //$movimentacaoCredito->user_id = $request->user_id;
                $movimentacaoCredito->user_id = Auth::user()->id;
                $movimentacaoCredito->observacao = $request->observacao;

                //dd($request);
                if ($movimentacaoCredito->save()) {



                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.movimentacaoCredito'),
                        '$movimentacaoCredito->valor'
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

    public function destroy(MovimentacaoCredito $movimentacaoCredito)
    {
        if (Auth::user()->canAlterarModeloBomba()) {
            try {
                if ($movimentacaoCredito->delete()) {
                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.movimentacao_credito'),
                        'name' => $movimentacaoCredito->modelo_bomba
                    ]));
                    return redirect()->action('MovimentacaoCreditoController@index');
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
                return redirect()->action('MovimentacaoCreditoController@index');
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

    static public function saidaCredito2(Abastecimento $abastecimento)
    {

        Log::debug('saida credito  : ' . $abastecimento);
        try {


            $veiculo = Veiculo::where('id', '=', $abastecimento->veiculo_id)->first();
            $combustivel = Combustivel::where('id', '=', $abastecimento->veiculo_id)->first();


            if ($veiculo) {
                try {

                    $bico = Tanque::where('id', '=', $abastecimento->bico_id)->first();
                    if ($bico) {
                        $abastecimento->combustivel_id = $bico->combustivel_id;
                    }
                } catch (\Exception $e) {
                    //dd($e);
                    throw new \Exception($e);
                }

                Log::debug('movimentacao credito inicio  : ' . $veiculo);

                $movimentacao = new MovimentacaoCredito();

                //$data_movimentacao = \DateTime::createFromFormat('d/m/Y H:i', $abastecimento->data_hora_abastecimento);
                // $movimentacao->data_movimentacao = $data_movimentacao->format('Y-m-d H:i:s');
                $movimentacao->data_movimentacao = $abastecimento->data_hora_abastecimento;

                $movimentacao->cliente_id = $veiculo->cliente_id;

                //$movimentacao->veiculo_id = $request->veiculo_id;
                $movimentacao->combustivel_id = $abastecimento->combustivel_id;

                $movimentacao->quantidade_movimentada = str_replace(',', '.', $abastecimento->volume_abastecimento);
                $movimentacao->valor_unitario = str_replace(',', '.', $abastecimento->valor_litro);
                $movimentacao->valor = str_replace(',', '.', $abastecimento->valor_abastecimento);

                //$movimentacao->user_id = Auth::user()->id;
                $movimentacao->user_id = 1;
                $movimentacao->tipo_movimentacao_produto_id = 2;
                $movimentacao->observacao = $abastecimento->observacao;
                Log::debug('movimentacao credito movimentacao  : ' . $movimentacao);
                $movimentacao->save();
            }
        } catch (\Exception $e) {
            Log::debug($e);
            throw new \Exception('Erro ao incluir movimentacao de entrada por aferição para o Abastecimento: ' . $abastecimento->id);
        }
    }

    static public function saidaCredito(Abastecimento $abastecimento)
    {
        Log::debug($abastecimento);
        try {
            //DB::beginTransaction();

            $movimentacao = new MovimentacaoCredito();
            //dd($request->data_movimentacao);
            $data_movimentacao = \DateTime::createFromFormat('d/m/Y H:i', $abastecimento->data_hora_abastecimento);
            $movimentacao->data_movimentacao = $data_movimentacao->format('Y-m-d H:i:s');
            //$movimentacao->cliente_id = Veiculos::
            $veiculo = Veiculo::where('veiculo_id', $abastecimento->veiculo_id)->firs();

            //$movimentacao->veiculo_id = $request->veiculo_id;
            $movimentacao->combustivel_id = $abastecimento->combustivel_id;
            $movimentacao->quantidade_movimentada = str_replace(',', '.', $abastecimento->quantidade_movimentada);
            $movimentacao->valor_unitario = str_replace(',', '.', $abastecimento->valor_litro);
            $movimentacao->valor = str_replace(',', '.', $abastecimento->valor_total);
            $movimentacao->user_id = Auth::user()->id;
            $movimentacao->tipo_movimentacao_produto_id = 1;
            $movimentacao->observacao = $abastecimento->observacao;

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
    }

    static public function saldoCredito(Cliente $cliente)
    {

        try {

            if ($cliente) {
                $entradas = DB::table('movimentacao_creditos')
                    ->select(
                        DB::raw('SUM(movimentacao_creditos.valor) as valor'),
                        'movimentacao_creditos.tipo_movimentacao_produto_id'

                    )
                    ->whereRaw('cliente_id =' . $cliente->id)

                    ->groupBy('tipo_movimentacao_produto_id') // 1- entradas

                    ->distinct()
                    ->get();

                $saldo = 0;
                foreach ($entradas as $entrada) {
                    if ($entrada->tipo_movimentacao_produto_id == 1) {
                        $saldo = $saldo + $entrada->valor;
                    }
                    if ($entrada->tipo_movimentacao_produto_id == 2) {
                        $saldo = $saldo - $entrada->valor;
                    }
                }
                //dd($entradas);
                return  $saldo;
            }
        } catch (\Exception $e) {
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));
            return redirect()->back()->withInput();
        }
    }

    static public function getSaldoCreditoJson(Request $request)
    {
        

        try {
           
            $cliente = Cliente::where('id', $request->id)->get();

            

            if ($cliente[0]) {
                Log::debug('id cliente  : ' .  $cliente);
                $entradas = DB::table('movimentacao_creditos')
                    ->select(

                        DB::raw(' SUM(CASE WHEN movimentacao_creditos.tipo_movimentacao_produto_id = 1 THEN valor ELSE 0 END) AS entradas'),
                        DB::raw(' SUM(CASE WHEN movimentacao_creditos.tipo_movimentacao_produto_id = 2 THEN valor ELSE 0 END) AS saidas')

                    )
                    ->whereRaw('cliente_id =' . $cliente[0]->id)

                    //->groupBy('tipo_movimentacao_produto_id') // 1- entradas

                    ->distinct()
                    ->get();
                    Log::debug('id cliente  : ' .  $entradas);

                if ($entradas[0]) {


                    $saldo = round(($entradas[0]->entradas) - ($entradas[0]->saidas), 2);
                    // Log::debug('variavel saldo  : ' .  response()->json($entradas));

                    return response()->json($saldo);
                    //return  response()->json($entradas);
                }

                //return response()->json(Combustivel::find($request->id)->first());
            }
        } catch (\Exception $e) {
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));
            return redirect()->back()->withInput();
        }
    }
}
