<?php

namespace App\Http\Controllers;

use App\Uf;
use App\Cliente;
use App\Parametro;
use App\TipoPessoa;
use App\Rules\cpfCnpj;
use App\Rules\telefoneComDDD;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Events\NovoRegistroAtualizacaoApp;

class ClienteController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'nome_razao' => 'Nome/Razão Social',
        'cpf_cnpj' => 'CPF/CNPJ',
        'fone1' => 'Fone [1]',
        'fone2' => 'Fone [2]',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    function formatCnpjCpf($value)
    {
        $CPF_LENGTH = 11;
        $cnpj_cpf = preg_replace("/\D/", '', $value);

        if (strlen($cnpj_cpf) === $CPF_LENGTH) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        }

        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (Auth::user()->canListarCliente()) {
            if ($request->searchField) {
                $clientes = Cliente::where('nome_razao', 'like', '%' . $request->searchField . '%')
                    ->orWhere('fantasia', 'like', '%' . $request->searchField . '%')
                    ->orWhere('cpf_cnpj', 'like', '%' . $request->searchField . '%')
                    ->orWhere('rg_ie', 'like', '%' . $request->searchField . '%')
                    ->orWhere('endereco', 'like', '%' . $request->searchField . '%')
                    ->orWhere('fone1', 'like', '%' . $request->searchField . '%')
                    ->orWhere('fone2', 'like', '%' . $request->searchField . '%')

                    ->paginate();
            } else {
                $clientes = Cliente::paginate();
            }

            return View('cliente.index', [
                'clientes' => $clientes,
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
        if (Auth::user()->canCadastrarCliente()) {
            return View('cliente.create', [
                'tipoPessoas' => TipoPessoa::all(),
                'ufs' => Uf::all()
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
        if (Auth::user()->canCadastrarCliente()) {
            $this->validate($request, [
                'nome_razao' => 'required|string|unique:clientes',
                'fantasia' => 'nullable|string',
                'cpf_cnpj' => ['required', new cpfCnpj],
                'rg_ie' => 'required',
                'fone1' =>  ['nullable', new telefoneComDDD],
                'fone2' => ['nullable', new telefoneComDDD],
                'email1' => 'nullable|email',
                'email2' => 'nullable|email',
                // 'site' => 'nullable|site',
                'endereco' => 'required|string|min:1|max:200',
                'numero' => 'required',
                'bairro' => 'required|string|min:1|max:200',
                'cidade' => 'required|string|min:1|max:200',
                'cep' => 'required',
                'uf_id' => 'required'
            ]);

            try {
                $cliente = new Cliente($request->all());

                if ($cliente->save()) {

                    event(new NovoRegistroAtualizacaoApp($cliente));

                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.cliente'),
                        'name' => $cliente->nome_razao
                    ]));
                    return redirect()->action('ClienteController@index');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {


        $cliente->saldo = MovimentacaoCreditoController::consumoCreditoMes($cliente->id);


        if (Auth::user()->canAlterarCliente()) {
            return View('cliente.edit', [
                'ufs' => Uf::all(),
                'tipoPessoas' => TipoPessoa::all(),
                'cliente' => $cliente,

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
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response 
     */
    public function update(Request $request, Cliente $cliente)
    {
        if (Auth::user()->canAlterarCliente()) {
            $this->validate($request, [
                'nome_razao' => 'required|string|unique:clientes,id,' . $cliente->id,
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

            try {
                $cliente->nome_razao = $request->nome_razao;
                $cliente->fantasia = $request->fantasia;
                $cliente->cpf_cnpj = $request->cpf_cnpj;
                $cliente->rg_ie = $request->rg_ie;
                $cliente->fone1 = $request->fone1;
                $cliente->fone2 = $request->fone2;
                $cliente->email1 = $request->email1;
                $cliente->email2 = $request->email2;
                $cliente->endereco = $request->endereco;
                $cliente->numero = $request->numero;
                $cliente->bairro = $request->bairro;
                $cliente->cidade = $request->cidade;
                $cliente->cep = $request->cep;
                $cliente->uf_id = $request->uf_id;
                $cliente->site = $request->site;
                $cliente->ativo = $request->ativo;
                $cliente->controla_credito = $request->controla_credito;
                $cliente->tag = $request->tag;
                $cliente->limite = $request->limite;

                //dd($request);
                if ($cliente->save()) {

                    event(new NovoRegistroAtualizacaoApp($cliente));

                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.cliente'),
                        '$cliente->nome_razao'
                    ]));
                    return redirect()->action('ClienteController@index');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        if (Auth::user()->canExcluirCliente()) {
            try {
                if ($cliente->delete()) {

                    event(new NovoRegistroAtualizacaoApp($cliente, true));

                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.cliente'),
                        'name' => $cliente->nome_razao
                    ]));
                    return redirect()->action('ClienteController@index');
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
                return redirect()->action('ClienteController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function listagemClientes()
    {
        return View('relatorios.clientes.listagem_clientes')->withClientes(Cliente::all())->withTitulo('Listagem de Clientes')->withParametro(Parametro::first());
    }

    public function apiClientes()
    {
        return response()->json(Cliente::ativo()->get());
    }

    public function apiCliente($id)
    {
        return response()->json(Cliente::ativo()->where('id', $id)->get());
    }



    public function mascara($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) $maskared .= $val[$k++];
            } else {
                if (isset($mask[$i])) {
                    if ($mask[$i] == $val[$k]) {
                        $k++;
                    }
                    $maskared .= $mask[$i];
                }
            }
        }
        return $maskared;
    }


    public function apiClienteCnpj($id)
    {
        return response()->json(Cliente::ativo()->where('cpf_cnpj', $id)->get());
    }

    public function formSaldo()
    {

        return View('cliente.saldo')->withTitulo('Saldo do Mês');
    }

    public function showSaldo(Request $request)


    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);


        // $cpf = '025.813.691-08';
        $cpf = $request->username;

        //$id = '2';
        // $fantasia = 'arlan antonio lemes';
        // $cliente = Cliente::where('cpf_cnpj', $cpf)->first();
        /*  $cliente = DB::table('clientes')
            ->select('clientes.*')
            ->where('cpf_cnpj', $cpf)
            ->distinct()
            ->get();
*/
        $cliente = Cliente::where('cpf_cnpj', $request->input('username'))->first();


        // Simulando a busca do cliente no banco de dados
        if (!$cliente) {
            return redirect()->back()->withErrors(['error' => 'username ou senha invlida']);
        } else {

            $senha = $cliente->cpf_cnpj;
            $senha = str_replace(array('.', '-', '/'), "", $senha);
            $senha = substr($senha, 0, 4);
            //dd($senha);
            if ($request->password == $senha) {
               // $saldo = MovimentacaoCreditoController::consumoCreditoMes($cliente->id);
               
                $data_incio = mktime(0, 0, 0, date('m'), 1, date('Y'));
                $data_fim = mktime(23, 59, 59, date('m'), date("t"), date('Y'));
                // echo 'início ' . date('Y-m-d H:i:s', $data_incio);
                // echo ' fim ' . date('Y-m-d H:i:s', $data_fim);
                $whereData = 'abastecimentos.data_hora_abastecimento between \'' . date('Y-m-d H:i:s', $data_incio) . '\' and \'' .  date('Y-m-d H:i:s', $data_fim) . '\'';






                $abastecimentos = DB::table('abastecimentos')
                    ->select('abastecimentos.*', 'veiculos.placa', 'posto_abastecimentos.nome')
                    ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                    ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                    ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                    ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                    ->leftJoin('posto_abastecimentos', 'posto_abastecimentos.id', 'abastecimentos.posto_abastecimentos_id')

                    //->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                    ->whereRaw('clientes.id is not null')
                    //->whereRaw('((abastecimentos.abastecimento_local = ' . (isset($request->abast_local) ? $request->abast_local : -1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : -1) . ' = -1))')
                    ->whereRaw($whereData)
                    ->where('veiculos.cliente_id', $cliente->id)
                    ->orderBy('veiculos.placa', 'asc')
                    ->orderBy('abastecimentos.data_hora_abastecimento', 'desc')
                    /* ->orderBy('abastecimentos.id', 'desc') */
                    ->distinct()
                    ->get();
                $cliente->abastecimentos = $abastecimentos;


                $parametros = [];
                //dd($cliente->nome_razao);
                return View('relatorios.clientes.extrato_saldo')->withCliente($cliente)->withTitulo('Relatório de Abastecimentos')->withParametros($parametros)->withParametro(Parametro::first());

                //return View('relatorios.clientes.extrato_saldo')->withCliente($cliente)->withSaldo($saldo)->withTitulo('Extrato do Cliente')->withParametro(Parametro::first());
            } else {
                return redirect()->back()->withErrors(['error' => 'username ou senha invlida']);
            }
        }


        //return response()->json(['saldo' => $request->cpf]);

        // $cpf = '001.880.811-51';


    }
}
