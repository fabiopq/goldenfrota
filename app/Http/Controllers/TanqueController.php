<?php

namespace App\Http\Controllers;

use App\Tanque;
use App\Parametro;
use App\Combustivel;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Support\Facades\Session;

class TanqueController extends Controller
{
    use SearchTrait;

    protected $fields = array(
        'tanques.id' => ['label' => 'ID', 'type' => 'int', 'searchParam' => true],
        'descricao_tanque' => ['label' => 'Tanque', 'type' => 'string', 'searchParam' => true],
        'descricao' => ['label' => 'Combustivel', 'type' => 'string', 'searchParam' => true],
        'capacidade' => 'Capacidade',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        if (Auth::user()->canListarTanque()) {
            if (isset($request->searchField)) {
                $whereRaw = $this->getWhereField($request, $this->fields);
                //$whereRaw = ($whereRaw) ? $whereRaw : '1 = 1';
                //dd($this->getWhereField($request, $this->fields));
                $tanques = DB::table('tanques')
                                ->select('tanques.*', 'combustiveis.descricao')
                                ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                                //->where('descricao_tanque', 'like', '%'.$request->searchField.'%')
                                ->whereRaw($whereRaw)
                                ->paginate();
            } else {
                $tanques = DB::table('tanques')
                                ->select('tanques.*', 'combustiveis.descricao')
                                ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                                ->paginate();
            }

            return View('tanque.index')->withTanques($tanques)->withFields($this->fields);
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
        if (Auth::user()->canCadastrarTanque()) {
            return View('tanque.create')->withCombustiveis(Combustivel::all());
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
        if (Auth::user()->canCadastrarTanque()) {
            $this->validate($request, [
                'descricao_tanque' => 'required|min:3|unique:tanques',
                'combustivel_id' => 'required',
                'capacidade' => 'required|numeric'
            ]);
            try {
                $tanque = new Tanque($request->all());

                if ($tanque->save()) {
                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.tanque'),
                        'name' => $tanque->descricao_tanque 
                    ]));
                    return redirect()->action('TanqueController@index', $request->query->all() ?? []);
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
     * @param  \App\Tanque  $tanque
     * @return \Illuminate\Http\Response
     */
    public function edit(Tanque $tanque)
    {
        if (Auth::user()->canAlterarTanque()) {
            return View('tanque.edit')->withTanque($tanque)->withCombustiveis(Combustivel::all());
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();   
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tanque  $tanque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tanque $tanque)
    {
        if (Auth::user()->canAlterarTanque()) {
            $this->validate($request, [
                'descricao_tanque' => 'string|required|min:3|unique:tanques,id,'.$tanque->id,
                'combustivel_id' => 'numeric|required',
                'capacidade' => 'numeric|required'
            ]);

            try {
                $tanque = Tanque::find($tanque->id);
                $tanque->descricao_tanque = $request->descricao_tanque;
                $tanque->combustivel_id = $request->combustivel_id;
                $tanque->capacidade = $request->capacidade;
                $tanque->ativo = $request->ativo;

                if ($tanque->save()) {
                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.tanque'),
                        'name' => $tanque->descricao_tanque 
                    ]));
                    return redirect()->action('TanqueController@index', $request->query->all() ?? []);
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
     * @param  \App\Tanque  $tanque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Tanque $tanque)
    {
        if (Auth::user()->canExcluirTanque()) {
            try {
                if ($tanque->delete()) {
                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.tanque'),
                        'name' => $tanque->descricao_tanque 
                    ]));
                    
                    return redirect()->action('TanqueController@index', $request->query->all() ?? []);
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
                return redirect()->action('TanqueController@index', $request->query->all() ?? []);
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();   
        }
    }

    public function getTanquesJson(Request $request) {
        $tanques = Tanque::where('combustivel_id', $request->id)->get();

        return response()->json($tanques);
    }

    public function relPosicaoTanque() {
        $tanques = Tanque::select('tanques.*', 'combustiveis.descricao')
                        ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                        ->where('tanques.ativo', true)->get();
        
        $graficos = array();

        foreach ($tanques as $tanque) {
            $graficos[] = Charts::create('percentage', 'justgage')
                            ->title($tanque->descricao_tanque.' ('.$tanque->descricao.')')
                            ->elementLabel('Litros')
                            ->values([$this->getPosicaoEstoque($tanque), 0, $tanque->capacidade])
                            ->responsive(false)
                            ->height(250);
                            //->width(0);
        }

        return View('relatorios.tanques.posicao_tanques')->withTitulo('Posição de Estoque - Tanques')->withGraficos($graficos);
    }

    static public function getPosicaoEstoque(Tanque $tanque) {
        $posicao = DB::table('movimentacao_combustiveis')
        ->select(
            DB::raw(
                'SUM(
                    CASE tipo_movimentacao_combustiveis.eh_entrada
                        WHEN 1 THEN
                            movimentacao_combustiveis.quantidade
                        WHEN 0 THEN
                            movimentacao_combustiveis.quantidade * -1
                    END
                ) as posicao'
            )
        )
        ->leftJoin('tanques', 'tanques.id', 'movimentacao_combustiveis.tanque_id')
        ->leftJoin('tipo_movimentacao_combustiveis', 'tipo_movimentacao_combustiveis.id', 'movimentacao_combustiveis.tipo_movimentacao_combustivel_id')
        ->where('movimentacao_combustiveis.tanque_id', $tanque->id)
        ->first();

        return ($posicao->posicao) ? $posicao->posicao : 0;
        
        /* dd(($posicao == null) ? $posicao : 0);
        
        
        $entradas = DB::table('movimentacao_combustiveis')

                        ->where([
                            ['tanque_id', $tanque->id],
                            ['tipo_', true],
                            ['ativo', true]
                        ])
                        ->sum('quantidade_combustivel');

        $saidas = DB::table('tanque_movimentacoes') 
                        ->where([
                            ['tanque_id', $tanque->id],
                            ['entrada_combustivel', false],
                            ['ativo', true]
                        ])
                        ->sum('quantidade_combustivel');

        return $entradas - $saidas; */
    }

    public function listagemTanques() {
        $tanques = Tanque::all(); 

        foreach($tanques as $tanque) {
            $tanque->posicao = $this->getPosicaoEstoque($tanque);
        }

        return View('relatorios.tanques.listagem_tanques')->withTanques($tanques)->withTitulo('Listagem de Tanques')->withParametro(Parametro::first());
    }
}