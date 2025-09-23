@extends('layouts.relatorios')

@section('relatorio')

    @forelse($clientes as $cliente)
        {{-- 
            CORREÇÃO APLICADA AQUI:
            A sintaxe 'fn($d) => ...' foi trocada por 'function($d) { ... }'
            para garantir a compatibilidade com versões do PHP anteriores à 7.4.
        --}}
        @if (
            $cliente->departamentos->contains(function ($d) {
                return $d->veiculos->isNotEmpty();
            }) || $cliente->veiculos->isNotEmpty())
            <div class="panel panel-default mb-4" style="page-break-inside: avoid;">
                <div class="card-header report-subtitle-1">
                    <h4>Cliente: {{ $cliente->nome_razao }}</h4>
                </div>
                <div class="card-body">

                    {{-- 1. LISTA DE VEÍCULOS ASSOCIADOS A DEPARTAMENTOS --}}
                    @foreach ($cliente->departamentos as $departamento)
                        @if ($departamento->veiculos->isNotEmpty())
                            <div class="panel panel-default mb-3">
                                <div class="card-header">
                                    <h5>Departamento: {{ $departamento->departamento }}</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm report-table">
                                        <thead>
                                            <th>Código</th>
                                            <th class="text-left">Placa</th>
                                            <th class="text-left">Modelo</th>
                                            <th class="text-left">Marca</th>
                                            <th class="text-left">Ano</th>
                                            <th class="text-left">Média Mínima</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($departamento->veiculos as $veiculo)
                                                <tr>
                                                    <td>{{ $veiculo->id }}</td>
                                                    <td class="text-left">{{ $veiculo->placa }}</td>
                                                    <td class="text-left">{{ $veiculo->modelo_veiculo->modelo_veiculo ?? 'N/A' }}
                                                    </td>
                                                    <td class="text-left">
                                                        {{ $veiculo->modelo_veiculo->marca_veiculo->marca_veiculo ?? 'N/A' }}</td>
                                                    <td class="text-left">{{ $veiculo->ano }}</td>
                                                    <td class="text-left">
                                                        {{ number_format($veiculo->media_minima, 2, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                            <tr class="font-weight-bold table-success">
                                                <td colspan="5">Total de Veículos no Departamento:</td>
                                                <td class="text-left">{{ $departamento->veiculos->count() }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    {{-- 2. LISTA DE VEÍCULOS SEM DEPARTAMENTO ASSOCIADO --}}
                    @if ($cliente->veiculos->isNotEmpty())
                        <div class="panel panel-default mb-3">
                            <div class="card-header">
                                <h5>Departamento: (Não especificado)</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm report-table">
                                    <thead>
                                        <th>Código</th>
                                        <th class="text-left">Placa</th>
                                        <th class="text-left">Modelo</th>
                                        <th class="text-left">Marca</th>
                                        <th class="text-left">Ano</th>
                                        <th class="text-left">Média Mínima</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($cliente->veiculos as $veiculo)
                                            <tr>
                                                <td>{{ $veiculo->id }}</td>
                                                <td class="text-left">{{ $veiculo->placa }}</td>
                                                <td class="text-left">{{ $veiculo->modelo_veiculo->modelo_veiculo ?? 'N/A' }}</td>
                                                <td class="text-left">{{ $veiculo->modelo_veiculo->marca_veiculo->marca_veiculo ?? 'N/A' }}
                                                </td>
                                                <td class="text-left">{{ $veiculo->ano }}</td>
                                                <td class="text-left">
                                                    {{ number_format($veiculo->media_minima, 2, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="font-weight-bold table-success">
                                            <td colspan="5">Total de Veículos sem Departamento:</td>
                                            <td class="text-left">{{ $cliente->veiculos->count() }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        @endif
    @empty
        <div class="alert alert-info text-center">
            Nenhum dado encontrado para os filtros selecionados.
        </div>
    @endforelse

@endsection
