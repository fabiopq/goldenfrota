@extends('layouts.relatorios')

@section('relatorio')
@php
    $clienteVolume = 0;
    $clienteDistancia = 0;
    $departamentoVolume = 0;
    $departamentoDistancia = 0;
    $distanciaTotal = 0;
    $modeloVolumeTotal = 0;
    $volumeTotal = 0;
    
@endphp
{{--  {{dd($clientes)}}  --}}

<div class="panel-sm">
    <div class="panel-sm">
  
        <div class="card-body">
            @foreach($modeloVeiculos as $modeloVeiculo)
            @php
                $modeloVolume = 0;
                $modeloDistancia = 0; 
                //dd($modeloVeiculos);    
            @endphp
            <div class="panel-sm">
                <div class="card-header report-subtitle-1">
                    <h5>Modelo: {{$modeloVeiculo->modelo_veiculo}}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm report-table">
                        <thead>
                            <td>Veículo</td>
                            <td align="right">KM Inicial</td>
                            <td align="right">KM Final</td>
                            <td align="right">Distância Percorrida</td>
                            <td align="right">Consumo Lts</td>
                            <td align="right">Média KM/L</td>
                        </thead>
                        <tbody>
                            @foreach($modeloVeiculo->abastecimentos as $abastecimento)
                            @php
                               $modeloVolumeTotal = 0;
                               // $clienteVolume += $abastecimento->consumo;
                               // $clienteDistancia += $abastecimento->km_final - $abastecimento->km_inicial;
                               $modeloVolume += $abastecimento->consumo; 
                               $modeloDistancia += $abastecimento->km_final - $abastecimento->km_inicial;  
                               $distanciaTotal += $abastecimento->km_final - $abastecimento->km_inicial;  
                               $volumeTotal += $abastecimento->consumo;
                            @endphp
                            <tr> 
                                <td> {{$abastecimento->placa}} </td>
                                
                                <td align="right"> {{number_format($abastecimento->km_inicial, 1, ',', '.')}} </td>
                                <td align="right"> {{number_format($abastecimento->km_final, 1, ',', '.')}} </td>
                                <td align="right"> {{number_format($abastecimento->km_final - $abastecimento->km_inicial, 1, ',', '.')}} </td>
                                <td align="right"> {{number_format($abastecimento->consumo, 2, ',', '.')}} </td>
                                <td align="right"> {{number_format($abastecimento->media, 2, ',', '.')}} </td>
                               
                            @endforeach
                            <tr class="success"> 
                                <td colspan=2>Total do Modelo</td>
                                <td align="right"></td>
                                <td align="right">{{number_format($modeloDistancia, 1, ',', '.')}} </td>
                                <td align="right">{{number_format($modeloVolume, 2, ',', '.')}} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<table class="table table-sm report-table">
    <tbody>
        <tr class="default">
            <td><h5>Total Geral</h5></td>
            <td align="right"><h5>Distância Percorrida: {{number_format($distanciaTotal, 1, ',', '.')}}</h5></td>
            <td align="right"><h5>Consumo Total: {{number_format($volumeTotal, 2, ',', '.')}}</h5></td>
        </tr>
    </tbody>
</table>
@endsection