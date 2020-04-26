<?php

namespace App\Http\Controllers;

use App\Servico;
use App\Parametro;
use App\GrupoServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Events\NovoRegistroAtualizacaoApp;

class ServicoController extends Controller
{
    public $fields = [
        'id' => 'ID',
        'servico' => 'Serviço',
        'grupo_servico' => 'Grupo de Serviço',
        'valor_servico' => ['label' => 'Valor', 'type' => 'decimal', 'decimais' => 3],
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarServico()) {
            if ($request->searchField) {
                $servicos = DB::table('servicos')
                                ->select('servicos.*', 'grupo_servicos.grupo_servico')
                                ->leftJoin('grupo_servicos', 'grupo_servicos.id', 'servicos.grupo_servico_id')
                                ->where('servico', 'like', '%'.$request->searchField.'%')
                                ->orWhere('descricao', 'like', '%'.$request->searchField.'%')
                                ->orWhere('grupo_servico', 'like', '%'.$request->searchField.'%')
                                ->orderBy('id', 'desc')
                                ->paginate();
            } else {
                $servicos = DB::table('servicos')
                                ->select('servicos.*', 'grupo_servicos.grupo_servico')
                                ->leftJoin('grupo_servicos', 'grupo_servicos.id', 'servicos.grupo_servico_id')
                                ->orderBy('id', 'desc')
                                ->paginate();
            }

            return View('servico.index', [
                'fields' => $this->fields,
                'servicos' => $servicos
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
        if (Auth::user()->canCadastrarServico()) {
            return View('servico.create', [
                'grupo_servicos' => GrupoServico::all()
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
        if (Auth::user()->canCadastrarServico()) {
            $this->validate($request, [
                'servico' => 'required|string|min:3|unique:servicos',
                'descricao' => 'required|string|min:3',
                'grupo_servico_id' => 'required',
                'valor_servico' => 'required'
            ]);

            try {   
                $servico = new Servico($request->all());

                if ($servico->save()) {

                    event(new NovoRegistroAtualizacaoApp($servico));

                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.servico'),
                        'name' => $request->servico
                    ])); 

                    return redirect()->action('ServicoController@index');
                } else {
                    Session::flash('error', __('messages.create_error', [
                        'model' => __('models.servico'),
                        'name' => $request->servico
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Servico  $servico
     * @return \Illuminate\Http\Response
     */
    public function edit(Servico $servico)
    {
        if (Auth::user()->canAlterarServico()) {
            return View('servico.edit', [
                'servico' => $servico,
                'grupo_servicos' => GrupoServico::all()
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
     * @param  \App\Servico  $servico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Servico $servico)
    {
        if (Auth::user()->canAlterarServico()) {
            try {
                $this->validate($request, [
                    'servico' => 'required|string|min:3|unique:servicos,id,'.$servico->id,
                    'descricao' => 'required|string|min:3',
                    'grupo_servico_id' => 'required'
                ]);

                $servico->fill($request->all());

                if ($servico->save()) {

                    event(new NovoRegistroAtualizacaoApp($servico));

                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.servico'),
                        'name' => $request->servico
                    ])); 

                    return redirect()->action('ServicoController@index');
                } else {
                    Session::flash('error', __('messages.update_error', [
                        'model' => __('models.servico'),
                        'name' => $request->servico
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
     * @param  \App\Servico  $servico
     * @return \Illuminate\Http\Response
     */
    public function destroy(Servico $servico)
    {
        if (Auth::user()->canExcluirServico()) {
            try {
                if ($servico->delete()) {

                    event(new NovoRegistroAtualizacaoApp($servico, true));

                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.servico'),
                        'name' => $servico->servico 
                    ]));
                    
                    return redirect()->action('ServicoController@index');
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
                return redirect()->action('ServicoController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();   
        }
    }

    public function apiServicos() {
        return response()->json(Servico::ativo()->get());
    }

    public function apiServico($id) {
        return response()->json(Servico::ativo()->where('id', $id)->get());
    }

    public function listagemServicos() {
        $servicos = DB::table('servicos')
        ->select('servicos.*')
        ->orderBy('servico', 'desc')
        ->get();
        return View('relatorios.servicos.listagem_servicos')->withservicos($servicos)->withTitulo('Listagem de Serviços')->withParametro(Parametro::first());
    }
}
