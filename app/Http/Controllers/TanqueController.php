<?php

namespace App\Http\Controllers;

use App\Tanque;
use App\Parametro;
use App\Combustivel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ChartJSController;
use App\PostoAbastecimento;

class TanqueController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'num_tanque' => 'Número',
        'descricao_tanque' => 'Tanque',
        'descricao' => 'Combustivel',
        'capacidade' => 'Capacidade',
        'posto_abastecimento' => 'Posto Abastecimento',
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
                $tanques = DB::table('tanques')
                    ->select('tanques.*', 'combustiveis.descricao','posto_abastecimentos.nome as posto_abastecimento')
                    ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                    ->join('posto_abastecimentos', 'posto_abastecimentos.id', 'tanques.posto_abastecimento_id')
                    ->where('descricao_tanque', 'like', '%' . $request->searchField . '%')
                    ->paginate();
            } else {
                $tanques = DB::table('tanques')
                    ->select('tanques.*', 'combustiveis.descricao','posto_abastecimentos.nome as posto_abastecimento')
                    ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                    ->join('posto_abastecimentos', 'posto_abastecimentos.id', 'tanques.posto_abastecimento_id')
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
            
            return View('tanque.create')
            ->withCombustiveis(Combustivel::all())
            ->withPostoabastecimentos(PostoAbastecimento::all());
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
                'descricao_tanque' => 'required|min:3',
                'combustivel_id' => 'required',
                'capacidade' => 'required|numeric',
                'posto_abastecimento_id' => 'required|numeric',
                'num_tanque' => 'required|unique:tanques,num_tanque,' . $request->num_tanque . ',id,posto_abastecimento_id,' . $request->posto_abastecimento_id    
            ]);
            try {
                
                $tanque = new Tanque($request->all());
             

                if ($tanque->save()) {
                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.tanque'),
                        'name' => $tanque->descricao_tanque
                    ]));
                    return redirect()->action('TanqueController@index');
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
            return View('tanque.edit')
            ->withTanque($tanque)
            ->withPostoabastecimentos(PostoAbastecimento::all())
            ->withCombustiveis(Combustivel::all());
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
                'descricao_tanque' => 'string|required|min:3|unique:tanques,id,' . $tanque->id,
                'combustivel_id' => 'numeric|required',
                'capacidade' => 'numeric|required',
                'num_tanque' => 'numeric|required',
                'posto_abastecimento_id' => 'required|numeric',
                'num_tanque' => 'required|unique:tanques,num_tanque,' . $tanque->id . ',id,posto_abastecimento_id,' . $request->posto_abastecimento_id    

            ]);

            try {
                $tanque = Tanque::find($tanque->id);
                $tanque->descricao_tanque = $request->descricao_tanque;
                $tanque->combustivel_id = $request->combustivel_id;
                $tanque->capacidade = $request->capacidade;
                $tanque->ativo = $request->ativo;
                $tanque->num_tanque = $request->num_tanque;
                $tanque->posto_abastecimento_id = $request->posto_abastecimento_id;

                if ($tanque->save()) {
                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.tanque'),
                        'name' => $tanque->descricao_tanque
                    ]));
                    return redirect()->action('TanqueController@index');
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
    public function destroy(Tanque $tanque)
    {
        if (Auth::user()->canExcluirTanque()) {
            try {
                if ($tanque->delete()) {
                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.tanque'),
                        'name' => $tanque->descricao_tanque
                    ]));

                    return redirect()->action('TanqueController@index');
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
                return redirect()->action('TanqueController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function getTanquesJson(Request $request)
    {
        $tanques = Tanque::where('combustivel_id', $request->id)->get();

        return response()->json($tanques);
    }

    public function relPosicaoTanque()
    {
        $tanques = Tanque::select('tanques.*', 'combustiveis.descricao')
            ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
            ->where('tanques.ativo', true)->get();
            
             

        $graficos = array();
         foreach ($tanques as $tanque) {
           /*
            $graficos[] = Charts::create('percentage', 'justgage')
                ->title($tanque->descricao_tanque . ' (' . $tanque->descricao . ')')
                ->elementLabel('Litros')
                ->values([$this->getPosicaoEstoque($tanque), 0, $tanque->capacidade])
                ->responsive(false)
                ->height(250);
                */
            //->width(0);
        }
        return view('chart', compact('labels', 'data'));
       // return View('relatorios.tanques.posicao_tanques')->withTitulo('Posição de Estoque - Tanques')->withGraficos($graficos);
    }

    static public function getPosicaoEstoque(Tanque $tanque)
    {
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

    static public function getPosicaoEstoqueData(Tanque $tanque,$request)
    {
        
        $data = date_format(date_create_from_format('d/m/Y H:i:s', $request->data.'23:59:59'), 'Y-m-d H:i:s');
     
        $posicao = DB::table('movimentacao_combustiveis')
            ->select(
                DB::raw('tanques.descricao_tanque,tanques.capacidade, SUM(
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
            ->where('movimentacao_combustiveis.created_at','<', $data)
            ->first();

        return ($posicao->posicao) ? $posicao->posicao : 0;

        
    }

    static public function getCombustivelTanque(Tanque $tanque)
    {

        //Log::debug('Tanque  ' . $tanque);
        $combustiveis = Combustivel::ativo()->where('id', $tanque->combustivel_id)->get();
        //Log::debug('combustivel ' . $combustiveis);
        
        return ($combustiveis[0]->descricao);
    }


    public function listagemTanques()
    {
       // $tanques = Tanque::all();

        $tanques = Tanque::select(
            'tanques.*','posto_abastecimentos.nome as posto_abastecimento'
        )
            ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
            ->join('posto_abastecimentos', 'posto_abastecimentos.id', 'tanques.posto_abastecimento_id')
            ->where('tanques.ativo', true)
            ->get();

           


        foreach ($tanques as $tanque) {
            $tanque->posicao = $this->getPosicaoEstoque($tanque);
        }
       // dd($tanques);
        return View('relatorios.tanques.listagem_tanques')->withTanques($tanques)->withTitulo('Listagem de Tanques')->withParametro(Parametro::first());
    }

    public function apiTanques()
    {
        $tanques = Tanque::all();

        foreach ($tanques as $tanque) {
            $tanque->posicao = $this->getPosicaoEstoque($tanque);
            $tanque->combustivel = $this->getCombustivelTanque($tanque);
        }
        return response()->json($tanques);
    }
}
