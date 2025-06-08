@extends('layouts.relatorios')

@section('relatorio')
<div class="container-fluid py-4">
    <!-- Cabeçalho da OS -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Ordem de Serviço #{{ $ordemServico->id }}</h5>
        </div>
        <div class="card-body row">
            <div class="col-md-3">
                <label class="font-weight-bold">Status:</label>
                <div>{{ $ordemServico->ordem_servico_status->os_status ?? 'Aberta' }}</div>
            </div>
            <div class="col-md-3">
                <label class="font-weight-bold">Data Abertura:</label>
                <div>{{ date_format(date_create($ordemServico->created_at), 'd/m/Y - H:i:s') }}</div>
            </div>
            <div class="col-md-3">
                <label class="font-weight-bold">Data Fechamento:</label>
                <div>
                    {{ $ordemServico->fechada ? date_format(date_create($ordemServico->data_fechamento), 'd/m/Y - H:i:s') : '---' }}
                </div>
            </div>
            <div class="col-md-3">
                <label class="font-weight-bold">Odômetro / Horímetro:</label>
                <div>{{ $ordemServico->km_veiculo }}</div>
            </div>
        </div>
    </div>

    <!-- Cliente e Veículo -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <label class="font-weight-bold">Cliente:</label>
                    <div>{{ $ordemServico->cliente_id ?? '' }} - {{ $ordemServico->cliente->nome_razao }}</div>
                    <label class="font-weight-bold mt-2">CPF / CNPJ:</label>
                    <div>{{ $ordemServico->cliente->cpf_cnpj ?? '' }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <label class="font-weight-bold">Departamento:</label>
                    <div>{{ $ordemServico->veiculo->departamento->departamento ?? 'Não Informado' }}</div>
                    <label class="font-weight-bold mt-2">Veículo:</label>
                    <div>{{ $ordemServico->veiculo->placa ?? 'Não Informado' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Serviços -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            <strong>SERVIÇOS</strong>
        </div>
        <div class="card-body p-0">
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
                        <td>{{ $servico->valor_servico }}</td>
                        <td>{{ $servico->valor_acrescimo }}</td>
                        <td>{{ $servico->valor_desconto }}</td>
                        <td>{{ $servico->valor_cobrado }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Produtos -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            <strong>PRODUTOS</strong>
        </div>
        <div class="card-body p-0">
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
                        <td>{{ $item->valor_produto }}</td>
                        <td>{{ $item->valor_acrescimo }}</td>
                        <td>{{ $item->valor_desconto }}</td>
                        <td>{{ $item->valor_cobrado }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Totais e Observações -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <label class="font-weight-bold">Problema Relatado:</label>
                    <div>{!! $ordemServico->defeito ?? '&nbsp;' !!}</div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <label class="font-weight-bold">Atividades Realizadas:</label>
                    <div>{!! $ordemServico->obs ?? '&nbsp;' !!}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-right">
            <div class="card">
                <div class="card-body">
                    <label class="font-weight-bold">Valor Total:</label>
                    <div class="h5">{{ $ordemServico->valor_total }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assinaturas -->
    <div class="row text-center mt-5">
        <div class="col-md-5">
            <hr>
            <strong>{{ $ordemServico->user->name ?? 'Usuário não informado' }}</strong>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-5">
            <hr>
            <strong>{{ $ordemServico->cliente->nome_razao ?? '' }}</strong>
        </div>
    </div>
</div>
@endsection
