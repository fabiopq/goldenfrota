<?php

namespace App\Http\Controllers;

use App\Atendente;
use App\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AtendenteController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'nome_atendente' => 'Atendente',
        'placa' => 'Placa',
        'senha_atendente' => 'Tag',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarAtendente()) {
            if (isset($request->searchField)) {
                //$atendentes = Atendente::where('nome_atendente', 'like', '%'.$request->searchField.'%')
                //                ->paginate();
                $atendentes = DB::table('atendentes')
                    ->select('atendentes.*',  'veiculos.placa')
                    ->leftJoin('veiculos', 'veiculos.id', 'atendentes.veiculo_id')
                    ->where('veiculos.placa', 'like', '%' . $request->searchField . '%')
                    ->orWhere('atendentes.senha_atendente', 'like', '%' . $request->searchField . '%')
                    ->orWhere('atendentes.nome_atendente', 'like', '%' . $request->searchField . '%')
                    /* ->orderBy('abastecimentos.id', 'desc') */
                    //->orderBy('atendentes.data_hora_abastecimento', 'desc')
                    ->paginate();
            } else {
                $atendentes = DB::table('atendentes')
                    ->select('atendentes.*',  'veiculos.placa')
                    ->leftJoin('veiculos', 'veiculos.id', 'atendentes.veiculo_id')
                    ->paginate();
            }

            return View('atendente.index')->withAtendentes($atendentes)->withFields($this->fields);
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
        if (Auth::user()->canCadastrarAtendente()) {
            $veiculos = Veiculo::select(DB::raw("concat(veiculos.placa, ' - ', marca_veiculos.marca_veiculo, ' ', modelo_veiculos.modelo_veiculo) as veiculo"), 'veiculos.id')
                ->join('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
                ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
                ->where('veiculos.ativo', true)
                ->get();
            return View('atendente.create')
                ->withveiculos($veiculos);
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
        if (Auth::user()->canCadastrarAtendente()) {
            $this->validate($request, [
                'nome_atendente' => 'required|string',
                'usuario_atendente' => 'required|string|max:10|unique:atendentes',
                'senha_atendente' => 'required|string|max:16',
                'veiculo_id' => 'nullable|numeric|unique:atendentes'
            ]);

            try {
                $atendente = new Atendente($request->all());

                if ($atendente->save()) {
                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.atendente'),
                        'name' => $atendente->nome_atendente
                    ]));
                    return redirect()->action('AtendenteController@index');
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
     * @param  \App\Atendente  $atendente
     * @return \Illuminate\Http\Response
     */
    public function edit(Atendente $atendente)
    {
        if (Auth::user()->canAlterarAtendente()) {
            $veiculos = Veiculo::select(DB::raw("concat(veiculos.placa, ' - ', marca_veiculos.marca_veiculo, ' ', modelo_veiculos.modelo_veiculo) as veiculo"), 'veiculos.id')
                ->join('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
                ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
                ->where('veiculos.ativo', true)
                ->get();
            return View('atendente.edit', [
                'veiculos' => $veiculos,
                'atendente' => $atendente
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
     * @param  \App\Atendente  $atendente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Atendente $atendente)
    {
        if (Auth::user()->canAlterarAtendente()) {
            $this->validate($request, [
                'nome_atendente' => 'required|string',
                'usuario_atendente' => 'required|string|max:10|unique:atendentes,usuario_atendente,' . $atendente->id,
                'senha_atendente' => 'required|string|max:16',
                'veiculo_id' => 'nullable|numeric|unique:atendentes,veiculo_id,' . $atendente->id
            ]);

            try {
                $atendente = Atendente::find($atendente->id);

                $atendente->nome_atendente = $request->nome_atendente;
                $atendente->usuario_atendente = $request->usuario_atendente;
                $atendente->senha_atendente = $request->senha_atendente;
                $atendente->veiculo_id = $request->veiculo_id;
                $atendente->ativo = $request->ativo;

                if ($atendente->save()) {
                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.atendente'),
                        'name' => $atendente->nome_atendente
                    ]));
                    return redirect()->action('AtendenteController@index');
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

    public function apiAtendentes()
    {
        return response()->json(DB::table('atendentes')
            ->select('atendentes.*')->get());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Atendente  $atendente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Atendente $atendente)
    {
        if (Auth::user()->canExcluirAtendente()) {
            try {
                $atendente = Atendente::find($Atendente->id);
                if ($atendente->delete()) {
                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.atendente'),
                        'name' => $atendente->nome_atendnete
                    ]));

                    return redirect()->action('AtendenteController@index');
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
                return redirect()->action('AtendenteController@index');
            }
        } else {
            Session::flash('error', env('ACCESS_DENIED_MSG'));
            return redirect()->back();
        }
    }

    public function apiUpdateAtendente(Request $request)
    {


        $atendente = new Atendente();
        

        try {
            $atendente = Atendente::find($request->id);
            //  dd($abastecimento);
            
            $atendente->nome_atendente = $request->nome_atendente;
            $atendente->usuario_atendente = $request->usuario_atendente;
            $atendente->senha_atendente = $request->senha_atendente;
            $atendente->veiculo_id = $request->veiculo_id;

            //dd($atendente);
            

            
            if ($atendente->save()) {

                dd($atendente);
                return response()->json(true);
            } else {



                return response()->json(false);
            }
            /*  } */
        } catch (\Exception $e) {
            
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));
            return redirect()->back();
        }
    }
}
