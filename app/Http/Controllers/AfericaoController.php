<?php

namespace App\Http\Controllers;

use App\Afericao;
use App\Abastecimento;
use App\Bico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MovimentacaoCombustivelController;
use App\Parametro;

class AfericaoController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Abastecimento $abastecimento)
    {
        if (Auth::user()->canCadastrarAfericao()) {
            /* verifica se o abastecimento já não está relacionado com uma aferição */
            if ($abastecimento->eh_afericao) {
                Session::flash('error', 'Já existe uma aferição relacionada a esse abastecimento');
                return redirect()->back();
            }
            if ($abastecimento->bico_id) {
                //carrega a view para salvar a aferição
                return View('afericao.create')->withAbastecimento($abastecimento);
            } else {
                //não é possível fazer aferição de abastecimentos sem o bico relacionado
                Session::flash('error', 'Não é possível criar uma aferição a partir de um abastecimento que não tenha um bico relacionado.');
                return redirect()->back();
            }
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
        if (Auth::user()->canCadastrarAfericao()) {
            $this->validate($request, [
                'abastecimento_id' => 'required'
            ]);

            DB::beginTransaction();

            try {
                
                $afericao = new Afericao($request->all());
                $afericao->user_id = Auth::user()->id;

                if ($afericao->save()) {

                    /* seta o abastecimento como sendo uma aferição */
                    $abastecimento = Abastecimento::find($afericao->abastecimento_id);
                    $abastecimento->eh_afericao = true;
                    $abastecimento->save();

                    /* altera a movimentacao referente ao abastecimento para referenciar a afericao */
                    if (!MovimentacaoCombustivelController::converterAbastecimentoEmAfericao($afericao)) {
                        throw new \Exception();
                    };

                    /* lança uma movimentacao de entrada - aferição */
                    if (!MovimentacaoCombustivelController::entradaAfericao($afericao)) {
                        throw new \Exception();
                    }

                    
                    DB::commit();

                    Session::flash('success', __('messages.create_success_f', [
                        'model' => 'afericao',
                        'name' => $afericao->id
                    ]));

                    return redirect()->action('AbastecimentoController@index');
                } else {
                    throw new \Exception(__('messages.create_error_f', [
                        'model' => 'afericao',
                        'name' => ''
                    ]));
                }

                
            } catch (\Exception $e) {
                
                DB::rollback();
                
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));

                return redirect()->back()->withInput();
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Afericao  $afericao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Afericao $afericao)
    {
        try {
            return $afericao->delete();
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
            return redirect()->action('AbastecimentoController@index');
        }
    }

    public function relatorioAfericaoParam() {
        $bicos = DB::table('bicos')
            ->select('bicos.id', 'combustiveis.descricao as num_bico')
            ->join('tanques','bicos.tanque_id','tanques.id')
            ->join('combustiveis','tanques.combustivel_id','combustiveis.id')
            ->get();
       //$bicos = Bico::where('ativo', true)->get();
      // dd($bicos);
      
       return View('relatorios.afericoes.param_relatorio_afericoes')->withBicos($bicos);
    }

    public function relatorioAfericao(Request $request) {

        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $parametros = array();

        if($data_inicial && $data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento between \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\' and \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
            array_push($parametros, 'Período de '.$data_inicial.' até '.$data_final);
        } elseif ($data_inicial) {
            $whereData = 'abastecimentos.data_hora_abastecimento >= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\'';
            array_push($parametros, 'A partir de '.$data_inicial);
        } elseif ($data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento <= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
            array_push($parametros, 'Até '.$data_final);
        } else {
            $whereData = '1 = 1'; //busca qualquer coisa
        }

        if ($request->bico_id > 0) {
            $whereBico = 'abastecimentos.bico_id = '.$request->bico_id;
            array_push($parametros, 'Bico: '.Bico::find($request->bico_id)->num_bico);
        } else {
            $whereBico = '1 = 1';
        }

        $bicos = DB::table('afericoes')
                        ->select('bicos.id', 'bicos.num_bico', 'tanques.descricao_tanque', 'combustiveis.descricao')
                        ->join('abastecimentos','abastecimentos.id','afericoes.abastecimento_id')
                        ->join('bicos', 'bicos.id', 'abastecimentos.bico_id')
                        ->join('tanques', 'tanques.id', 'bicos.tanque_id')
                        ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                        ->whereRaw($whereData)
                        ->whereRaw($whereBico)
                        ->distinct()
                        ->orderBy('bicos.num_bico', 'asc')
                        ->get();

        foreach ($bicos as $bico) {
            $bico->abastecimentos = DB::table('afericoes')
                                            ->select('abastecimentos.*', 'veiculos.placa','roles.display_name')
                                            ->join('abastecimentos','abastecimentos.id','afericoes.abastecimento_id')
                                            ->join('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                                            ->join('roles','roles.id','afericoes.user_id')
                                            ->where('abastecimentos.bico_id', '=', $bico->id)
                                            ->whereRaw($whereData)
                                            /* ->orderBy('abastecimentos.id', 'asc') */
                                            ->orderBy('abastecimentos.data_hora_abastecimento', 'asc')
                                            ->get();
        }

        return View('relatorios.afericoes.relatorio_afericoes')
                    ->withBicos($bicos)
                    ->withParametros($parametros)
                    ->withTitulo('Relatório de Aferições')
                    ->withParametro(Parametro::first());
    }

    
    
}
