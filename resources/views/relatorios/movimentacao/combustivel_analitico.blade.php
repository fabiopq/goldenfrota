@extends('layouts.relatorios')

@section('relatorio')
@php
    $totalEntradasGeral = 0;
    $totalSaidasGeral = 0;
@endphp

{{-- Entradas --}}
<h4 class="mt-4"><i class="fas fa-sign-in-alt text-success"></i> Entradas</h4>

@foreach($entradasAgrupadas as $tipo => $movs)
    @php $totalTipo = 0; @endphp

    <h5 class="mt-3">Tipo de Movimentação: <strong>{{ $tipo }}</strong></h5>
    <table class="table table-sm table-bordered table-striped report-table">
        <thead class="thead-dark">
            <tr>
                <th>Data</th>
                <th>Tanque</th>
                <th>Combustível</th>
                <th class="text-right">Quantidade (Litros)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movs as $mov)
                @php $totalTipo += $mov->quantidade; @endphp
                <tr>
                    <td>{{ date('d/m/Y H:i:s', strtotime($mov->created_at)) }}</td>
                    <td>{{ $mov->tanque }}</td>
                    <td>{{ $mov->combustivel }}</td>
                    <td class="text-right">{{ number_format($mov->quantidade, 3, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="font-weight-bold table-primary">
                <td colspan="3" class="text-right">Total do Tipo "{{ $tipo }}"</td>
                <td class="text-right">{{ number_format($totalTipo, 3, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    @php $totalEntradasGeral += $totalTipo; @endphp
@endforeach

<h5 class="mt-4 text-success"><strong>Total Geral de Entradas:</strong> {{ number_format($totalEntradasGeral, 3, ',', '.') }} litros</h5>

<hr class="my-5">

{{-- Saídas --}}
<h4 class="mt-4"><i class="fas fa-sign-out-alt text-danger"></i> Saídas</h4>

@foreach($saidasAgrupadas as $tipo => $movs)
    @php $totalTipo = 0; @endphp

    <h5 class="mt-3">Tipo de Movimentação: <strong>{{ $tipo }}</strong></h5>
    <table class="table table-sm table-bordered table-striped report-table">
        <thead class="thead-dark">
            <tr>
                <th>Data</th>
                <th>Tanque</th>
                <th>Combustível</th>
                <th class="text-right">Quantidade (Litros)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movs as $mov)
                @php $totalTipo += $mov->quantidade; @endphp
                <tr>
                    <td>{{ date('d/m/Y H:i:s', strtotime($mov->created_at)) }}</td>
                    <td>{{ $mov->tanque }}</td>
                    <td>{{ $mov->combustivel }}</td>
                    <td class="text-right">{{ number_format($mov->quantidade, 3, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="font-weight-bold table-danger">
                <td colspan="3" class="text-right">Total do Tipo "{{ $tipo }}"</td>
                <td class="text-right">{{ number_format($totalTipo, 3, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    @php $totalSaidasGeral += $totalTipo; @endphp
@endforeach

<h5 class="mt-4 text-danger"><strong>Total Geral de Saídas:</strong> {{ number_format($totalSaidasGeral, 3, ',', '.') }} litros</h5>

<hr class="my-5">

{{-- Saldo Final --}}
<h4>
    <i class="fas fa-balance-scale text-primary"></i> 
    <strong>Saldo Final:</strong> 
    <span class="{{ ($totalEntradasGeral - $totalSaidasGeral) >= 0 ? 'text-success' : 'text-danger' }}">
        {{ number_format($totalEntradasGeral - $totalSaidasGeral, 3, ',', '.') }} litros
    </span>
</h4>

@endsection
