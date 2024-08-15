<?php

namespace App\Http\Controllers;

use App\MarcaVeiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Events\NovoRegistroAtualizacaoApp;

class MarcaVeiculoController extends Controller
{

    protected $fields = array(
        'id' => 'ID',
        'marca_veiculo' => 'Marca',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarMarcaVeiculo()) {
            if (isset($request->searchField)) {
                $marcaVeiculos = MarcaVeiculo::where('marca_veiculo', 'like', '%'.$request->searchField.'%')
                                            ->paginate();
            } else {
                $marcaVeiculos = MarcaVeiculo::paginate();
            }

            return View('marca_veiculo.index', [
                'marcaVeiculos' => $marcaVeiculos,
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
        if (Auth::user()->canCadastrarMarcaVeiculo()) {
            return View('marca_veiculo.create');
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
        if (Auth::user()->canCadastrarMarcaVeiculo()) {
            $this->validate($request, [
                'marca_veiculo' => 'required|string|min:3|max:30|unique:marca_veiculos'
            ]);

                       

            try {
                $marcaVeiculo = new MarcaVeiculo($request->all());

                if ($marcaVeiculo->save()) {

                    event(new NovoRegistroAtualizacaoApp($marcaVeiculo));

                    Session::flash('success', __('messages.create_success_f', [
                        'model' => __('models.marca_veiculo'),
                        'name' => $marcaVeiculo->marca_veiculo
                    ]));
                    return redirect()->action('MarcaVeiculoController@index');
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
     * @param  \App\MarcaVeiculo  $marcaVeiculo
     * @return \Illuminate\Http\Response
     */
    public function edit(MarcaVeiculo $marcaVeiculo)
    {
        if (Auth::user()->canAlterarMarcaVeiculo()) {
            return View('marca_veiculo.edit', [
                'marcaVeiculo' => $marcaVeiculo
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
     * @param  \App\MarcaVeiculo  $marcaVeiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MarcaVeiculo $marcaVeiculo)
    {
        if (Auth::user()->canAlterarMarcaVeiculo()) {
            $this->validate($request, [
                'marca_veiculo' => 'required|string|min:3|max:30|unique:marca_veiculos,id,'.$marcaVeiculo->id
            ]);

            try {
                $marcaVeiculo->marca_veiculo = $request->marca_veiculo;
                $marcaVeiculo->ativo = $request->ativo;

                if ($marcaVeiculo->save()) {

                    event(new NovoRegistroAtualizacaoApp($marcaVeiculo));

                    Session::flash('success', __('messages.update_success_f', [
                        'model' => __('models.marca_veiculo'),
                        'name' => $marcaVeiculo->marca_veiculo
                    ]));
                    return redirect()->action('MarcaVeiculoController@index');
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
     * @param  \App\MarcaVeiculo  $marcaVeiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy(MarcaVeiculo $marcaVeiculo)
    {
        if (Auth::user()->canAlterarMarcaVeiculo()) {
            try {
                if ($marcaVeiculo->delete()) {

                    event(new NovoRegistroAtualizacaoApp($marcaVeiculo, true));

                    Session::flash('success', __('messages.delete_success_f', [
                        'model' => __('models.marca_veiculo'),
                        'name' => $marcaVeiculo->marca_veiculo
                    ]));
                    return redirect()->action('MarcaVeiculoController@index');
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
                return redirect()->action('MarcaVeiculoController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function apiMarcaVeiculos() {
        return response()->json(MarcaVeiculo::ativo()->get());
    }

    public function apiMarcaVeiculo($id) {
        return response()->json(MarcaVeiculo::ativo()->where('id', $id)->get());
    }

    public function getMarcaVeiculosJson(Request $request)
    {
        $marcaVeiculos = MarcaVeiculo::where([
            ['ativo', '=', 1]
        ])->get();

        return response()->json($marcaVeiculos);
    }
}
