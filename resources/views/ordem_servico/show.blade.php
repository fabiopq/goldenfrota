@extends('layouts.relatorios')



@section('relatorio')
    <div class="container-fluid m-b-10">
        <div class="row">
            <div class="col col-sm-12 col-md-12 col-lg-12">
                <div class="card nf-panel">
                    <div class="card-body">
                        <div class="float-left mr-auto">
                            <label for="#numero" class="nf-label">Número:</label>
                            <div id="numero">{{ $ordemServico->id }}</div>
                        </div>
                        <div class="float-right" style="margin-left: 25px">
                            <label for="#os_fechada" class="nf-label">status:</label>
                            <div id="os_fechada">{{ $ordemServico->ordem_servico_status->os_status ?? 'Aberta' }}</div>
                        </div>
                        <div class="float-right" style="margin-left: 25px">
                            <label for="#data_os" class="nf-label">Data Fechamento:</label>
                            <div id="data_fechamento_os">
                                {{ $ordemServico->fechada ? date_format(date_create($ordemServico->data_fechamento), 'd/m/Y - H:i:s') : '___/___/______ - ___:___:___   ' }}
                            </div>
                        </div>
                        <div class="float-right" style="margin-left: 25px">
                            <label for="#data_os" class="nf-label">Data Abertura:</label>
                            <div id="data_os">{{ date_format(date_create($ordemServico->created_at), 'd/m/Y - H:i:s') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col col-sm-6 col-md-6 col-lg-6">
                <div class="card nf-panel">
                    <label for="#cliente" class="nf-label">Cliente:</label>
                    <div id="cliente">{{ isset($ordemServico->cliente_id) ? $ordemServico->cliente_id : '' }} -
                        {{ $ordemServico->cliente->nome_razao }}</div>
                </div>
            </div>
            <div class="col col-sm-6 col-md-6 col-lg-6">
                <div class="card nf-panel">
                    <label for="#cliente" class="nf-label">Cpf / Cnpj:</label>
                    <div id="cliente">
                        {{ isset($ordemServico->cliente->cpf_cnpj) ? $ordemServico->cliente->cpf_cnpj : '' }}
                    </div>
                </div>
            </div>

        </div>
        <div class="row">

            <div class="col col-sm-5 col-md-5 col-lg-5">
                <div class="card nf-panel">
                    <label for="#departamento" class="nf-label">Departamento:</label>
                    <div id="departamento">
                        {{ isset($ordemServico->veiculo->departamento) ? $ordemServico->veiculo->departamento->departamento : 'Não Informado ' }}
                    </div>
                </div>
            </div>
            <div class="col col-sm-4 col-md-4 col-lg-4">
                <div class="card nf-panel">
                    <label for="#veiculo" class="nf-label">Veículo:</label>
                    <div id="veiculo">
                        {{ isset($ordemServico->veiculo->placa) ? $ordemServico->veiculo->placa : 'Não Informado' }}
                    </div>
                </div>
            </div>
            <div class="col col-sm-3 col-md-3 col-lg-3">
                <div class="card nf-panel">
                    <label for="#km_atual" class="nf-label">Odômetro / Horímetro:</label>
                    <div id="km_atual">{{ $ordemServico->km_veiculo }}</div>
                </div>
            </div>


        </div>

        <!-- Serviços -->
        @if ($ordemServico->servicos->isNotEmpty())
            <div class="row g-0">
                <div class="col-12 p-0">
                    <div class="card m-0 border-0">
                        <div class="card-header bg-secondary text-white p-2">
                            <strong>SERVIÇOS</strong>
                        </div>
                        <div class="card-body p-1">
                            <table class="table table-bordered table-sm mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Serviço</th>
                                        <th>Valor</th>
                                        <th>Acréscimo</th>
                                        <th>Desconto</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ordemServico->servicos as $servico)
                                        <tr>
                                            <td>{{ $servico->servico_id }}</td>
                                            <td>{{ $servico->servico->servico }}</td>
                                            <td>{{ number_format($servico->valor_servico, 2, ',', '.') }}</td>
                                            <td>{{ number_format($servico->valor_acrescimo, 2, ',', '.') }}</td>
                                            <td>{{ number_format($servico->valor_desconto, 2, ',', '.') }}</td>
                                            <td>{{ number_format($servico->valor_cobrado, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Produtos -->
        @if ($ordemServico->produtos->isNotEmpty())
            <div class="row g-0 mt-2">
                <div class="col-12 p-0">
                    <div class="card m-0 border-0">
                        <div class="card-header bg-secondary text-white p-2">
                            <strong>PRODUTOS</strong>
                        </div>
                        <div class="card-body p-1">
                            <table class="table table-bordered table-sm mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Produto</th>
                                        <th>Qtd</th>
                                        <th>Vlr. Un.</th>
                                        <th>Acréscimo</th>
                                        <th>Desconto</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ordemServico->produtos as $item)
                                        <tr>
                                            <td>{{ $item->produto_id }}</td>
                                            <td>{{ $item->produto->produto_descricao }}</td>
                                            <td>{{ $item->quantidade }}</td>
                                            <td>{{ number_format($item->valor_produto, 2, ',', '.') }}</td>
                                            <td>{{ number_format($item->valor_acrescimo, 2, ',', '.') }}</td>
                                            <td>{{ number_format($item->valor_desconto, 2, ',', '.') }}</td>
                                            <td>{{ number_format($item->valor_cobrado, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{--  
        @foreach ($ordemServico->produtos as $item)
            <div class="row">
                <div class="col col-sm-1 col-md-1 col-lg-1">
                    <div class="card nf-panel">
                        <div>{{ $item->produto_id }}</div>
                    </div>
                </div>
                <div class="col col-sm-6 col-md-6 col-lg-6">
                    <div class="card nf-panel">
                        <div>{{ $item->produto->produto_descricao }}</div>
                    </div>
                </div>
                <div class="col col-sm-1 col-md-1 col-lg-1">
                    <div class="card nf-panel">
                        <div>{{ $item->quantidade }}</div>
                    </div>
                </div>
                <div class="col col-sm-1 col-md-1 col-lg-1">
                    <div class="card nf-panel">
                        <div>{{ $item->valor_produto }}</div>
                    </div>
                </div>
                <div class="col col-sm-1 col-md-1 col-lg-1">
                    <div class="card nf-panel">
                        <div>{{ $item->valor_acrescimo }}</div>
                    </div>
                </div>
                <div class="col col-sm-1 col-md-1 col-lg-1">
                    <div class="card nf-panel">
                        <div>{{ $item->valor_desconto }}</div>
                    </div>
                </div>
                <div class="col col-sm-1 col-md-1 col-lg-1">
                    <div class="card nf-panel">
                        <div>{{ $item->valor_cobrado }}</div>
                    </div>
                </div>
            </div>
        @endforeach
        --}}

        {{--  <div class="row">
            <div class="col col-sm-10 col-md-10 col-lg-10">

            </div>
            <div class="col col-sm-2 col-md-2 col-lg-2">
                <div class="card nf-panel clearfix">
                    <div class="pull-right">
                        <label for="#data_os" class="nf-label">Valor Total:</label>
                        <div id="data_os">{{ $ordemServico->valor_total }}</div>
                    </div>
                </div>
            </div>
        </div>
        --}}
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex justify-content-end">
                    <div class="card nf-panel border border-dark bg-light" style="min-width: 300px;">
                        <div class="card-body text-end p-3">
                            <div class="text-end">
                                <label class="nf-label d-block mb-1"><strong>Valor Total:</strong></label>
                                <div class="fs-3 fw-bold">
                                    R$ {{ number_format($ordemServico->valor_total, 2, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="row">
            <div class="col col-sm-12 col-md-12 col-lg-12">
                <div class="card nf-panel">
                    <label for="#obs" class="nf-label"><strong>Problema Relatado:</strong> </label>
                    <div id="obs">{!! $ordemServico->obs ? $ordemServico->defeito : '&nbsp;' !!}</div>
                </div>

                <div class="card nf-panel">
                    <label for="#obs" class="nf-label"><strong>Atividades Realizadas:</strong></label>
                    <div id="obs">{!! $ordemServico->obs ? $ordemServico->obs : '&nbsp;' !!}</div>
                </div>
            </div>
        </div>
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <div class="container-fluid m-b-10">
            <div class="row" align="center">
                <div class="col col-sm-1 col-md-1 col-lg-1">
                </div>
                <div class="col col-sm-4 col-md-4 col-lg-4">
                    <div style="border-bottom: 1px solid"> </div>
                </div>
                <div class="col col-sm-2 col-md-2 col-lg-2">
                </div>
                <div class="col col-sm-4 col-md-4 col-lg-4">
                    <div style="border-bottom: 1px solid"> </div>
                </div>
                <div class="col col-sm-1 col-md-1 col-lg-1">
                </div>
                <div class="col col-sm-1 col-md-1 col-lg-1">
                </div>
                <div class="col col-sm-4 col-md-4 col-lg-4" align="center">
                    <strong>{{ $ordemServico->user->name ?? 'Usuário não informado' }}</strong>
                </div>
                <div class="col col-sm-2 col-md-2 col-lg-2">
                </div>
                <div class="col col-sm-4 col-md-4 col-lg-4" align="center">
                    <strong>{{ isset($ordemServico->cliente->nome_razao) ? $ordemServico->cliente->nome_razao : '' }}</strong>
                </div>
            </div>
        </div>
    </div>
@endsection
