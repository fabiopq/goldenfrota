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
                <div class="card-header report-subtitle-1">
                    <h5> Cliente: {{ $cliente->nome_razao }} </h5>
                </div>
                <div class="card-body">

                    <div class="panel-sm">

                        <div class="card-body">
                            <table class="table table-sm report-table" id="relatorio-tabela">
                                <thead>
                                    <td>Placa</td>
                                    <td>Veículo</td>
                                    <td align="right">KM Inicial</td>
                                    <td align="right">KM Final</td>
                                    <td align="right">Distância Percorrida</td>
                                    <td align="right">Consumo Médio/KM</td>
                                    <td align="right">Consumo Litros</td>
                                    <td align="right">Consumo R$</td>
                                </thead>
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
                                              if ($cliente->ativo) {
                                                $volumeTotal += $abastecimento->consumo;
                                                $valorTotal += $abastecimento->valor;
                                                $distanciaTotal += $abastecimento->km_final - $abastecimento->km_inicial;
                                       
                                            }

                                        @endphp
                                        <tr>
                                            <td> {{ $abastecimento->placa }} </td>
                                            <td> {{ $abastecimento->modelo_veiculo }} </td>
                                            <td align="right"> {{ number_format($abastecimento->km_inicial, 1, ',', '.') }}
                                            </td>
                                            <td align="right"> {{ number_format($abastecimento->km_final, 1, ',', '.') }}
                                            </td>
                                            <td align="right">
                                                {{ number_format($abastecimento->km_final - $abastecimento->km_inicial, 1, ',', '.') }}
                                            </td>
                                            <td align="right"> {{ number_format($abastecimento->media, 2, ',', '.') }}
                                            </td>
                                            <td align="right"> {{ number_format($abastecimento->consumo, 2, ',', '.') }}
                                            </td>
                                            <td align="right"> {{ number_format($abastecimento->valor, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="success">
                                        <td colspan=2>Total do Cliente</td>
                                        <td align="right"></td>
                                        <td align="right"> </td>
                                        <td align="right">{{ number_format($departamentoDistancia, 1, ',', '.') }} </td>
                                        <td align="right"> </td>

                                        <td align="right">{{ number_format($departamentoVolume, 3, ',', '.') }}</td>
                                        <td align="right">{{ number_format($departamentoValor, 3, ',', '.') }}</td>
                                    </tr>
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
                                        <td>Veículo</td>
                                        <td align="right">KM Inicial</td>
                                        <td align="right">KM Final</td>
                                        <td align="right">Distância Percorrida</td>
                                        <td align="right">Consumo Médio/KM</td>
                                        <td align="right">Consumo Litros</td>
                                        <td align="right">Consumo Total</td>
                                    </thead>
                                    <tbody>


                                        <tr>
                                            <td> Placa Não Informada </td>
                                            <td align="right"> &nbsp</td>
                                            <td align="right"> &nbsp</td>
                                            <td align="right"> &nbsp</td>
                                            <td align="right"> &nbsp</td>
                                            <td align="right">{{ number_format($clienteItem->consumo, 2, ',', '.') }}</td>
                                            <td align="right">{{ number_format($clienteItem->valor, 2, ',', '.') }}</td>
                                        </tr>
                    @endforeach
                    <tr class="success">
                        <td colspan=2>Total do Departamento</td>
                        <td align="right"></td>
                        <td align="right">{{ number_format($departamentoDistancia, 1, ',', '.') }} </td>
                        <td align="right"> </td>
                        <td align="right">{{ number_format($departamentoVolume, 3, ',', '.') }}</td>

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
                    <h5>Distância Percorrida: {{ number_format($distanciaTotal, 1, ',', '.') }}</h5>
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
