<?php

namespace App\Http\Controllers;

use App\Estoque;
use App\GrupoProduto;
use App\Parametro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Events\NovoRegistroAtualizacaoApp;

class GrupoProdutoController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'grupo_produto' => 'Grupo Produto',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarGrupoProduto()) {
            if (isset($request->searchField)) {
                $grupoProdutos = GrupoProduto::where('grupo_produto', 'like', '%'.$request->searchField.'%')
                                                ->paginate();
            } else {
                $grupoProdutos = GrupoProduto::paginate();
            }

            return View('grupo_produto.index', [
                'grupoProdutos' => $grupoProdutos,
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
        if (Auth::user()->canCadastrarGrupoProduto()) {
            return View('grupo_produto.create');
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
        if (Auth::user()->canCadastrarGrupoProduto()) {
            $this->validate($request, [
                'grupo_produto' => 'required|string|min:3|max:80|unique:grupo_produtos'
            ]);

            try {
                $grupoProduto = new GrupoProduto($request->all());

                if ($grupoProduto->save()) {

                    event(new NovoRegistroAtualizacaoApp($grupoProduto));

                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.grupo_produto'),
                        'name' => $grupoProduto->grupo_produto
                    ]));
                    return redirect()->action('GrupoProdutoController@index');
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
     * @param  \App\GrupoProduto  $grupoProduto
     * @return \Illuminate\Http\Response
     */
    public function edit(GrupoProduto $grupoProduto)
    {
        if (Auth::user()->canAlterarGrupoProduto()) {
            return View('grupo_produto.edit', [
                'grupoProduto' => $grupoProduto
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
     * @param  \App\GrupoProduto  $grupoProduto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GrupoProduto $grupoProduto)
    {
        if (Auth::user()->canAlterarGrupoProduto()) {
            $this->validate($request, [
                'grupo_produto' => 'required|string|min:3|max:80|unique:grupo_produtos,id,'.$grupoProduto->id
            ]);

            try {
                $grupoProduto->grupo_produto = $request->grupo_produto;
                $grupoProduto->ativo = $request->ativo;

                if ($grupoProduto->save()) {

                    event(new NovoRegistroAtualizacaoApp($grupoProduto));

                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.grupo_produto'),
                        'name' => $grupoProduto->grupo_produto
                    ]));
                    return redirect()->action('GrupoProdutoController@index');
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
     * @param  \App\GrupoProduto  $grupoProduto
     * @return \Illuminate\Http\Response
     */
    public function destroy(GrupoProduto $grupoProduto)
    {
        if (Auth::user()->canExcluirGrupoProduto()) {
            try {
                if ($grupoProduto->delete()) {

                    event(new NovoRegistroAtualizacaoApp($grupoProduto, true));

                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.grupo_produto'),
                        'name' => $grupoProduto->grupo_produto
                    ]));
                    return redirect()->action('GrupoProdutoController@index');
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
                return redirect()->action('GrupoProdutoController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        } 
    }

    public function getGrupoProdutoJson(Request $request) {
        $estoque = Estoque::find($request->id);
        $grupos = $estoque->produtos->unique('grupo_produto_id')->pluck('grupo_produto_id');

        return response()->json(GrupoProduto::whereIn('id', $grupos)->get());
    }

    public function apiGrupoProdutos() {
        return response()->json(GrupoProduto::ativo()->get());
    }

    public function apiGrupoProduto($id) {
        return response()->json(GrupoProduto::ativo()->where('id', $id)->get());
    }

    public function listagemGrupoProduto() {
        $grupoproduto = DB::table('grupo_produtos')
        ->select('grupo_produtos.*')
        ->orderBy('grupo_produto', 'desc')
        ->get();
        return View('relatorios.grupo_produto.listagem_grupo_produto')->withgrupoproduto($grupoproduto)->withTitulo('Listagem de Grupo de Produto')->withParametro(Parametro::first());
        
    }

    public function apiStore(Request $request)
    {
        
        $grupoproduto = new GrupoProduto();
        $grupoproduto->fill($request->all());
        $grupoproduto->save();

        return response()->json($grupoproduto, 201);
    }
    
    public function teste()
    {
        $handle = fopen("d:\posto.csv", "r");
        $row = 0;
        while ($line = fgetcsv($handle, 1000, ";")) {
	    if ($row++ == 0) {
		continue;
	    }
	
	    $peoples[] = [
		'modelo' => $line[0],
		'marca' => $line[1]
		
        ];
        
        
        }
       // dd($peoples);
        foreach ($peoples as $people) {
            $grupoProduto = new GrupoProduto();
            $grupoProduto->grupo_produto = strtoupper($people['modelo']);
    
            $grupoProduto->save();
    
        }
        
       
        fclose($handle);
    }

}
