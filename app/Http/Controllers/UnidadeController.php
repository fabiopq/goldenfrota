<?php

namespace App\Http\Controllers;

use App\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class UnidadeController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'unidade' => 'Unidade',
        'permite_fracionamento' => ['label' => 'Permite Fracionamento', 'type' => 'bool'],
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarUnidade()) {
            
            if (isset($request->searchField)) {
                $unidades = Unidade::where('unidade', 'like', '%'.$request->searchField.'%')
                                    ->paginate();
            } else {
                $unidades = Unidade::paginate();
            }

            return View('unidade.index')->withUnidades($unidades)->withFields($this->fields);
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
        if (Auth::user()->canCadastrarUnidade()) {
            return View('unidade.create');
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
        
        if (Auth::user()->canCadastrarUnidade()) {
            $this->validate($request, [
                'unidade' => 'required|string|min:2|max:20|unique:unidades'
            ]);
            

            try {
                $unidade = new Unidade($request->all());

                if ($unidade->save()) {
                    
                    Session::flash('success', __('messages.create_success_f', [
                        'model' => 'unidade',
                        'name' => $unidade->unidade
                    ]));

                    return redirect()->action('UnidadeController@index');
                }
            } catch (\Exception $e) {
                Session::flash('success', __('messages.delete_success', [
                    'model' => __('models.abastecimento'),
                    'name' => $abastecimento->id
                ]));
                return redirect()->back();
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function edit(Unidade $unidade)
    {
        if (Auth::user()->canAlterarUnidade()) {
            return View('unidade.edit')->withUnidade($unidade);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unidade $unidade)
    {
        if (Auth::user()->canAlterarUnidade()) {
            $this->validate($request, [
                'unidade' => 'required|string|min:2|max:20|unique:unidades,id,'.$unidade->id
            ]);

            try {
                $unidade = Unidade::find($unidade->id);
                $unidade->unidade = $request->unidade;
                $unidade->permite_fracionamento = $request->permite_fracionamento;
                $unidade->ativo = $request->ativo;

                if ($unidade->save()) {
                    Session::flash('success', __('messages.update_success_f', [
                        'model' => __('models.unidade'),
                        'name' => $unidade->unidade
                    ]));

                    return redirect()->action('UnidadeController@index');
                }
            } catch (\Exception $e) {
                Session::flash('success', __('messages.delete_success', [
                    'model' => __('models.abastecimento'),
                    'name' => $abastecimento->id
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
     * @param  \App\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unidade $unidade)
    {
        if (Auth::user()->canAlterarUnidade()) {
            try {
                if ($unidade->delete()) {
                    Session::flash('success', __('messages.delete_success_f', [
                        'model' => __('models.unidade'),
                        'name' => $unidade->unidade
                    ]));
                    
                    return redirect()->action('UnidadeController@index');
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
                return redirect()->action('UnidadeController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function getUnidadesJson(Request $request) {
        $unidades = Unidade::where([                       
                        ['ativo', '=', 1]
                    ])->get();

        return response()->json($unidades);
    }
}
