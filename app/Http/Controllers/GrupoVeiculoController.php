<?php

namespace App\Http\Controllers;

use App\GrupoVeiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Events\NovoRegistroAtualizacaoApp;

class GrupoVeiculoController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'grupo_veiculo' => 'Grupo Veículo',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarGrupoVeiculo()) {
            if (isset($request->searchField)) {
                $grupoVeiculos = GrupoVeiculo::where('grupo_veiculo', 'like', '%'.$request->searchField.'%')->paginate();
            } else {
                $grupoVeiculos = GrupoVeiculo::paginate();
            }

            return View('grupo_veiculo.index', [
                'grupoVeiculos' => $grupoVeiculos,
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
        if (Auth::user()->canCadastrarGrupoVeiculo()) {
            return View('grupo_veiculo.create');
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
        if (Auth::user()->canCadastrarGrupoVeiculo()) {
            $this->validate($request, [
                'grupo_veiculo' => 'required|unique:grupo_veiculos'
            ]);

            try {
                $grupoVeiculo = new GrupoVeiculo($request->all());

                if ($grupoVeiculo->save()) {

                    event(new NovoRegistroAtualizacaoApp($grupoVeiculo));

                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.grupo_veiculo'),
                        'name' => $grupoVeiculo->grupo_veiculo
                    ]));
                    return redirect()->action('GrupoVeiculoController@index');
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
     * @param  \App\GrupoVeiculo  $grupoVeiculo
     * @return \Illuminate\Http\Response
     */
    public function edit(GrupoVeiculo $grupoVeiculo)
    {
        if (Auth::user()->canAlterarGrupoVeiculo()) {
            return View('grupo_veiculo.edit', [
                'grupoVeiculo' => $grupoVeiculo
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
     * @param  \App\GrupoVeiculo  $grupoVeiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GrupoVeiculo $grupoVeiculo)
    {
        if (Auth::user()->canAlterarGrupoVeiculo()) {
            $this->validate($request, [
                'grupo_veiculo' => 'required|unique:grupo_veiculos,id,'.$grupoVeiculo->id
            ]);

            try {
                $grupoVeiculo->grupo_veiculo = $request->grupo_veiculo;
                $grupoVeiculo->ativo = $request->ativo;

                if ($grupoVeiculo->save()) {

                    event(new NovoRegistroAtualizacaoApp($grupoVeiculo));

                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.grupo_veiculo'),
                        'name' => $grupoVeiculo->grupo_veiculo
                    ]));
                    return redirect()->action('GrupoVeiculoController@index');
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
     * @param  \App\GrupoVeiculo  $grupoVeiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy(GrupoVeiculo $grupoVeiculo)
    {
        if (Auth::user()->canExcluirGrupoVeiculo()) {
            try {
                if ($grupoVeiculo->delete()) {

                    event(new NovoRegistroAtualizacaoApp($grupoVeiculo, true));

                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.grupo_veiculo'),
                        'name' => $grupoVeiculo->grupo_veiculo
                    ]));
                    return redirect()->action('GrupoVeiculoController@index');
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
                return redirect()->action('GrupoVeiculoController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function apiGrupoVeiculos() {
        return response()->json(GrupoVeiculo::ativo()->get());
    }

    public function apiGrupoVeiculo($id) {
        return response()->json(GrupoVeiculo::ativo()->where('id', $id)->get());
    }

    public function getGrupoVeiculosJson(Request $request)
    {
        $grupoVeiculos = GrupoVeiculo::where([
            ['ativo', '=', 1]
        ])->get();

        return response()->json($grupoVeiculos);
    }
}
