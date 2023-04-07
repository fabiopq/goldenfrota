<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
/* Route::get('/teste', function() {
    return View('teste');
}); */

Route::middleware(['auth:web'])->group(function() {

    Route::get('/', 'HomeController@index')->name('home');
    /* Route::get('/', 'DashboardController@index')->name('home'); */

    Route::get('/perfil', 'UserController@profile')->name('user.profile');
    Route::get('/alterar_senha', 'UserController@showChangePassword')->name('user.form.change.password');
    Route::put('/alterar_senha/{user}', 'UserController@changePassword')->name('user.change.password');

    Route::resource('/combustivel', 'CombustivelController')->except('show');
    Route::resource('/tipo_bomba', 'TipoBombaController')->except('show');
    Route::resource('/modelo_bomba', 'ModeloBombaController')->except('show');
    Route::resource('/tanque', 'TanqueController')->except('show');
    Route::resource('/bomba', 'BombaController')->except('show');
    Route::resource('/user', 'UserController')->except('show');
    Route::resource('/grupo_produto', 'GrupoProdutoController');
    Route::resource('/grupo_servico', 'GrupoServicoController');
    Route::resource('/unidade', 'UnidadeController')->except('show');
    Route::resource('/produto', 'ProdutoController')->except('show');
    Route::resource('/bico', 'BicoController')->except('show');
    Route::resource('/marca_veiculo', 'MarcaVeiculoController')->except('show');
    Route::resource('/modelo_veiculo', 'ModeloVeiculoController')->except('show');
    Route::resource('/cliente', 'ClienteController')->except('show');
    Route::resource('/veiculo', 'VeiculoController')->except('show');
    Route::resource('/grupo_veiculo', 'GrupoVeiculoController')->except('show');
    Route::resource('/atendente', 'AtendenteController')->except('show');
    Route::resource('/abastecimento', 'AbastecimentoController');
    Route::resource('/tanque_movimentacao', 'TanqueMovimentacaoController')->except('show');
    Route::resource('/departamento', 'DepartamentoController')->except('show');
    Route::resource('/fornecedor', 'FornecedorController')->except('show');
    Route::resource('/estoque', 'EstoqueController')->except('show');
    Route::resource('/parametro', 'ParametroController')->except('show');
    
     
    Route::resource('/tipo_movimentacao_produto', 'TipoMovimentacaoProdutoController')->except('show');
    Route::resource('/entrada_estoque', 'EntradaEstoqueController');
    Route::resource('/entrada_tanque', 'EntradaTanqueController');
    Route::resource('/saida_estoque', 'SaidaEstoqueController')->except(['edit', 'update']);
    Route::resource('/inventario', 'InventarioController');
    Route::resource('/posicao_pneu', 'PosicaoPneuController')->except(['show']);
    Route::resource('/servico', 'ServicoController')->except(['show']);
    Route::resource('/ordem_servico', 'OrdemServicoController');
    Route::resource('/ajuste_tanque', 'AjusteTanqueController')->except(['show', 'edit']);
    Route::resource('/ordem_servico_status', 'OrdemServicoStatusController')->except(['show']);
    Route::resource('/motorista', 'MotoristaController')->except(['show', 'edit', 'update', 'delete']);
    Route::get('/motorista/{motorista}/edit', 'MotoristaController@edit')->name('motorista.edit');
    Route::put('/motorista/{motorista}', 'MotoristaController@update')->name('motorista.update');
    Route::delete('/motorista/{motorista}', 'MotoristaController@destroy')->name('motorista.destroy');
    
    Route::resource('/role_user', 'RoleUsersController')->except('show');
    Route::resource('/role', 'RolesController')->except('show');

    /* Route::get('/parametro', 'ParametroController@index')->name('parametro.index');
    Route::post('/parametro', 'ParametroController@store')->name('parametro.store');
    Route::put('/parametro/{parametro}', 'ParametroController@update')->name('parametro.update'); */


    Route::get('/exportacao', 'IntegracaoAutomacaoController@Exportar')->name('exportacao');
    Route::get('/exportacao_atendentes', 'IntegracaoAutomacaoController@ExportarAtendentes')->name('exportacao_atendentes');
    Route::get('/exportacao_motoristas', 'IntegracaoAutomacaoController@ExportarMotoristas')->name('exportacao_motoristas');
    Route::get('/exportacao_veiculos', 'IntegracaoAutomacaoController@ExportarVeiculos')->name('exportacao_veiculos');
    Route::get('/exportacao_produtos', 'IntegracaoAutomacaoController@ExportarProdutos')->name('exportacao_produtos');
    
    Route::get('/importacao', 'IntegracaoAutomacaoController@ImportarAbastecimentos')->name('importacao');
   // Route::view('/param_teste_exportar_hiro', 'integracao_hiro.index');
  //Route::get('/param_teste_exportar_hiro', 'IntegracaoAutomacaoController@ParamTesteExportarHiro')->name('param_teste_exportar_hiro');
   // Route::post('/teste_hiro_exportacao', 'IntegracaoAutomacaoController@TesteExportarHiro')->name('teste_exportar_hiro');

    Route::post('modelo_veiculo/json', 'ModeloVeiculoController@getModelosJson')->name('modelo_veiculos.json');
    Route::post('modelo_veiculo_marca/json', 'ModeloVeiculoController@getModeloMarcaJson')->name('modelo_veiculos_marca.json');
    Route::post('departamento/json', 'DepartamentoController@getDepartamentosJson')->name('departamentos.json');
    Route::post('unidade/json', 'UnidadeController@getUnidadesJson')->name('unidades.json');
    Route::post('veiculo/json', 'VeiculoController@getVeiculosJson')->name('veiculos.json');
    
    Route::post('veiculo/jsonComponent', 'VeiculoController@getVeiculosComponentJson')->name('veiculosComponent.json');
    Route::post('bico/json', 'BicoController@getBicoJson')->name('bico.json');
    Route::post('veiculo_departamento/json', 'VeiculoController@getVeiculosDepartamentoJson')->name('veiculos_departamento.json');
    Route::post('tanques/json', 'TanqueController@getTanquesJson')->name('tanques.json');
    Route::post('ultimo_abastecimento/json', 'VeiculoController@obterKmAbasteciemntoAnterior')->name('ultimo_abastecimento.json');
    Route::post('grupo_produto/json', 'GrupoProdutoController@getGrupoProdutoJson')->name('grupo_produto.json');
    Route::post('produto_pelo_grupo/json', 'ProdutoController@obterProdutosPeloGrupo')->name('produtos_pelo_grupo.json');
    Route::get('produtos_estoque/{estoqueId}/json', 'ProdutoController@obterProdutosPeloEstoque')->name('produto_pelo_estoque');
    Route::get('posicao_estoque_produto/{produtoId}', 'MovimentacaoProdutoController@posicaoEstoqueProduto')->name('posicao_estoque_produto');
    Route::get('produtos_vencendo_vencidos/{veiculo}', 'VencimentoProdutoController@getProdutosVencendoVencidosPorVeiculo');
    //Route::resource('/movimentacao_credito', 'MovimentacaoCreditoController');
    Route::resource('/movimentacao_credito', 'MovimentacaoCreditoController');
   
   
    //relatorios
    Route::get('relatorios/posicao_tanques', 'TanqueController@relPosicaoTanque')->name('relatorio_posicao_tanques');
    Route::get('relatorios/media_consumo', 'VeiculoController@relMediaConsumo')->name('relatorio_media_consumo');
    Route::get('relatorios/listagem_tanques', 'TanqueController@listagemTanques')->name('relatorio_listagem_tanques');
    Route::get('relatorios/listagem_veiculos', 'VeiculoController@parametrosListagemVeiculos')->name('relatorio_listagem_veiculos');
    Route::post('relatorios/listagem_veiculos', 'VeiculoController@listagemVeiculos')->name('relatorio_listagem_veiculos');
    Route::get('relatorios/listagem_clientes', 'ClienteController@listagemClientes')->name('relatorio_listagem_clientes');
    Route::get('relatorios/listagem_motoristas', 'MotoristaController@listagemMotoristas')->name('relatorio_listagem_motoristas');
    Route::get('relatorios/listagem_combustiveis', 'CombustivelController@listagemCombustiveis')->name('relatorio_listagem_combustiveis');
    Route::get('relatorios/abastecimentos', 'AbastecimentoController@parametrosRelatorio')->name('param_relatorio_abastecimentos');
    Route::post('relatorios/abastecimentos', 'AbastecimentoController@relatorioAbastecimentos')->name('param_relatorio_abastecimentos');
    Route::get('relatorios/abastecimentos_bico', 'AbastecimentoController@relatorioAbastecimentosBicoParam')->name('param_relatorio_abastecimentos_bico');
    Route::post('relatorios/abastecimentos_bico', 'AbastecimentoController@relatorioAbastecimentosBico')->name('relatorio_abastecimentos_bico');
    Route::get('relatorios/media_modelo', 'VeiculoController@relatorioMediaModeloParam')->name('param_relatorio_media_modelo');
    Route::post('relatorios/media_modelo', 'VeiculoController@relatorioMediaModelo')->name('relatorio_media_modelo');
    Route::get('relatorios/posicao_estoque', 'MovimentacaoProdutoController@paramRelatorioPosicaoEstoque')->name('param_relatorio_posicao_estoque');
    Route::post('relatorios/posicao_estoque', 'MovimentacaoProdutoController@relatorioPosicaoEstoque')->name('relatorio_posicao_estoque');
    Route::get('relatorios/estoque_minimo', 'MovimentacaoProdutoController@paramRelatorioEstoqueMinimo')->name('param_relatorio_estoque_minimo');
    Route::post('relatorios/estoque_minimo', 'MovimentacaoProdutoController@relatorioEstoqueMinimo')->name('relatorio_estoque_minimo');
    Route::get('relatorios/movimentacao_produto', 'MovimentacaoProdutoController@paramRelatorioMovimetacaoEstoque')->name('param_relatorio_movimentacao_estoque');
    Route::post('relatorios/movimentacao_produto', 'MovimentacaoProdutoController@relatorioMovimentacaoEstoque')->name('relatorio_movimentacao_estoque');
    Route::get('relatorios/grupo_produto', 'GrupoProdutoController@listagemGrupoProduto')->name('relatorio_listagem_grupo_produto');
    Route::get('relatorios/afericoes', 'AfericaoController@relatorioAfericaoParam')->name('param_relatorio_afericoes');
    Route::post('relatorios/afericoes', 'AfericaoController@relatorioAfericao')->name('relatorio_afericoes');
    Route::get('relatorios/ordem_servicos', 'OrdemServicoController@paramRelatorioOrdemServicos')->name('param_relatorio_ordem_servicos');
    Route::post('relatorios/ordem_servicos', 'OrdemServicoController@RelatorioOrdemServicos')->name('relatorio_ordem_servicos');
    Route::get('relatorios/saida_estoque', 'SaidaEstoqueController@paramRelatorioSaidaEstoque')->name('param_relatorio_saida_estoque');
    Route::post('relatorios/saida_estoque', 'SaidaEstoqueController@RelatorioSaidaEstoque')->name('relatorio_saida_estoque');



    Route::get('relatorios/servicos', 'ServicoController@listagemServicos')->name('relatorio_listagem_servicos');
    Route::get('relatorios/produtos', 'ProdutoController@paramlistagemprodutos')->name('param_relatorio_listagem_produtos');
    Route::post('relatorios/produtos', 'ProdutoController@relatoriolistagemprodutos')->name('relatorio_listagem_produtos');
    Route::get('setting', 'SettingController@index')->name('setting.index');
    Route::put('setting', 'SettingController@update')->name('setting.update');
    Route::get('afericao/{abastecimento}', 'AfericaoController@create')->name('afericao.create');
    Route::post('afericao', 'AfericaoController@store')->name('afericao.store');

    /* dashboard */
    Route::get('/pos_tanque_30_dias', 'TanqueMovimentacaoController@posTanque30Dias');
    Route::get('/dashboard/mov_tanque', 'DashboardController@movTanque');
    Route::get('/dashboard/ultimas_entradas_comb', 'DashboardController@ultimasEntradasComb');
    Route::get('/dashboard/saldo_tanques', 'DashboardController@saldoTanques');
    Route::get('/dashboard/total_veiculos_frota', 'DashboardController@totalVeiculosFrota');
    Route::get('/dashboard/abastecimentos_hoje', 'DashboardController@abastecimentosHoje');
    Route::get('/dashboard/clientes_cadastrados', 'DashboardController@totalClientesCadastrados');
    Route::get('/dashboard/motoristas_cadastrados', 'DashboardController@totalMotoristasCadastrados');
    Route::get('/dashboard/os_em_aberto', 'DashboardController@osEmAberto');
});

