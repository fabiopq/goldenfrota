<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Combustivel;
use App\PrecoCliente;
use App\PrecoClienteItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class PrecoClienteController extends Controller
{
    public $fields = [
        'id' => 'ID',
        'cliente_id' => 'ID Cliente',
        'nome_razao' => 'Cliente Nome',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarPrecoCliente()) {


            if (isset($request->searchField)) {

                $precoclientes = DB::table('preco_clientes')
                    ->select('preco_clientes.*', 'clientes.id as cliente_id', 'clientes.nome_razao')
                    ->leftJoin('clientes', 'clientes.id', 'preco_clientes.cliente_id')
                    ->where('clientes.nome_razao', 'like', '%' . $request->searchField . '%')
                    ->orderBy('clientes.nome_razao', 'desc')
                    ->paginate();
            } else {
                $precoclientes = DB::table('preco_clientes')
                    ->select('preco_clientes.*', 'clientes.id as cliente_id', 'clientes.nome_razao')
                    ->leftJoin('clientes', 'clientes.id', 'preco_clientes.cliente_id')
                    ->orderBy('clientes.nome_razao', 'desc')
                    ->paginate();
            }

            return View('preco_cliente.index', [
                'precoclientes' => $precoclientes,
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
        if (Auth::user()->canCadastrarPrecoCliente()) {
            $combustiveis =  Combustivel::select('combustiveis.id', DB::raw('concat_ws(" - ", combustiveis.descricao) as combustivel'))
                ->where('combustiveis.ativo', true)
                ->orderBy('combustiveis.descricao', 'asc')
                ->get();



            $clientes = DB::table('clientes')
                ->paginate();



            return View('preco_cliente.create', [

                'clientes' => $clientes,
                'combustiveis' => $combustiveis,

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
        if (Auth::user()->canCadastrarPrecoCliente()) {

            $this->validate($request, [
                'cliente_id' => 'required|unique:preco_clientes,cliente_id' 

            ]);
          

            try {
                DB::beginTransaction();
                $entrada = new PrecoCliente($request->all());
                if ($entrada->save()) {
                    // dd($request->items);
                    $entrada->preco_cliente_items()->createMany($request->items);

                    DB::commit();
                }
               

                return redirect()->action('PrecoClienteController@index');
            } catch (\Exception $e) {
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));

                DB::rollback();

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
     * @param  \App\PrecoCliente  $ordemServico
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {


        if (Auth::user()->canAlterarPrecoCliente()) {


            $preco_cliente = PrecoCliente::where('id', $id)->first();


            $combustiveis =  Combustivel::select('combustiveis.id', DB::raw('concat_ws(" - ", combustiveis.descricao) as combustivel'))
                ->where('combustiveis.ativo', true)
                ->orderBy('combustiveis.descricao', 'asc')
                ->get();



            $clientes = DB::table('clientes')
                ->paginate();

            return View('preco_cliente.edit', [

                'preco_cliente' => $preco_cliente,
                'clientes' => $clientes,
                'combustiveis' => $combustiveis,


            ]);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PrecoCliente  $ordemServico
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, PrecoCliente $precoCliente)
    {
        if (Auth::user()->canAlterarPrecoCliente()) {
            $this->validate($request, [
                'cliente_id' => 'required|unique:preco_clientes,cliente_id,' . $precoCliente->id,

            ]);
            $precoCliente->cliente_id = $request->cliente_id;

            try {
                if ($precoCliente->save()) {
                    /* remove produtos */
                    $precoCliente->preco_cliente_items()->delete();


                    /* inclui combustiveis */
                    if (is_array($request->items)) {
                        $precoCliente->preco_cliente_items()->createMany($request->items);
                    }
                    /* comita a transação */
                    DB::commit();

                    Session::flash('success', __('messages.update_success_f', [
                        'model' => __('models.preco_cliente'),
                        'name' => $precoCliente->id
                    ]));

                    return redirect()->action('PrecoClienteController@index', $request->query->all() ?? []);
                } else {
                    DB::rollback();

                    Session::flash('error', __('messages.update_error_f', [
                        'model' => __('models.preco_cliente'),
                        'name' => $precoCliente->id
                    ]));

                    return redirect()->back()->withInput();
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
     * @param  \App\PrecoCliente  $ordemServico
     * @return \Illuminate\Http\Response
     */
    public function destroy(PrecoCliente $precoCliente)
    {


        if (Auth::user()->canExcluirPrecoCliente()) {
            try {
                if ($precoCliente->delete()) {
                    Session::flash('success', __('messages.delete_success_f', [
                        'model' => __('models.preco_cliente'),
                        'name' => $precoCliente->id
                    ]));
                    return redirect()->action('PrecoClienteController@index');
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
                return redirect()->action('PrecoClienteController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function getValorUnitario(Request $request)
{
    $item = PrecoClienteItem::whereHas('precoCliente', function($query) use ($request) {
        $query->where('cliente_id', $request->cliente_id);
    })->where('combustivel_id', $request->combustivel_id)->first();

    if ($item) {
        return response()->json(['valor_unitario' => $item->valor_unitario]);
    }

    return response()->json(['valor_unitario' => null]);
}
}
