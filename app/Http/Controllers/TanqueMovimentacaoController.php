<?php

namespace App\Http\Controllers;

use App\Tanque;
use App\Combustivel;
use App\TanqueMovimentacao;
use App\PosicaoTanqueDiaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TanqueMovimentacaoController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'data_movimentacao' => ['label' => 'Data Entrada', 'type' => 'date'],
        'documento' => 'Documento',
        'descricao_tanque' => 'Tanque',
        'descricao' => 'Combustivel',
        'quantidade_combustivel' => 'Quantidade',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarTanqueMovimentacao()) {
            if (isset($request->searchField)) {
                $movimentacoes = DB::table('tanque_movimentacoes')
                                    ->select('tanque_movimentacoes.*', 'tanques.descricao_tanque', 'combustiveis.descricao')
                                    ->join('tanques', 'tanques.id', 'tanque_movimentacoes.tanque_id')
                                    ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                                    ->where([
                                        ['data_hora_abastecimento', '=', $request->searchField],
                                        ['entrada_combustivel', true]
                                    ])
                                    ->paginate();
            } else {
                $movimentacoes = DB::table('tanque_movimentacoes')
                                    ->select('tanque_movimentacoes.*', 'tanques.descricao_tanque', 'combustiveis.descricao' )
                                    ->join('tanques', 'tanques.id', 'tanque_movimentacoes.tanque_id')
                                    ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                                    ->where('entrada_combustivel', true)
                                    ->paginate();
            }

            return View('tanque_movimentacao.index', [
                'movimentacoes' => $movimentacoes,
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
        if (Auth::user()->canCadastrarTanqueMovimentacao()) {
            $combustiveis = Combustivel::where('ativo', true)->get();

            return View('tanque_movimentacao.create')->withCombustiveis($combustiveis);
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
        if (Auth::user()->canCadastrarTanqueMovimentacao()) {
            $this->validate($request, [
                'documento' => 'required',
                'data_movimentacao' => 'required',
                'tanque_id' => 'required',
                'quantidade_combustivel' => 'required'
            ]);

            try {
                $movimentacao = new TanqueMovimentacao;
                $movimentacao->data_movimentacao = \DateTime::createFromFormat('d/m/Y', $request->data_movimentacao)->format('Y-m-d');
                $movimentacao->documento = $request->documento;
                $movimentacao->tanque_id = $request->tanque_id;
                $movimentacao->quantidade_combustivel = $request->quantidade_combustivel;
                $movimentacao->entrada_combustivel = true;


                if ($movimentacao->save()) {
                    Session::flash('success', __('messages.create_success_f', [
                        'model' => __('models.tanque_movimentacao'),
                        'name' => $movimentacao->documento
                    ]));
                    return redirect()->action('TanqueMovimentacaoController@index');
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
     * @param  \App\TanqueMovimentacao  $tanqueMovimentacao
     * @return \Illuminate\Http\Response
     */
    public function edit(TanqueMovimentacao $tanqueMovimentacao)
    {
        if (Auth::user()->canAlterarTanqueMovimentacao()) {
            $movimentacao = TanqueMovimentacao::select('tanque_movimentacoes.*', 'combustiveis.id')
                                        ->join('tanques', 'tanques.id', 'tanque_movimentacoes.tanque_id')
                                        ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                                        ->where('tanque_movimentacoes.id', $tanqueMovimentacao->id)
                                        ->first();        

            $combustiveis = Combustivel::select('combustiveis.*')
                                        ->join('tanques', 'tanques.combustivel_id', 'combustiveis.id')
                                        ->where('combustiveis.ativo', true)
                                        ->orWhere('tanques.id', $movimentacao->tanque_id)
                                        ->get();

            return View('tanque_movimentacao.edit')->withMovimentacao($movimentacao)->withCombustiveis($combustiveis);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();   
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TanqueMovimentacao  $tanqueMovimentacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TanqueMovimentacao $tanqueMovimentacao)
    {
        if (Auth::user()->canAlterarTanqueMovimentacao()) {
            $this->validate($request, [
                'documento' => 'required',
                'data_movimentacao' => 'required',
                'tanque_id' => 'required',
                'quantidade_combustivel' => 'required'
            ]);

            try {
                $movimentacao->data_movimentacao = \DateTime::createFromFormat('d/m/Y', $request->data_movimentacao)->format('Y-m-d');
                $movimentacao->documento = $request->documento;
                $movimentacao->tanque_id = $request->tanque_id;
                $movimentacao->quantidade_combustivel = $request->quantidade_combustivel;
                $movimentacao->entrada_combustivel = true;
                $movimentacao->ativo = $request->ativo;


                if ($movimentacao->save()) {
                    Session::flash('success', __('messages.update_success_f', [
                        'model' => __('models.tanque_movimentacao'),
                        'name' => $movimentacao->documento
                    ]));
                    return redirect()->action('TanqueMovimentacaoController@index');
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
     * @param  \App\TanqueMovimentacao  $tanqueMovimentacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(TanqueMovimentacao $tanqueMovimentacao)
    {
        if (Auth::user()->canExcluirTanqueMovimentacao()) {
            try {
                if ($tanqueMovimentacao->delete()) {
                    Session::flash('success', __('messages.delete_success_f', [
                        'model' => __('models.tanque_movimentacao'),
                        'name' => $tanqueMovimentacao->documento
                    ]));
                    return redirect()->action('TanqueMovimentacaoController@index');
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
                return redirect()->action('TanqueMovimentacaoController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();   
        }
    }

    public function getPosicaoTanque(Tanque $tanque, \DateTime $data) {
        $posicao = 0;
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
            ->join('tipo_movimentacao_combustiveis', 'movimentacao_combustiveis.tipo_movimentacao_combustivel_id', 'tipo_movimentacao_combustiveis.id')
            ->where('movimentacao_combustiveis.created_at', '<=', $data->format('Y-m-d H:i:s'))
            ->where('movimentacao_combustiveis.tanque_id', $tanque->id)
            ->first();

        return round($posicao->posicao, 2);
    }  
    
    public function getSaidasTanque(Tanque $tanque, \DateTime $data) {
        $posicao = 0;
        $posicao = DB::table('movimentacao_combustiveis')
            ->select(
                DB::raw(
                    'SUM(
                        CASE tipo_movimentacao_combustiveis.eh_entrada
                            WHEN 1 THEN
                                movimentacao_combustiveis.quantidade * -1
                            WHEN 0 THEN
                                movimentacao_combustiveis.quantidade 
                        END
                    ) as posicao'
                )
            )
            ->join('tipo_movimentacao_combustiveis', 'movimentacao_combustiveis.tipo_movimentacao_combustivel_id', 'tipo_movimentacao_combustiveis.id')
            ->where('movimentacao_combustiveis.created_at', '<=', $data->format('Y-m-d H:i:s'))
            ->where('movimentacao_combustiveis.tanque_id', $tanque->id)
            ->first();

        return round($posicao->posicao, 2);
    }  

    public function posTanque30Dias($tanqueId) {
        $dataFinal = new \DateTime();
        $dataInicial = new \Datetime();
        $dataInicial->sub(new \DateInterval('P30D'));
        $posicoes = array();
        $tanque = Tanque::find($tanqueId);
        if ($tanque) {
            while ($dataInicial < $dataFinal) {
                array_push($posicoes, [
                    'date' => $dataInicial->format('d/m/Y'),
                    'position' => $this->getPosicaoTanque($tanque, $dataInicial)
                ]);
                $dataInicial->add(new \DateInterval('P1D'));
            }
            return response()->json($posicoes);
        } else {
            return response()->json();
        }
    }
}
