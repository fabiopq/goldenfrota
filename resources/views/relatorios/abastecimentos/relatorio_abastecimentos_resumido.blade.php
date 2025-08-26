@extends('layouts.relatorios')

@section('relatorio')
    @php
        // Variáveis para o total geral do relatório, inicializadas antes do loop
        $volumeTotalGeral = 0;
        $valorTotalGeral = 0;
    @endphp

    {{-- Loop principal para cada CLIENTE recebido do controller --}}
    @foreach ($clientes as $cliente)
        {{-- Apenas exibe o cliente se ele tiver departamentos com abastecimentos no período --}}
        @if ($cliente->departamentos->isNotEmpty())
            <div class="panel-sm mt-3">
                {{-- Cabeçalho com as informações do Cliente --}}
                <div class="card-header report-subtitle-1">
                    <h4>Cliente: {{ $cliente->id }} - {{ $cliente->nome_razao }}</h4>
                </div>

                {{-- Corpo do card contendo a tabela completa para este cliente --}}
                <div class="card-body">
                    <table class="table table-sm report-table" style="table-layout: fixed; width: 100%;">
                        
                        <thead style="font-weight: bold;">
                            <tr>
                                <th style="width: 50%;">Departamento</th>
                                
                                {{-- ALTERAÇÃO APLICADA AQUI: Trocado 'align' por 'style="text-align: right;"' --}}
                                <th style="width: 25%; text-align: right;">Consumo (Litros)</th>
                                <th style="width: 25%; text-align: right;">Consumo (R$)</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- Loop interno para cada DEPARTAMENTO do cliente --}}
                            @foreach ($cliente->departamentos as $departamento)
                                <tr>
                                    <td style="width: 50%;">{{ $departamento->departamento }}</td>

                                    {{-- ALTERAÇÃO APLICADA AQUI: Trocado 'align' por 'style="text-align: right;"' --}}
                                    <td style="width: 25%; text-align: right;">{{ number_format($departamento->consumo, 2, ',', '.') }}</td>
                                    <td style="width: 25%; text-align: right;">{{ number_format($departamento->valor, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            @php
                                $clienteVolumeTotal = $cliente->departamentos->sum('consumo');
                                $clienteValorTotal = $cliente->departamentos->sum('valor');
                                $volumeTotalGeral += $clienteVolumeTotal;
                                $valorTotalGeral += $clienteValorTotal;
                            @endphp
                            <tr class="success" style="font-weight: bold;">
                                <td style="width: 50%;">Total do Cliente:</td>
                                
                                {{-- ALTERAÇÃO APLICADA AQUI: Trocado 'align' por 'style="text-align: right;"' --}}
                                <td style="width: 25%; text-align: right;">{{ number_format($clienteVolumeTotal, 2, ',', '.') }}</td>
                                <td style="width: 25%; text-align: right;">{{ number_format($clienteValorTotal, 2, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @endif
    @endforeach

    {{-- Tabela final com o TOTAL GERAL de todos os clientes exibidos --}}
    <div class="panel-sm mt-4">
        <table class="table table-sm report-table">
            <tbody>
                <tr class="default" style="font-weight: bold; font-size: 1.1em;">
                    <td><h5>Total Geral</h5></td>
                    <td align="right"><h5>Consumo Litros: {{ number_format($volumeTotalGeral, 2, ',', '.') }}</h5></td>
                    <td align="right"><h5>Consumo Total: {{ number_format($valorTotalGeral, 2, ',', '.') }}</h5></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection