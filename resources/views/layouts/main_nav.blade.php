<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary">
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('images/logo_golden.png') }}" alt="Golden Service - Controle de Frotas">
        {{--  {{ env('APP_NAME') }}  --}}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavBar" aria-controls="mainNavBar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavBar">
        @auth
        {{--  Left Align Begin --}}
        {{--  Cofigurações  --}}
        <ul class="nav navbar-nav mr-auto">
            @role(['super', 'administrador'])
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownConfiguracoes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Configurações
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownConfiguracoes">
                    {{--  Combustiveis  --}}
                    <li>
                        <a class="dropdown-item dropdown-toggle" href="#">Combustíveis</a>
                        <ul class="dropdown-menu">
                            @permission('listar-tanque')
                            <li><a class="dropdown-item" href="{{route('tanque.index')}}">Tanques</a></li>
                            @endpermission
                            @permission('listar-bomba')
                            <li><a class="dropdown-item" href="{{route('bomba.index')}}">Bombas</a></li>
                            @endpermission
                            @permission('listar-bico')
                            <li><a class="dropdown-item" href="{{route('bico.index')}}">Bicos</a></li>
                            @endpermission
                            <div class="dropdown-divider"></div>
                            @permission('listar-tipo-bomba')
                            <li><a class="dropdown-item" href="{{route('tipo_bomba.index')}}">Tipos de Bomba</a></li>
                            @endpermission
                            @permission('listar-modelo-bomba')
                            <li><a class="dropdown-item" href="{{route('modelo_bomba.index')}}">Modelos de Bomba</a></li>
                            @endpermission
                        </ul>
                    </li>
                    {{--  Produtos  --}}
                    <li>
                        <a class="dropdown-item dropdown-toggle" href="#">Produtos</a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                @permission('listar-unidade')
                                <li><a class="dropdown-item" href="{{route('unidade.index')}}">Unidades</a></li>
                                @endpermission
                            </li>
                        </ul>
                    </li>
                    {{--  Controle de Acesso  --}}
                    <li>
                        <a class="dropdown-item dropdown-toggle" href="#">Controle de Acesso</a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                @permission('listar-user')
                                <li><a class="dropdown-item" href="{{route('user.index')}}">Usuários</a></li>
                                @endpermission
                                @permission('listar-role')
                                <li><a class="dropdown-item" href="{{route('role.index')}}">Perfis de Acesso</a></li>
                                @endpermission
                                @permission('listar-role-user')
                                <li><a class="dropdown-item" href="{{route('role_user.index')}}">Associação de Usuários e Perfis de Acesso</a></li>
                                @endpermission
                            </li>
                        </ul>
                    </li>
                    {{--  Ordem de Serviços  --}}
                    <li>
                        <a class="dropdown-item dropdown-toggle" href="#">Ordem de Serviços</a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                @permission('listar-ordem-servico-status')
                                <li><a class="dropdown-item" href="{{route('ordem_servico_status.index')}}">Status de Ordem de Serviço</a></li>
                                @endpermission
                            </li>
                        </ul>
                    </li>
                    {{--  Parametros  --}}
                    <div class="dropdown-divider"></div>
                    <li><a class="dropdown-item" href="{{route('parametro.create')}}">Parâmetros</a></li>
                    {{--  Configurações administrativas  --}}
                    @role('super')
                    <div class="dropdown-divider"></div>
                    <li><a class="dropdown-item" href="{{route('setting.index')}}">Configurações</a></li>            
                    @endrole
                </ul>
            </li>
            @endrole
            {{--  Produtos  --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownProdutos" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Produtos
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownProdutos">
                    @permission('listar-combustivel')
                    <li><a class="dropdown-item" href="{{route('combustivel.index')}}">Combustíveis</a></li>
                    @endpermission
                    @permission('listar-produto')
                    <li><a class="dropdown-item" href="{{route('produto.index')}}">Produtos</a></li>
                    @endpermission
                    @permission('listar-grupo-produto')
                    <li><a class="dropdown-item" href="{{route('grupo_produto.index')}}">Grupos de Produto</a></li>
                    @endpermission
                    @permission('listar-estoque')
                    <li><a class="dropdown-item" href="{{route('estoque.index')}}">Estoques</a></li>
                    @endpermission
                    <div class="dropdown-divider"></div>
                    @permission('listar-servico')
                    <li><a class="dropdown-item" href="{{route('servico.index')}}">Serviços</a></li>
                    @endpermission
                    @permission('listar-grupo-servico')
                    <li><a class="dropdown-item" href="{{route('grupo_servico.index')}}">Grupos de Serviço</a></li>
                    @endpermission
                </ul>
            </li>
            {{--  Veículos  --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownVeiculos" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Veículos
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownVeiculos">
                    @permission('listar-veiculo')
                    <li><a class="dropdown-item" href="{{route('veiculo.index')}}">Veículos</a></li>
                    @endpermission
                    @permission('listar-grupo-veiculo')
                    <li><a class="dropdown-item" href="{{route('grupo_veiculo.index')}}">Grupos de Veículo</a></li>
                    @endpermission
                    <div class="dropdown-divider"></div>
                    @permission('listar-marca-veiculo')
                    <li><a class="dropdown-item" href="{{route('marca_veiculo.index')}}">Marcas de Veículo</a></li>
                    @endpermission
                    @permission('listar-modelo-veiculo')
                    <li><a class="dropdown-item" href="{{route('modelo_veiculo.index')}}">Modelos de Veículo</a></li>
                    @endpermission
                    @permission('listar-posicao-pneu')
                    <li><a class="dropdown-item" href="{{route('posicao_pneu.index')}}">Posição de Pneu</a></li>
                    @endpermission
                </ul>
            </li>
            {{--  Pessoas  --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPessoas" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Pessoas
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownPessoas">
                    @permission('listar-atendente')
                    <li><a class="dropdown-item" href="{{route('atendente.index')}}">Atendentes</a></li>
                    @endpermission
                    @permission('listar-cliente')
                    <li><a class="dropdown-item" href="{{route('cliente.index')}}">Clientes</a></li>
                    @endpermission
                    @permission('listar-fornecedor')
                    <li><a class="dropdown-item" href="{{route('fornecedor.index')}}">Fornecedores</a></li>
                    @endpermission
                    <div class="dropdown-divider"></div>
                    @permission('listar-departamento')
                    <li><a class="dropdown-item" href="{{route('departamento.index')}}">Departamentos</a></li>
                    @endpermission
                    @permission('listar-motorista')
                    <li><a class="dropdown-item" href="{{route('motorista.index')}}">Motoristas</a></li>
                    @endpermission
                </ul>
            </li>
            {{--  Movimentacao  --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMovimentacao" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Movimentação
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMovimentacao">
                    @permission('listar-abastecimento')
                    <li><a class="dropdown-item" href="{{route('abastecimento.index')}}">Abastecimentos</a></li>
                    @endpermission
                    {{--  @permission('listar-tanque-movimentacao')
                    <li><a class="dropdown-item" href="{{route('tanque_movimentacao.index')}}">Entrada de Combustíveis</a></li>
                    @endpermission  --}}
                    @permission('listar-entrada-tanque')
                    <li><a class="dropdown-item" href="{{route('entrada_tanque.index')}}">Entrada de Combustíveis</a></li>
                    @endpermission
                    @permission('listar-ajuste-tanque')
                    <li><a class="dropdown-item" href="{{route('ajuste_tanque.index')}}">Ajustes de Tanque</a></li>
                    @endpermission
                    <div class="dropdown-divider"></div>
                    @permission('listar-entrada-estoque')
                    <li><a class="dropdown-item" href="{{route('entrada_estoque.index')}}">Entradas no Estoque</a></li>
                    @endpermission
                    @permission('listar-saida-estoque')
                    <li><a class="dropdown-item" href="{{route('saida_estoque.index')}}">Saídas do Estoque</a></li>
                    @endpermission
                    <div class="dropdown-divider"></div>
                    @permission('listar-inventario')
                    <li><a class="dropdown-item" href="{{route('inventario.index')}}">Inventários</a></li>
                    @endpermission
                    <div class="dropdown-divider"></div>
                    @permission('listar-ordem-servico')
                    <li><a class="dropdown-item" href="{{route('ordem_servico.index')}}">Ordens de Serviço</a></li>
                    @endpermission
                    @permission('listar-ordem-servico')
                    <li><a class="dropdown-item" href="{{route('movimentacao_credito.index')}}">Credito</a></li>
                    @endpermission
                </ul>
            </li>
            {{--  Relatorios  --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownRelatorios" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Relatórios
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownRelatorios">
                    @permission('acesso-posicao-tanques-grafico')
                    <li><a class="dropdown-item" href="{{route('relatorio_posicao_tanques')}}" target="_blank">Tanques (Gráfico)</a></li>
                    @endpermission
                    @permission('acesso-media-consumo-veiculos-grafico')
                    <li><a class="dropdown-item" href="{{route('relatorio_media_consumo')}}" target="_blank">Consumo de Veículos (Gráfico)</a></li>
                    @endpermission
                    @permission('acesso-listagem-clientes')
                    <li><a class="dropdown-item" href="{{route('relatorio_listagem_clientes')}}" target="_blank">Clientes</a></li>
                    @endpermission
                    @permission('acesso-listagem-motoristas')
                    <li><a class="dropdown-item" href="{{route('relatorio_listagem_motoristas')}}" target="_blank">Motoristas</a></li>
                    @endpermission
                    @permission('acesso-relatorio-listagem-grupo-produto')
                    <li><a class="dropdown-item" href="{{route('relatorio_listagem_grupo_produto')}}">Grupo de Produtos</a></li>
                    @endpermission
                    @permission('acesso-relatorio-listagem-combustivel')
                    <li><a class="dropdown-item" href="{{route('relatorio_listagem_combustiveis')}}" target="_blank">Combustíveis</a></li>
                    @endpermission
                    @permission('acesso-relatorio-listagem-produtos')
                    <li><a class="dropdown-item" href="{{route('param_relatorio_listagem_produtos')}}" target="_blank">Produtos</a></li>
                    @endpermission
                    @permission('acesso-listagem-servicos')
                    <li><a class="dropdown-item" href="{{route('relatorio_listagem_servicos')}}" target="_blank">Servicos</a></li>
                    @endpermission
                    @permission('acesso-listagem-veiculos')
                    <li><a class="dropdown-item" href="{{route('relatorio_listagem_veiculos')}}">Veículos</a></li>
                    @endpermission
                    @permission('acesso-listagem-tanques')
                    <li><a class="dropdown-item" href="{{route('relatorio_listagem_tanques')}}" target="_blank">Listagem de Tanques</a></li>
                    @endpermission
                    @permission('acesso-relatorio-ordem-servicos')
                    <li><a class="dropdown-item" href="{{route('param_relatorio_ordem_servicos')}}" target="_blank">Ordem de Serviços</a></li>
                    @endpermission

                    <a class="dropdown-item dropdown-toggle" href="#">Abastecimentos</a>
                    <ul class="dropdown-menu">
                    <li class="dropdown-submenu">
                        @permission('acesso-relatorio-abastecimentos')
                            <li><a class="dropdown-item" href="{{route('param_relatorio_abastecimentos')}}">Abastecimentos</a></li>
                        @endpermission
                        @permission('acesso-relatorio-abastecimentos-bico')
                            <li><a class="dropdown-item" href="{{route('param_relatorio_abastecimentos_bico')}}">Abastecimentos - Bico</a></li>
                        @endpermission
                        @permission('acesso-relatorio-media-consumo-modelo')
                            <li><a class="dropdown-item" href="{{route('param_relatorio_media_modelo')}}">Média de Consumo por Modelo</a></li>
                        @endpermission
                        @permission('acesso-relatorio-afericoes')
                            <li><a class="dropdown-item" href="{{route('param_relatorio_afericoes')}}">Aferições</a></li>
                        @endpermission
                        
                    </li>
                    </ul>

                    <a class="dropdown-item dropdown-toggle" href="#">Estoque</a>
                    <ul class="dropdown-menu">
                    <li class="dropdown-submenu">
                        @permission('acesso-relatorio-posicao-estoque')
                        <li><a class="dropdown-item" href="{{route('param_relatorio_posicao_estoque')}}">Posição de Estoque</a></li>
                        @endpermission
                        @permission('acesso-relatorio-estoque-minimo')
                        <li><a class="dropdown-item" href="{{route('param_relatorio_estoque_minimo')}}">Produtos Abaixo do Estoque Mínimo</a></li>
                        @endpermission
                        @permission('acesso-relatorio-movimentacao-estoque')
                        <li><a class="dropdown-item" href="{{route('param_relatorio_movimentacao_estoque')}}">Movimentação de Estoque - Produtos</a></li>
                        @endpermission
                        @permission('acesso-relatorio-saida-estoque')
                        <li><a class="dropdown-item" href="{{route('param_relatorio_saida_estoque')}}">Saida de Estoque - Produtos</a></li>
                        @endpermission

                    </li>
                    </ul>

                    
                    
                    {{--  <li><a class="dropdown-item" href="{{route('relatorio_media_consumo')}}">Listagem de Entradas de Combustíveis</a></li>
                    <li><a class="dropdown-item" href="{{route('relatorio_media_consumo')}}">Listagem de Entradas de Abastecimentos</a></li>  --}}
                    {{--  <li><a class="dropdown-item" href="#">Vendas de Produtos</a></li>  --}}
                </ul>
            </li>
            {{--  Automacao  --}}
            <li class="nav-item dropdown">
                
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAutomacao" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Automação
                </a>
                
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownAutomacao">
                    
                    @permission('acesso-importar-abastecimentos')
                    <li><a class="dropdown-item" href="{{route('importacao')}}">Importar Abastecimentos</a></li>
                    @endpermission
                    <a class="dropdown-item dropdown-toggle" href="#">Exportar Dados Para Console</a>
                    <ul class="dropdown-menu">
                    <li class="dropdown-submenu">
                        @permission('acesso-exportar-exportar-dados-cadastrais')
                            <li><a class="dropdown-item" href="{{route('exportacao')}}">Exportar - Todos</a></li>
                        @endpermission
                        @permission('acesso-exportar-exportar-dados-cadastrais')
                            <li><a class="dropdown-item" href="{{route('exportacao_atendentes')}}">Exportar - Atendentes</a></li>
                        @endpermission
                        @permission('acesso-exportar-exportar-dados-cadastrais')
                        <li><a class="dropdown-item" href="{{route('exportacao_produtos')}}">Exportar - Produtos</a></li>
                        @endpermission
                        @permission('acesso-exportar-exportar-dados-cadastrais')
                        <li><a class="dropdown-item" href="{{route('exportacao_veiculos')}}">Exportar - Veículos</a></li>
                        @endpermission
                        @permission('acesso-exportar-exportar-dados-cadastrais')
                        <li><a class="dropdown-item" href="{{route('exportacao_motoristas')}}">Exportar - Motoristas</a></li>
                        @endpermission
                       
                        
                    </li>
                    </ul>

                    
                </ul>
                
                
            </li>
        </ul>
        {{--  Left Align End  --}}
        {{--  Right Align Begin  --}}
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    <i class="fas fa-user-circle fa-lg"></i>  {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                    <li><a class="dropdown-item" href="{{route('user.profile')}}"><i class="fas fa-user-cog"></i> Minha Conta</a></li>
                    <div class="dropdown-divider"></div>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            <i class="fas fa-power-off"></i> Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
        {{--  Right Align End  --}}
        @endauth
    </div>
</nav>
{{--  @component('layouts.session_messages')
@endcomponent  --}}