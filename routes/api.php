<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('login', 'AuthController@login');

Route::middleware('auth:api')->group(function(){
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

    Route::get('veiculos', 'VeiculoController@apiIndex');

    Route::get('atualizacoes/{idUltimaAtualizacao?}', 'AtualizacaoAppController@obterAtualizacoes');

    //Route::get('clientes', 'ClienteController@apiClientes');
    Route::get('cliente/{id}', 'ClienteController@apiCliente');
    

    Route::get('combustiveis', 'CombustivelController@apiCombustiveis');
    Route::get('combustivel/{id}', 'CombustivelController@apiCombustivel');

    Route::get('departamentos', 'DepartamentoController@apiDepartamentos');
    Route::get('departamento/{id}', 'DepartamentoController@apiDepartamento');

    Route::get('grupo_produtos', 'GrupoProdutoController@apiGrupoProdutos');
    Route::get('grupo_produto/{id}', 'GrupoProdutoController@apiGrupoProduto');

    Route::get('grupo_servicos', 'GrupoServicoController@apiGrupoServicos');
    Route::get('grupo_servico/{id}', 'GrupoServicoController@apiGrupoServico');

    Route::get('grupo_veiculos', 'GrupoVeiculoController@apiGrupoVeiculos');
    Route::get('grupo_veiculo/{id}', 'GrupoVeiculoController@apiGrupoVeiculo');

    Route::get('marca_veiculos', 'MarcaVeiculoController@apiMarcaVeiculos');
    Route::get('marca_veiculo/{id}', 'MarcaVeiculoController@apiMarcaVeiculo');

    Route::get('modelo_veiculos', 'ModeloVeiculoController@apiModeloVeiculos');
    Route::get('modelo_veiculo/{id}', 'ModeloVeiculoController@apiModeloVeiculo');

    //Route::get('produtos', 'ProdutoController@apiProdutos');
    Route::get('produto/{id}', 'ProdutoController@apiProduto');

    Route::get('servicos', 'ServicoController@apiServicos');
    Route::get('servico/{id}', 'ServicoController@apiServico');

    //Route::get('veiculos', 'VeiculoController@apiVeiculos');
    //Route::get('veiculo/{id}', 'VeiculoController@apiVeiculo');
});
Route::get('produtos', 'ProdutoController@apiProdutos');

Route::get('abastecimentos', 'AbastecimentoController@apiAbastecimentos');
Route::get('veiculos', 'VeiculoController@apiVeiculos');
Route::get('veiculo/{id}', 'VeiculoController@apiVeiculo');
Route::get('veiculoscliente', 'VeiculoController@apiVeiculosClientes');
Route::get('clientes', 'ClienteController@apiClientes');