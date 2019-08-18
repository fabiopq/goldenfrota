<?php

namespace App\Http\Controllers;

use App\Uf;
use App\Cliente;
use App\Parametro;
use App\TipoPessoa;
use App\Rules\cpfCnpj;
use App\Rules\telefoneComDDD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Events\NovoRegistroAtualizacaoApp;
use App\Traits\SearchTrait;

class ClienteController extends Controller
{
    use SearchTrait;

    public $fields = array(
        'id' => ['label' => 'ID', 'type' => 'int', 'searchParam' => true],
        'nome_razao' => ['label' => 'Nome/Razão Social', 'type' => 'string', 'searchParam' => true],
        'fantasia' => ['label' => 'Fantasia', 'type' => 'string', 'searchParam' => true],
        'cpf_cnpj' => ['label' => 'CPF/CNPJ', 'type' => 'string', 'searchParam' => true],
        'fone1' => 'Fone [1]',
        'fone2' => 'Fone [2]',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarCliente()) {
            if ($request->searchField) {
                $whereRaw = $this->getWhereField($request, $this->fields);
                $clientes = Cliente::whereRaw($whereRaw)
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
                'fone1' =>  ['required', new telefoneComDDD],
                'fone2' => ['nullable', new telefoneComDDD],
                'email1' => 'nullable|email',
                'email2' => 'nullable|email',
                'endereco' => 'required|string|min:3|max:200',
                'numero' => 'required',
                'bairro' => 'required|string|min:3|max:200',
                'cidade' => 'required|string|min:3|max:200',
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
                    return redirect()->action('ClienteController@index', $request->query->all() ?? []);
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
        if (Auth::user()->canAlterarCliente()) {
            return View('cliente.edit', [
                'ufs' => Uf::all(),
                'tipoPessoas' => TipoPessoa::all(),
                'cliente' => $cliente
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
                'fone1' =>  ['required', new telefoneComDDD],
                'fone2' => ['nullable', new telefoneComDDD],
                'email1' => 'nullable|email',
                'email2' => 'nullable|email',
                'endereco' => 'required|string|min:3|max:200',
                'numero' => 'required',
                'bairro' => 'required|string|min:3|max:200',
                'cidade' => 'required|string|min:3|max:200',
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
                $cliente->ativo = $request->ativo;


                if ($cliente->save()) {
                    
                    event(new NovoRegistroAtualizacaoApp($cliente));

                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.cliente'),
                        '$cliente->nome_razao'
                    ]));
                    return redirect()->action('ClienteController@index', $request->query->all() ?? []);
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
    public function destroy(Request $request, Cliente $cliente)
    {
        if (Auth::user()->canExcluirCliente()) {
            try {
                if ($cliente->delete()) {

                    event(new NovoRegistroAtualizacaoApp($cliente, true));

                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.cliente'),
                        'name' => $cliente->nome_razao
                    ]));
                    return redirect()->action('ClienteController@index', $request->query->all() ?? []);
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
                return redirect()->action('ClienteController@index', $request->query->all() ?? []);
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

    public function apiClientes() {
        return response()->json(Cliente::ativo()->get());
    }

    public function apiCliente($id) {
        return response()->json(Cliente::ativo()->where('id', $id)->get());
    }
}