Route::resource('/importa', 'ImportaController')->except('show');
Route::resource('/ticket', 'TicketController');
Route::post('combustivel/json', 'CombustivelController@getCombustivelJson')->name('combustivel.json');
Route::post('movimentacao_credito/json', 'MovimentacaoCreditoController@getSaldoCreditoJson')->name('saldocredito.json');
Route::get('renovar', 'MovimentacaoCreditoController@renovarCredito');
Route::get('chart', [ChartJSController::class, 'index']);

Route::get(
    'teste/{id}/{arquivo}',
    function ($id, $arquivo) {

        $file =  storage_path() . '/app' . '/documentos/devedor/' . $id . '/' . $arquivo;
        return response()->download($file);
    }
)->middleware('auth');

//************ */
//Route::get('/teste', 'GrupoProdutoController@teste');

/*Route::get('/param_teste_exportar_hiro', function() {
    return View('integracao_hiro.index');
});
 */
/* Route::get('relatorios/abastecimentos/imprimir', 'AbastecimentoController@gerarPdfRelatorioAbastecimentos')->name('imprimir_relatorio_abastecimentos'); */
/* 
Route::get('teste', 'IntegracaoAutomacaoController@configFTP')->name('teste');

Route::get('g', 'TanqueController@relPosicaoTanque');
 */
