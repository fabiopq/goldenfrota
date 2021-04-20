<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Events\NovoRegistroAtualizacaoApp;
use Illuminate\Support\Facades\Storage;

class DepartamentoController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'departamento' => 'Departamento',
        'nome_razao' => 'Cliente',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarDepartamento()) {
            if ($request->searchField) {
                $departamentos = DB::table('departamentos')
                                ->select('departamentos.*', 'clientes.nome_razao')
                                ->join('clientes', 'clientes.id', 'departamentos.cliente_id')
                                ->where('departamentos.departamento', 'like', '%'.$request->searchField.'%')
                                ->orWhere('clientes.nome_razao', 'like', '%'.$request->searchField.'%')
                                ->paginate();
            } else {
                $departamentos = DB::table('departamentos')
                                ->select('departamentos.*', 'clientes.nome_razao')
                                ->join('clientes', 'clientes.id', 'departamentos.cliente_id')
                                ->paginate();
            }

            return View('departamento.index')->withDepartamentos($departamentos)->withFields($this->fields);
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
        if (Auth::user()->canCadastrarDepartamento()) {
            $clientes = Cliente::where('ativo', true)->get();
            return View('departamento.create')->withClientes($clientes);
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
        if (Auth::user()->canCadastrarDepartamento()) {
            $this->validate($request, [
                'departamento' => 'required|string|unique:departamentos,departamento,NULL,id,cliente_id,'.$request->cliente_id,
                'cliente_id' => 'required'
            ]);

            try {
                $departamento = new Departamento($request->all());

                if ($departamento->save()) {

                    event(new NovoRegistroAtualizacaoApp($departamento));

                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.departamento'),
                        'name' => $departamento->departamento
                    ]));
                    return redirect()->action('DepartamentoController@index');
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
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Departamento $departamento)
    {
        if (Auth::user()->canAlterarDepartamento()) {
            $clientes = Cliente::where('ativo', true)->orWhere('clientes.id', $departamento->cliente_id)->get();

            return View('departamento.edit')->withDepartamento($departamento)->withClientes($clientes);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Departamento $departamento)
    {
        if (Auth::user()->canAlterarDepartamento()) {
            $this->validate($request, [
                'departamento' => 'required|string|unique:departamentos,cliente_id,'.$request->cliente_id,
                'cliente_id' => 'required'
            ]);

            try {
                $departamento->departamento = $request->departamento;
                $departamento->cliente_id = $request->cliente_id;
                $departamento->ativo = $request->ativo;

                if ($departamento->save()) {

                    event(new NovoRegistroAtualizacaoApp($departamento));

                    Session::flash('success',  __('messages.update_success', [
                        'model' => __('models.departamento'),
                        'name' => $departamento->departamento
                    ]));
                    return redirect()->action('DepartamentoController@index');
                }
            } catch (\Exception $e) {
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return redirect()->bakc()->withInput();
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departamento $departamento)
    {
        if (Auth::user()->canExcluirDepartamento()) {   
            try {
                if ($departamento->delete()) {

                    event(new NovoRegistroAtualizacaoApp($departamento, true));

                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.departamento'),
                        'name' => $departamento->departamento
                    ]));
                    return redirect()->action('DepartamentoController@index');
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
                return redirect()->action('DepartamentoController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function getDepartamentosJson(Request $request) {
        $departamentos = Departamento::where([
                        ['cliente_id', '=', $request->id],
                        ['ativo', '=', 1]
                    ])->get();

        return response()->json($departamentos);
    }

    public function apiDepartamentos() {
        return response()->json(Departamento::ativo()->get());
    }

    public function apiDepartamento($id) {
        return response()->json(Departamento::ativo()->where('id', $id)->get());
    }

    public function importarDepartamento(){
        $arquivo = Storage::disk($this->disk())->get('posto.xlsx');

    }

    public function apiStore(Request $request)
    {
        
        $departamento = new Departamento();
        $departamento->fill($request->all());
        $departamento->save();

        return response()->json($departamento, 201);
    }
}
