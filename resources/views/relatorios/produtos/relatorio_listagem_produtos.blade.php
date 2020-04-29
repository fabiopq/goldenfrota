@extends('layouts.relatorios')

@section('relatorio')
@php
    $clienteVolume = 0;
    $clienteDistancia = 0;
    $departamentoVolume = 0;
    $departamentoDistancia = 0;
    $distanciaTotal = 0;
    $volumeTotal = 0;
    
@endphp
{{--  {{dd($clientes)}}  --}}
@foreach($estoques as $estoque) 
@php
    
    $clienteVolume = 0;
    $clienteDistancia = 0;
@endphp
<div class="panel-sm">
    <div class="panel-sm">
        <div class="card-header report-subtitle-1">
            <h4> Estoque: {{$estoque->estoque}} </h4>
        </div>    
        <div class="card-body">
            @foreach($estoque->grupoprodutos as $grupoproduto)
            @php
                $departamentoVolume = 0;
                $departamentoDistancia = 0; 
                    
            @endphp
             <div class="panel-sm">
                <div class="card-header report-subtitle-1">
                    <h5>Grupo de Produtos: {{$grupoproduto->grupo_produto}}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm report-table">
                        <thead>
                            <td>Veículo</td>
                            <td align="right">KM Inicial</td>
                            <td align="right">KM Final</td>
                            <td align="right">Distância Percorrida</td>
                            <td align="right">Consumo Médio/KM</td>
                            <td align="right">Consumo Total</td>
                        </thead>
                        <tbody>
                            @foreach($grupoproduto->produtos as $produto)
                            @php
                                //$clienteVolume += $abastecimento->consumo;
                                //$clienteDistancia += $abastecimento->km_final - $abastecimento->km_inicial;
                                //$departamentoVolume += $abastecimento->consumo; 
                                //$departamentoDistancia += $abastecimento->km_final - $abastecimento->km_inicial;  
                                //$distanciaTotal += $abastecimento->km_final - $abastecimento->km_inicial;  
                                //$volumeTotal += $abastecimento->consumo;
                                
                            @endphp
                            <tr> 
                                <td> {{$produto->produto_descricao}} </td>
                                                           
                               </tr>
                            @endforeach
                            <tr class="success"> 
                                <td colspan=2>Total do Departamento</td>
                                <td align="right"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @php
            
            @endphp
            @endforeach
        </div>
    </div>
</div>
@endforeach
<table class="table table-sm report-table">
    <tbody>
        <tr class="default">
            <td><h5>Total Geral</h5></td>
    </tbody>
</table>
@endsection