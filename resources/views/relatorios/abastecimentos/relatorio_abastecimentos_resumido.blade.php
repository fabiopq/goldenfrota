@extends('layouts.relatorios')

@section('relatorio')
    @php
        $clienteVolume = 0;
        $clienteValor = 0;
        $clienteDistancia = 0;
        $departamentoVolume = 0;
        $departamentoValor = 0;
        $departamentoDistancia = 0;
        $distanciaTotal = 0;
        $volumeTotal = 0;
        $valorTotal = 0;
    @endphp
    {{-- {{dd($clientes)}} --}}
    <div class="panel-sm">
        <div class="panel-sm">

            <div class="card-body">

                <div class="panel-sm">

                    <div class="card-body">
                        <table class="table table-sm report-table">
                            <thead>
                                <td width="20%">Cliente</td>
                                <td align="right" width="20%">Consumo Litros</td>
                                <td align="right" width="20%">Limite R$</td>
                                <td align="right" width="20%">Consumo R$</td>
                                <td align="right" width="20%">Saldo R$</td>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($clientes as $cliente)
        @php

            $clienteVolume = 0;
            $clienteValor = 0;
            $departamentoVolume = 0;
            $departamentoValor = 0;

            $clienteDistancia = 0;
        @endphp

        <div class="panel-sm">
            <div class="panel-sm">

                <div class="card-body">

                    <div class="panel-sm">

                        <div class="card-body">
                            <table class="table table-sm report-table">

                                <tbody>
                                    @foreach ($cliente->abastecimentos as $abastecimento)
                                        @php
                                            $clienteVolume += $abastecimento->consumo;
                                            $clienteValor += $abastecimento->valor;
                                            $clienteDistancia += $abastecimento->km_final - $abastecimento->km_inicial;
                                            $departamentoVolume += $abastecimento->consumo;
                                            $departamentoValor += $abastecimento->valor;
                                            $departamentoDistancia +=
                                                $abastecimento->km_final - $abastecimento->km_inicial;
                                            $distanciaTotal += $abastecimento->km_final - $abastecimento->km_inicial;

                                            if ($cliente->ativo) {
                                                $volumeTotal += $abastecimento->consumo;
                                                $valorTotal += $abastecimento->valor;
                                            }
                                        @endphp
                                        <tr>
                                            <td width="20%"> {{ $abastecimento->nome_razao }} </td>
                                            <td align="right" width="20%">
                                                {{ number_format($abastecimento->consumo, 2, ',', '.') }} </td>
                                            <td align="right" width="20%">
                                                {{ number_format($abastecimento->limite, 2, ',', '.') }} </td>
                                            <td align="right" width="20%">
                                                {{ number_format($abastecimento->valor, 2, ',', '.') }} </td>
                                            <td align="right" width="20%">
                                                {{ number_format($abastecimento->limite - $abastecimento->valor, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach



    @foreach ($clientesNullo as $cliente)
        @php

            $clienteVolume = 0;
            $clienteDistancia = 0;
        @endphp
        <div class="panel-sm">
            <div class="panel-sm">
                <div class="card-header report-subtitle-1">
                    <h4> Cliente: Não Informado </h4>
                </div>
                <div class="card-body">
                    @php

                        $departamentoDistancia = 0;
                        $departamentoVolume = 0;

                    @endphp


                    @foreach ($clientesNullo as $clienteItem)
                        @php
                            $clienteVolume += $clienteItem->consumo;
                            $clienteDistancia += $clienteItem->km_final - $clienteItem->km_inicial;
                            $departamentoVolume += $clienteItem->consumo;
                            $departamentoDistancia += $clienteItem->km_final - $clienteItem->km_inicial;
                            $distanciaTotal += $clienteItem->km_final - $clienteItem->km_inicial;
                            $volumeTotal += $clienteItem->consumo;
                            $valorTotal += $clienteItem->valor;
                        @endphp
                        <div class="panel-sm">
                            <div class="card-header report-subtitle-1">
                                <h5>Departamento: Departamento Não Informado </h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm report-table">
                                    <thead>
                                        <td width="50%">Cliente</td>
                                        <td align="right" width="25%">Consumo Litros</td>
                                        <td align="right" width="25%">Consumo R$</td>
                                    </thead>
                                    <tbody>


                                        <tr>
                                            <td width="50%"> Placa Não Informada </td>
                                            <td align="right" width="25%">
                                                {{ number_format($abastecimento->consumo, 2, ',', '.') }} </td>
                                            <td align="right" width="25%">
                                                {{ number_format($abastecimento->valor, 2, ',', '.') }} </td>

                                        </tr>
                    @endforeach
                    <tr class="success">
                        <td width="50%">Total Placa Não Informada</td>

                        <td align="right" width="25%">{{ number_format($departamentoDistancia, 1, ',', '.') }} </td>

                        <td align="right" width="25%">{{ number_format($departamentoVolume, 3, ',', '.') }}</td>

                    </tr>

                    </tbody>
                    </table>
                </div>
            </div>


        </div>
        </div>
        </div>
    @endforeach
    <table class="table table-sm report-table">
        <tbody>
            <tr class="default">
                <td>
                    <h5>Total Geral</h5>
                </td>
                <td align="right">
                    <h5></h5>
                </td>
                <td align="right">
                    <h5>Consumo Litros: {{ number_format($volumeTotal, 3, ',', '.') }}</h5>
                </td>
                <td align="right">
                    <h5>Consumo Total: {{ number_format($valorTotal, 3, ',', '.') }}</h5>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
