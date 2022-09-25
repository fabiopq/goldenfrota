<?php

namespace App\Http\Controllers;

use App\Estoque;
use App\Parametro;
use App\Produto;
use App\Unidade;
use App\Fornecedor;
use App\Permission;
use App\GrupoProduto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Events\NovoRegistroAtualizacaoApp;

class ProdutoController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'produto_descricao' => 'Descrição',
        'produto_desc_red' => 'Descrição Reduzida',
        'unidade' => 'Unidade',
        'grupo_produto' => 'Grupo',
        'valor_custo' => [
            'label' => 'Preço de Custo',
            'type' => 'decimal',
            'decimais' => 3
        ],
        'valor_venda' => [
            'label' => 'Preço de Venda',
            'type' => 'decimal',
            'decimais' => 3
        ],
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarProduto()) {
            if ($request->searchField) {
                $produtos = DB::table('produtos')
                    ->select('produtos.*', 'unidades.unidade', 'grupo_produtos.grupo_produto')
                    ->join('unidades', 'unidades.id', 'produtos.unidade_id')
                    ->join('grupo_produtos', 'grupo_produtos.id', 'produtos.grupo_produto_id')
                    ->where('produtos.id', $request->searchField)
                    ->orWhere('produto_descricao', 'like', '%' . $request->searchField . '%')
                    ->orWhere('produto_desc_red', 'like', '%' . $request->searchField . '%')
                    ->paginate();
            } else {
                $produtos = DB::table('produtos')
                    ->select('produtos.*', 'unidades.unidade', 'grupo_produtos.grupo_produto')
                    ->join('unidades', 'unidades.id', 'produtos.unidade_id')
                    ->join('grupo_produtos', 'grupo_produtos.id', 'produtos.grupo_produto_id')
                    ->paginate();
            }

            return View('produto.index')->withProdutos($produtos)->withFields($this->fields);
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
        if (Auth::user()->canCadastrarProduto()) {
            return View('produto.create', [
                'unidades' => Unidade::where('ativo', true)->get(),
                'grupoProdutos' => GrupoProduto::where('ativo', true)->get(),
                'listaEstoques' => Estoque::where('ativo', true)->get(),
                'fornecedores' => Fornecedor::where('ativo', true)->get()
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
        if (Auth::user()->canCadastrarProduto()) {
            $this->validate($request, [
                'produto_descricao' => 'required|string|min:3|max:60|unique:produtos',
                'produto_desc_red' => 'nullable|string|min:3|max:10',
                'unidade_id' => 'required',
                'grupo_produto_id' => 'required',
            ]);

            try {
                DB::beginTransaction();
                $produto = new Produto($request->all());

                if ($produto->save()) {
                    $produto->fornecedores()->sync($request->fornecedores);
                    $produto->estoques()->sync($request->estoques);

                    DB::commit();

                    event(new NovoRegistroAtualizacaoApp($produto));

                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.produto'),
                        'name' => $produto->produto_descricao
                    ]));
                    return redirect()->action('ProdutoController@index');
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
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit(Produto $produto)
    {
        if (Auth::user()->canAlterarProduto()) {
            $estoqueProdutos = array();
            foreach ($produto->estoques()->get() as $estoqueProduto) {
                $pivot = $estoqueProduto->pivot;
                $estoqueProdutos[] = [
                    'estoque_id' => $pivot->estoque_id,
                    'estoque_minimo' => $pivot->estoque_minimo
                ];
            }
            return View('produto.edit', [
                'produto' => $produto,
                'unidades' => Unidade::has('produtos')->orWhere('ativo', true)->get(),
                'grupoProdutos' => GrupoProduto::has('produtos')->orWhere('ativo', true)->get(),
                'listaEstoques' => Estoque::has('produtos')->orWhere('ativo', true)->get(),
                'estoques' => $estoqueProdutos,
                'fornecedores' => Fornecedor::has('produtos')->orWhere('ativo', true)->get()

                //$produto->fornecedores()->get()//Fornecedor::where('ativo', true)->get()
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
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produto $produto)
    {
        if (Auth::user()->canAlterarProduto()) {
            $this->validate($request, [
                'produto_descricao' => 'required|string|min:3|max:60|unique:produtos,id,' . $request->id,
                'produto_desc_red' => 'nullable|string|min:3|max:10',
                'unidade_id' => 'required',
                'grupo_produto_id' => 'required',
            ]);

            try {
                DB::beginTransaction();
                $produto->fill($request->all());

                if ($produto->save()) {
                    $produto->fornecedores()->sync($request->fornecedores);
                    $produto->estoques()->sync($request->estoques);

                    DB::commit();

                    event(new NovoRegistroAtualizacaoApp($produto));

                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.produto'),
                        'name' => $produto->produto_descricao
                    ]));
                    return redirect()->action('ProdutoController@index');
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
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produto $produto)
    {
        if (Auth::user()->canExcluirProduto()) {
            try {
                $produto = Produto::find($produto->id);
                if ($produto->delete()) {

                    event(new NovoRegistroAtualizacaoApp($produto, true));

                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.produto'),
                        'name' => $produto->produto_descricao
                    ]));
                    return redirect()->action('ProdutoController@index');
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
                return redirect()->action('ProdutoController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function obterProdutosPeloEstoque($estoqueId)
    {
        $estoque = Estoque::find($estoqueId);
        $result = [];
        if (!$estoque->permite_estoque_negativo) {
            $produtos = $estoque->produtos()->get();
            foreach ($produtos as $produto) {
                $posicao = $estoque->saldo_produto($produto);
                //if ($posicao > 0) {
                $produto->posicao_estoque = $posicao;
                $result[] = $produto;
                //}
            }
        } else {
            //Log::info('não controla estoque negativo');
            $produtos = $estoque->produtos()->get();

            foreach ($produtos as $produto) {
                $produto->posicao_estoque = null;
                $result[] = $produto;
            }
        }

        return $result;
    }

    public function obterProdutosPeloGrupo(Request $request)
    {
        //$grupoProduto = GrupoProduto::find($request->id);

        //return response()->json($grupoProduto->produtos()->get());
        //dd($request);
        return response()->json(Produto::ativo()->where('grupo_produto_id', $request->id)->get());
    }

    public function apiProdutos()
    {
        return response()->json(Produto::ativo()->get());
    }

    public function apiProduto($id)
    {
        return response()->json(Produto::ativo()->where('id', $id)->get());
    }

    public function paramlistagemprodutos()
    {
        // $produtos = Produto::where('ativo', true)->get();
        return View('relatorios.produtos.param_listagem_produtos', [
            'estoques' => Estoque::where('ativo', true)->get(),
            'grupo_produtos' => GrupoProduto::where('ativo', true)->get(),
            'produtos' => Produto::where('ativo', true)->get()
        ]);
    }

    public function relatoriolistagemprodutos(Request $request)
    {
        $parametros = array();
        //$whereData = '1 = 1';

        if ($request->estoque_id > 0) {
            $whereEstoque = 'produtos.estoque_id = ' . $request->estoque_id;
            array_push($parametros, 'Estoque: ' . (Estoque::find($request->estoque_id)->estoque));
        } else {
            $whereEstoque = '1 = 1';
        }

        if (($request->grupo_produto_id > 0)) {
            $whereGrupo = 'produtos.grupo_produto_id = ' . $request->grupo_produto_id;
            array_push($parametros, 'Grupo de Produto: ' . (GrupoProduto::find($request->grupo_produto_id)->grupo_produto));
        } else {
            $whereGrupo = '1 = 1';
        }
        if ($request->produto_id > 0) {
            $whereProduto = 'produtos.id = ' . $request->produto_id;
            array_push($parametros, 'Produto: ' . (Produto::find($request->produto_id)->produto_descricao));
        } else {
            $whereProduto = '1 = 1';
        }

        $grupos = DB::table('grupo_produtos')
            ->select('grupo_produtos.id', 'grupo_produtos.grupo_produto')
            ->leftJoin('produtos', 'produtos.grupo_produto_id', 'grupo_produtos.id')
            ->whereRaw($whereGrupo)
            ->whereRaw($whereProduto)
            ->orderBy('grupo_produtos.grupo_produto')
            ->distinct()
            ->get();



        foreach ($grupos as $grupoproduto) {

            if ($request->produto_id > 0) {
                $produto = DB::table('produtos')
                    ->select(
                        'produtos.id',
                        'produtos.produto_descricao',
                        'produtos.valor_custo',
                        'produtos.valor_venda'
                    )
                    ->join('grupo_produtos', 'produtos.grupo_produto_id', 'grupo_produtos.id')
                    ->where('produtos.grupo_produto_id', $grupoproduto->id)
                    ->whereRaw($whereProduto)
                    ->orderBy('produtos.produto_descricao')
                    ->get();
            } else {
                $produto = DB::table('produtos')
                    ->select(
                        'produtos.id',
                        'produtos.produto_descricao',
                        'produtos.valor_custo',
                        'produtos.valor_venda'
                    )
                    ->join('grupo_produtos', 'produtos.grupo_produto_id', 'grupo_produtos.id')
                    ->where('produtos.grupo_produto_id', $grupoproduto->id)
                    //->whereRaw($whereProduto)
                    ->orderBy('produtos.produto_descricao')
                    ->get();
            }



            $grupoproduto->produtos = $produto;
        }
        

        return View('relatorios.produtos.relatorio_listagem_produtos')
            ->withgrupoprodutos($grupos)
            ->withTitulo('Listagem de Produto')
            ->withParametros($parametros)
            ->withParametro(Parametro::first());
    }
}
