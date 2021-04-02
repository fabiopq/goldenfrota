<?php

namespace App\Http\Controllers;

use App\Tanque;
use App\Combustivel;
use App\Parametro;
use App\Fornecedor;
use App\EntradaTanque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MovimentacaoCombustivelController;

class EntradaTanqueController extends Controller
{
    public $fields = [
        
        'nr_docto' => 'Nr. Doc.',
        'serie' => 'Série',
        'data_entrada' => ['label' => 'Data Entrada', 'type' => 'datetime'],
        'nome_razao' => 'Fornecedor'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarEntradaTanque()) {
            if ($request->searchField) {
                $entradas = DB::table('entrada_tanques')
                                ->select('entrada_tanques.*', 'fornecedores.nome_razao as nome_razao')
                                ->join('fornecedores', 'entrada_tanques.fornecedor_id', 'fornecedores.id')
                                ->where('nr_docto', $request->searchField)
                                ->orWhere('fornecedores.nome_razao', 'like', '%'.$request->searchField.'%')
                                ->orderBy('entrada_tanques.data_entrada', 'desc')
                                ->paginate();
            } else {
                $entradas = DB::table('entrada_tanques')
                                ->select('entrada_tanques.*', 'fornecedores.nome_razao as nome_razao')
                                ->join('fornecedores', 'entrada_tanques.fornecedor_id', 'fornecedores.id')
                                ->orderBy('entrada_tanques.data_entrada', 'desc')
                                ->paginate();
            }

            return View('entrada_tanque.index', [
                'fields' => $this->fields,
                'entradas' => $entradas
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
        if (Auth::user()->canCadastrarEntradaTanque()) {
            $fornecedores = Fornecedor::where('ativo', true)
                            ->orderBy('nome_razao', 'asc')
                            ->get();

            $tanques = Tanque::select('tanques.id', DB::raw('concat_ws(" - ", tanques.descricao_tanque, combustiveis.descricao) as tanque'))
                            ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                            ->where('tanques.ativo', true)
                            ->orderBy('tanques.descricao_tanque', 'asc')
                            ->get();

            return View('entrada_tanque.create', [
                'fornecedores' => $fornecedores,
                'tanques' => $tanques
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
        if (Auth::user()->canCadastrarEntradaTanque()) {   
            $this->validate($request, [
                'nr_docto' => 'required',
                'fornecedor_id' => 'required',
                'items' => 'required|array|min:1'
            ]);
            try {
                DB::beginTransaction();
                
                $entrada = new EntradaTanque($request->all());

                //dd($request->all());

                $dataDoc = \DateTime::createFromFormat('d/m/Y H:i:s', $request->data_doc);
                $dataEntrada = \DateTime::createFromFormat('d/m/Y H:i:s', $request->data_entrada);

                $entrada->data_doc = $dataDoc->format('Y-m-d H:i:s');
                $entrada->data_entrada = $dataEntrada->format('Y-m-d H:i:s');

                if ($entrada->save()) {
                    $entrada->entrada_tanque_items()->createMany($request->items);

                    if (!MovimentacaoCombustivelController::entradaTanque($entrada)) {
                        throw new Exception('Ocorreu um erro ao incluir a movimentação de combustível.');
                    }

                    Session::flash('success', __('messages.create_success_f', [
                        'model' => __('models.entrada_tanque'),
                        'name' => 'Entrada de Combustivel'
                    ]));

                    DB::commit();
                    // altera preco cadastro combustivel

                    foreach($entrada->entrada_tanque_items as $item){
                      
                     $tanque = Tanque::find($item->tanque_id);
                
                     $combustivel = Combustivel::find($tanque->combustivel_id);
              
                     DB::table('combustiveis')
                      ->where('id', $combustivel->id)
                      ->update(['valor' => $item->valor_unitario]);
                     DB::commit();
               
                    } 
                    

                    return redirect()->action('EntradaTanqueController@index');
                } else {
                    throw new \Exception(_('messages.create_error_f', [
                        'model' => __('models.entrada_tanque'),
                        'name' => 'Entrada de Combustivel'
                    ]));
                }
                
            } catch (\Exception $e) {
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));

                DB::rollback();

                return redirect()->back()->withInput();
            }
        } else {
            Session::flash('error', __('messages.access_denied'));

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EntradaTanque  $entradaTanque
     * @return \Illuminate\Http\Response
     */
    public function show(EntradaTanque $entradaTanque)
    {
        if (Auth::user()->canListarEntradaTanque()) {
            /* return response()->json($entradaTanque->with('entrada_tanque_items.tanque.combustivel')
            ->with('fornecedor')
            ->get()); */
            return View('entrada_tanque.show', [
                'entradaTanque' => EntradaTanque::with('entrada_tanque_items.tanque.combustivel')
                                                    ->with('fornecedor')
                                                    ->find($entradaTanque->id),
                'titulo' => 'Movimentação de Estoque - Produtos - Sintético',
                'parametro' => Parametro::first()
                                                
            ]);
        } else {
            Session::flash('error', __('messages.access_denied'));

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EntradaTanque  $entradaTanque
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntradaTanque $entradaTanque)
    {
        if (Auth::user()->canExcluirEntradaTanque()) {
            try {
                if ($entradaTanque->delete()) {
                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.entrada_tanque'),
                        'name' => $entradaTanque->nr_docto 
                    ]));
                    return redirect()->action('EntradaTanqueController@index');
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
                return redirect()->action('EntradaTanqueController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }
}
