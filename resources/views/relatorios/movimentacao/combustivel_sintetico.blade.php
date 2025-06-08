@extends('layouts.relatorios')

@section('relatorio')

    <br>

    <h4 class="mt-4"><i class="fas fa-sign-in-alt text-success"></i> Entradas</h4>
    <table class="table table-sm table-bordered table-striped report-table">
        <thead class="thead-dark">
            <tr>
                <th>Tipo de Movimentação</th>
                <th class="text-right">Quantidade Total</th>
            </tr>
        </thead>
        <tbody>
            @php $totalEntradas = 0; @endphp
            @foreach ($movimentacoesEntrada as $entrada)
                @php $totalEntradas += $entrada->total_quantidade; @endphp
                <tr>
                    <td>{{ $entrada->tipo_movimentacao_combustivel }}</td>
                    <td class="text-right">{{ number_format($entrada->total_quantidade, 3, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="table-primary font-weight-bold">
                <td><strong>Total de Entradas</strong></td>
                <td class="text-right"><strong>{{ number_format($totalEntradas, 3, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <h4 class="mt-5"><i class="fas fa-sign-out-alt text-danger"></i> Saídas</h4>
    <table class="table table-sm table-bordered table-striped report-table">
        <thead class="thead-dark">
            <tr>
                <th>Tipo de Movimentação</th>
                <th class="text-right">Quantidade Total</th>
            </tr>
        </thead>
        <tbody>
            @php $totalSaidas = 0; @endphp
            @foreach ($movimentacoesSaida as $saida)
                @php $totalSaidas += $saida->total_quantidade; @endphp
                <tr>
                    <td>{{ $saida->tipo_movimentacao_combustivel }}</td>
                    <td class="text-right">{{ number_format($saida->total_quantidade, 3, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="table-danger font-weight-bold">
                <td><strong>Total de Saídas</strong></td>
                <td class="text-right"><strong>{{ number_format($totalSaidas, 3, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <hr class="my-5">

    <h4><i class="fas fa-chart-pie text-primary"></i> Resumo Geral</h4>
    <table class="table table-sm table-bordered report-table">
        <tr>
            <td><strong>Volume Total de Entradas</strong></td>
            <td class="text-right text-success">{{ number_format($totalEntradas, 3, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Volume Total de Saídas</strong></td>
            <td class="text-right text-danger">{{ number_format($totalSaidas, 3, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Saldo</strong></td>
            <td class="text-right font-weight-bold {{ ($totalEntradas - $totalSaidas) >= 0 ? 'text-success' : 'text-danger' }}">
                {{ number_format($totalEntradas - $totalSaidas, 3, ',', '.') }}
            </td>
        </tr>
    </table>

@endsection
