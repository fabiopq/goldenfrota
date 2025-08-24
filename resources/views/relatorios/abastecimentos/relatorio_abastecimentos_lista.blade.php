@extends('layouts.relatorios')

@section('relatorio')
    <table class="table table-sm report-table">
        <thead>
            <tr>
                <th>Placa</th>
                <th>Data</th>
                <th>Departamento</th>
                <th align="right">Volume</th>
                <th align="right">Valor Litro</th>
                <th align="right">Valor Abastecimento</th>
            </tr>
        </thead>
        <tbody>
            @php
            //dd($clientes);
                $valorTotal = 0;
                $volumeTotal = 0;
            @endphp

            {{-- Loop para clientes que possuem abastecimentos --}}
            @foreach ($clientes as $cliente)
                @foreach ($cliente->abastecimentos as $abastecimento)
                    @php
                        $valorTotal += $abastecimento->valor_abastecimento;
                        $volumeTotal += $abastecimento->volume_abastecimento;
                    @endphp
                    <tr>
                        <td>{{ $abastecimento->placa }}</td>
                        <td>{{ date_format(date_create($abastecimento->data_hora_abastecimento), 'd/m/Y H:i:s') }}</td>
                        <td>{{ $abastecimento->departamento_nome ?? 'Não Informado' }}</td>
                        <td align="right">{{ number_format($abastecimento->volume_abastecimento, 3, ',', '.') }}</td>
                        <td align="right">{{ number_format($abastecimento->valor_litro, 3, ',', '.') }}</td>
                        <td align="right">{{ number_format($abastecimento->valor_abastecimento, 3, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach

            {{-- Loop para abastecimentos de clientes nulos --}}
            @if (is_null($clientesNulloAnalitico) == false)
                @foreach ($clientesNulloAnalitico as $abastecimento)
                    @php
                        $valorTotal += $abastecimento->valor_abastecimento;
                        $volumeTotal += $abastecimento->volume_abastecimento;
                    @endphp
                    <tr>
                        <td>Não Informada</td>
                        <td>{{ date_format(date_create($abastecimento->data_hora_abastecimento), 'd/m/Y H:i:s') }}</td>
                        <td>{{ $abastecimento->departamento ?? 'Não Informado' }}</td>
                        <td align="right">{{ number_format($abastecimento->volume_abastecimento, 3, ',', '.') }}</td>
                        <td align="right">{{ number_format($abastecimento->valor_litro, 3, ',', '.') }}</td>
                        <td align="right">{{ number_format($abastecimento->valor_abastecimento, 3, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <hr>

    <table class="table table-sm report-table">
        <tbody>
            <tr class="default">
                <td>
                    <h5>Total Geral</h5>
                </td>
                <td align="right">
                    <h5>Volume Abastecido: {{ number_format($volumeTotal, 3, ',', '.') }}</h5>
                </td>
                <td align="right">
                    <h5>Valor Total: {{ number_format($valorTotal, 3, ',', '.') }}</h5>
                </td>
            </tr>
        </tbody>
    </table>
@endsection