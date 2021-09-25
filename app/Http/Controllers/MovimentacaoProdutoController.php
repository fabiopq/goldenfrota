<?php

namespace App\Http\Controllers;

use App\Estoque;
use App\Produto;
use App\Parametro;
use App\Inventario;
use App\GrupoProduto;
use App\OrdemServico;
use App\SaidaEstoque;
use App\EntradaEstoque;
use App\MovimentacaoProduto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class MovimentacaoProdutoController extends Controller
{
    static public function entradaEstoque(EntradaEstoque $entradaEstoque) {
        try {
            foreach ($entradaEstoque->entrada_estoque_items as $item) {
                $entradaEstoque->movimentacao_produto()->create([
                    'data_movimentacao' => $entradaEstoque->data_entrada,
                    'estoque_id' => $entradaEstoque->estoque_id,
                    'produto_id' => $item->produto_id,
                    'tipo_movimentacao_produto_id' => 1,
                    'quantidade_movimentada' => $item->quantidade,
                    'entrada_estoque_id' => $entradaEstoque->id
                ]);
            }

            return true;
                /* $entradas[] = [
                    'data_movimentacao_produto' => $entradaEstoque->data_entrada,
                    'estoque_id' => $entradaEstoque->estoque_id,
                    'produto_id' => $item->produto_id,
                    'tipo_movimentacao_produto_id' => 1,
                    'quantidade_movimentada' => $item->quantidade,
                    'entrada_estoque_id' => $entradaEstoque->id
                ];
            }
            return $entradaEstoque->movimentacao_produto()->createMany($entradas); */

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        } 
    }

    static public function saidaEstoque(SaidaEstoque $saidaEstoque) {
        try {
            foreach ($saidaEstoque->saida_estoque_items as $item) {
                $saidaEstoque->movimentacao_produto()->create([
                    'data_movimentacao' => $saidaEstoque->data_saida,
                    'estoque_id' => $saidaEstoque->estoque_id,
                    'produto_id' => $item->produto_id,
                    'tipo_movimentacao_produto_id' => 2,
                    'quantidade_movimentada' => $item->quantidade,
                    //'saida_estoque_id' => $saidaEstoque->id
                ]);
            }

            return true;
                /* $saidas[] = [
                    'data_movimentacao_produto' => $entradaEstoque->data_entrada,
                    'estoque_id' => $entradaEstoque->estoque_id,
                    'produto_id' => $item->produto_id,
                    'tipo_movimentacao_produto_id' => 1,
                    'quantidade_movimentada' => $item->quantidade,
                    'entrada_estoque_id' => $entradaEstoque->id
                ];
            }
            return $entradaEstoque->movimentacao_produto()->createMany($entradas); */

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        } 
    }


    static public function consolidarInventario(Inventario $inventario) {
        try {
            foreach ($inventario->inventario_items as $item) {
                /* 
                    3 = Entrada - Inventario
                    4 = Saída - Inventário
                
                se a quantidade contada for null, quer dizer que 
                não deve ajustar o estoque deste produto 
                */
                if ($item->qtd_contada >= 0) {
                    $tipoMov = ($item->qtd_ajuste > 0) ? 3 : 4;
                    $qtd = ($item->qtd_ajuste < 0) ? $item->qtd_ajuste * -1 : $item->qtd_ajuste;

                    $inventario->movimentacao_produto()->create([
                        'data_movimentacao' => $inventario->data_fechamento,
                        'estoque_id' => $inventario->estoque_id,
                        'produto_id' => $item->produto_id,
                        'tipo_movimentacao_produto_id' =>  $tipoMov,
                        'quantidade_movimentada' => $qtd,
                        'inventario_id' => $inventario->id
                    ]);
                }
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    static public function saidaOrdemServico(OrdemServico $ordemServico) {
        try {
            /* //usar o metodo sync se possível...
            $ordemServico->movimentacao_produto->sync(); */

            //remove saidas para a ordem de serviço se houver antes de inserir as atuais
            foreach ($ordemServico->movimentacao_produto()->get() as $OSMovimentacao) {
                Log::debug('removendo Movimentacao: '.$OSMovimentacao);
                $OSMovimentacao->delete();
            }

            foreach ($ordemServico->produtos as $OrdemServicoProduto) {
                $ordemServico->movimentacao_produto()->create([
                    'data_movimentacao' => $ordemServico->created_at,
                    'estoque_id' => $ordemServico->estoque_id,
                    'produto_id' => $OrdemServicoProduto->produto_id,
                    'tipo_movimentacao_produto_id' => 5,
                    'quantidade_movimentada' => $OrdemServicoProduto->quantidade,
                    'ordem_servico_id' => $ordemServico->id
                ]);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    static public function saldoProduto(Produto $produto) {
        try {
            $entradas = (new MovimentacaoProduto)->produto()->get();
            //->tipo_movimentacao_produto()->where('eh_entrada', true)->get();

            dd($entradas);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function paramRelatorioPosicaoEstoque() {
        return View('relatorios.estoque.param_relatorio_posicao_estoque', [
            'estoques' => Estoque::all(),
            'grupo_produtos' => GrupoProduto::all(),
            'produtos' => Produto::all() 
        ]);
    }

    public function relatorioPosicaoEstoque(Request $request) {
        $parametros = array();
        $whereData = '1 = 1';

        if ($request->estoque_id > 0) {
            $whereData = 'movimentacao_produtos.estoque_id = '.$request->estoque_id;
            array_push($parametros, 'Estoque: '.(Estoque::find($request->estoque_id)->estoque)); 
        }
        if (($request->grupo_produto_id > 0) && ($request->produto_id < 0)) {
            $whereData = 'produtos.grupo_produto_id = '.$request->grupo_produto_id;
            array_push($parametros, 'Grupo de Produto: '.(GrupoProduto::find($request->grupo_produto_id)->grupo_produto)); 
        } else {
            if ($request->produto_id > 0) {
                $whereData = 'produtos.id = '.$request->produto_id;
                array_push($parametros, 'Produto: '.(Produto::find($request->produto_id)->produto_descricao));
            }
        }

        $produtos = DB::table('movimentacao_produtos')
                    ->select(
                        'produtos.id',
                        'produtos.produto_descricao',
                        DB::raw(
                            'SUM(
                                CASE tipo_movimentacao_produtos.eh_entrada
                                    WHEN 1 THEN
                                        movimentacao_produtos.quantidade_movimentada
                                    WHEN 0 THEN
                                        movimentacao_produtos.quantidade_movimentada * -1
                                END
                            ) as posicao'
                        ),
                        'estoques.estoque',
                        'grupo_produtos.grupo_produto'
                    )
                    ->leftJoin('produtos', 'produtos.id', 'movimentacao_produtos.produto_id', 'grupo_produtos.grupo_produto')
                    ->leftJoin('tipo_movimentacao_produtos', 'tipo_movimentacao_produtos.id', 'movimentacao_produtos.tipo_movimentacao_produto_id')
                    ->leftJoin('estoques', 'estoques.id', 'movimentacao_produtos.estoque_id')
                    ->leftJoin('grupo_produtos', 'grupo_produtos.id', 'produtos.grupo_produto_id')
                    ->leftJoin('estoque_produto', function($join) {
                        $join->on('estoque_produto.produto_id', 'movimentacao_produtos.produto_id');
                        $join->on('estoque_produto.estoque_id', 'movimentacao_produtos.estoque_id');
                    })
                    ->groupBy('produtos.id')
                    ->groupBy('produtos.produto_descricao')
                    ->groupBy('estoques.estoque')
                    ->groupBy('grupo_produtos.grupo_produto')
                    ->whereRaw($whereData)
                    ->get();

        return View('relatorios.estoque.relatorio_posicao_estoque')
                    ->withProdutos($produtos)
                    ->withTitulo('Posicão de Estoque')
                    ->withParametros($parametros)
                    ->withParametro(Parametro::first());
    }

    public function paramRelatorioEstoqueMinimo() {
        return View('relatorios.estoque.param_relatorio_estoque_minimo', [
            'estoques' => Estoque::all(),
            'grupo_produtos' => GrupoProduto::all()
        ]);
    }

    public function relatorioEstoqueMinimo(Request $request) {
        $parametros = array();

        if ($request->estoque_id > 0) {
            $whereEstoque = 'movimentacao_produtos.estoque_id = '.$request->estoque_id;
            array_push($parametros, 'Estoque: '.(Estoque::find($request->estoque_id)->estoque)); 
        } else {
            $whereEstoque = '1 = 1';
            array_push($parametros, 'Estoque: Todos');  
        }
        if ($request->grupo_produto_id > 0) {
            $whereGrupoProduto = 'produtos.grupo_produto_id = '.$request->grupo_produto_id;
            array_push($parametros, 'Grupo de Produto: '.(GrupoProduto::find($request->grupo_produto_id)->grupo_produto)); 
        } else {
            $whereGrupoProduto = '1 = 1';
            array_push($parametros, 'Grupo de Produto: Todos'); 
        }

        $produtos = DB::table('movimentacao_produtos')
                    ->select(
                        'produtos.id',
                        'produtos.produto_descricao',
                        DB::raw(
                            'SUM(
                                CASE tipo_movimentacao_produtos.eh_entrada
                                    WHEN 1 THEN
                                        movimentacao_produtos.quantidade_movimentada
                                    WHEN 0 THEN
                                        movimentacao_produtos.quantidade_movimentada * -1
                                END
                            ) as posicao'
                        ),
                        'estoques.estoque',
                        'estoque_produto.estoque_minimo',
                        'grupo_produtos.grupo_produto'
                    )
                    ->leftJoin('produtos', 'produtos.id', 'movimentacao_produtos.produto_id', 'grupo_produtos.grupo_produto')
                    ->leftJoin('tipo_movimentacao_produtos', 'tipo_movimentacao_produtos.id', 'movimentacao_produtos.tipo_movimentacao_produto_id')
                    ->leftJoin('estoques', 'estoques.id', 'movimentacao_produtos.estoque_id')
                    ->leftJoin('grupo_produtos', 'grupo_produtos.id', 'produtos.grupo_produto_id')
                    ->leftJoin('estoque_produto', function($join) {
                        $join->on('estoque_produto.produto_id', 'movimentacao_produtos.produto_id');
                        $join->on('estoque_produto.estoque_id', 'movimentacao_produtos.estoque_id');
                    })
                    ->whereRaw($whereEstoque)
                    ->whereRaw($whereGrupoProduto)
                    ->groupBy('produtos.id')
                    ->groupBy('produtos.produto_descricao')
                    ->groupBy('estoques.estoque')
                    ->groupBy('estoque_produto.estoque_minimo')
                    ->groupBy('grupo_produtos.grupo_produto')
                    ->orderBy('estoques.estoque', 'asc')
                    ->orderBy('produtos.produto_descricao', 'asc')
                    ->get();

        $results = array();
        foreach ($produtos as $produto) {
            if ($produto->posicao < $produto->estoque_minimo) {
                $results[] = $produto;
            }
        }

        return View('relatorios.estoque.relatorio_estoque_minimo')
                ->withProdutos($results)
                ->withTitulo('Produtos Abaixo do Estoque Mínimo')
                ->withParametros($parametros)
                ->withParametro(Parametro::first());
    }

    public function posicaoEstoqueProduto($produtoId) {
        $produto = Produto::find($produtoId);
        $parametros = ['Produto: '.$produto->produto_descricao];

        $produtos = DB::table('movimentacao_produtos')
                    ->select(
                        'produtos.id',
                        'produtos.produto_descricao',
                        DB::raw(
                            'SUM(
                                CASE tipo_movimentacao_produtos.eh_entrada
                                    WHEN 1 THEN
                                        movimentacao_produtos.quantidade_movimentada
                                    WHEN 0 THEN
                                        movimentacao_produtos.quantidade_movimentada * -1
                                END
                            ) as posicao'
                        ),
                        'estoques.estoque',
                        'grupo_produtos.grupo_produto'
                    )
                    ->leftJoin('produtos', 'produtos.id', 'movimentacao_produtos.produto_id', 'grupo_produtos.grupo_produto')
                    ->leftJoin('tipo_movimentacao_produtos', 'tipo_movimentacao_produtos.id', 'movimentacao_produtos.tipo_movimentacao_produto_id')
                    ->leftJoin('estoques', 'estoques.id', 'movimentacao_produtos.estoque_id')
                    ->leftJoin('grupo_produtos', 'grupo_produtos.id', 'produtos.grupo_produto_id')
                    ->leftJoin('estoque_produto', function($join) {
                        $join->on('estoque_produto.produto_id', 'movimentacao_produtos.produto_id');
                        $join->on('estoque_produto.estoque_id', 'movimentacao_produtos.estoque_id');
                    })
                    ->groupBy('produtos.id')
                    ->groupBy('produtos.produto_descricao')
                    ->groupBy('estoques.estoque')
                    ->groupBy('grupo_produtos.grupo_produto')
                    ->where('produtos.id', $produtoId)
                    ->get();

        return View('relatorios.estoque.relatorio_posicao_estoque')
                    ->withProdutos($produtos)
                    ->withTitulo('Posicão de Estoque')
                    ->withParametros($parametros)
                    ->withParametro(Parametro::first());
    }

    public function paramRelatorioMovimetacaoEstoque() {
        return View('relatorios.movimentacao.produto_param', [
            'estoques' => Estoque::has('movimentacao_produtos')->where('ativo', true)->get()
        ]);
    }

    public function relatorioMovimentacaoEstoque(Request $request) {
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $tipo_relatorio = $request->tipo_relatorio;
        $tipo_movimentacao = $request->tipo_movimentacao;
        $parametros = array();
        $estoquesId = array();
        
        if ($request->estoque_id == null) {
            $whereEstoque = 'estoques.ativo = 1';
            $parametros[] = 'Estoque: Todos';
        } else {
            $whereEstoque = 'estoques.id = '.$request->estoque_id;
            $parametros[] = 'Estoque: '.Estoque::find($request->estoque_id)->estoque;
        }

        if (isset($request->produto_id) && $request->produto_id != null) {
            $whereProduto = 'produtos.id = '.$request->produto_id;
            $whereGrupoProduto = '1 = 1';
            $parametros[] = 'Produto: '.Produto::find($request->produto_id)->produto_descricao;
        } else {
            if (isset($request->grupo_produto_id) && $request->grupo_produto_id != null) {
                $whereGrupoProduto = 'grupo_produtos.id = '.$request->grupo_produto_id;
                $whereProduto = '1 = 1';
                $parametros[] = 'Grupo de Produtos: '.GrupoProduto::find($request->grupo_produto_id)->grupo_produto;
            } else {
                $whereGrupoProduto = '1 = 1';
                $whereProduto = '1 = 1';
                $parametros[] = 'Grupo de Produtos: Todos';
            }
        }

        switch ($tipo_movimentacao) {
            case 1:
                //entrada
                $whereTipoMovimentacao = 'tipo_movimentacao_produtos.eh_entrada = 1';
                array_push($parametros, 'Tipo de Movimentação: Entrada');
                break;
            case 2:
                //saída
                $whereTipoMovimentacao = 'tipo_movimentacao_produtos.eh_entrada = 0';
                array_push($parametros, 'Tipo de Movimentação: Saída');
                break;
            default:
                //todos
                $whereTipoMovimentacao = '1 = 1'; //busca qualquer coisa
                array_push($parametros, 'Tipo de Movimentação: Todos');
                break;
        }

        if($data_inicial && $data_final) {
            $whereData = 'data_movimentacao between \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\' and \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
            array_push($parametros, 'Período de '.$data_inicial.' até '.$data_final);
        } elseif ($data_inicial) {
            $whereData = 'data_movimentacao >= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\'';
            array_push($parametros, 'A partir de '.$data_inicial);
        } elseif ($data_final) {
            $whereData = 'data_movimentacao <= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
            array_push($parametros, 'Até '.$data_final);
        } else {
            $whereData = '1 = 1'; //busca qualquer coisa
        }
        
        $estoques = Estoque::whereHas('movimentacao_produtos')
                                ->with(['produtos' => function($query) use ($whereProduto, $whereGrupoProduto, $whereData, $whereTipoMovimentacao) {
                                    $query->whereRaw($whereProduto)
                                            ->with(['grupo_produto' => function($queryGrupoProduto) use ($whereGrupoProduto) {
                                                $queryGrupoProduto->whereRaw($whereGrupoProduto)->get();
                                            }])
                                            ->join('grupo_produtos', 'grupo_produtos.id', 'produtos.grupo_produto_id')
                                            ->whereHas('grupo_produto' ,function($queryGrupoProduto) use ($whereGrupoProduto) {
                                                $queryGrupoProduto->whereRaw($whereGrupoProduto);
                                            })
                                            ->with(['movimentacao_produto' => function($query) use ($whereData, $whereTipoMovimentacao) {
                                                $query->whereRaw($whereData)
                                                            ->with('tipo_movimentacao_produto')
                                                            ->whereHas('tipo_movimentacao_produto', function($queryTipoMov) use ($whereTipoMovimentacao) {
                                                                $queryTipoMov->whereRaw($whereTipoMovimentacao);
                                                            })
                                                            ->orderBy('data_movimentacao', 'asc')->get();                                            
                                            }])
                                            ->whereHas('movimentacao_produto', function($query) use ($whereData, $whereTipoMovimentacao) {
                                                $query->whereRaw($whereData)
                                                        ->whereHas('tipo_movimentacao_produto', function($queryTipoMov) use ($whereTipoMovimentacao) {
                                                            $queryTipoMov->whereRaw($whereTipoMovimentacao);
                                                        });    
                                            })
                                            ->orderBy('grupo_produtos.grupo_produto', 'asc')
                                            ->orderBy('produtos.produto_descricao', 'asc')->get();
                                }])
                                ->whereRaw($whereEstoque)
                                ->orderBy('estoques.estoque', 'asc')
                                ->get();
                               

        if ($request->tipo_relatorio == 1) {
            /* relatório sintetico */
            return View('relatorios.movimentacao.produto_sintetico')
                    ->withEstoques($estoques)
                    ->withTitulo('Movimentação de Estoque - Produtos - Sintético')
                    ->withParametros($parametros)
                    ->withParametro(Parametro::first());
        } else {
            /* relatório analítico */
            return View('relatorios.movimentacao.produto_analitico')
                    ->withEstoques($estoques)
                    ->withTitulo('Movimentação de Estoque - Produtos - Analítico')
                    ->withParametros($parametros)
                    ->withParametro(Parametro::first());
        }
        
        
    }

    public function destroy(MovimentacaoProduto $movimentacaoProduto) {
        try {
            $movimentacaoProduto->delete();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
