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

<div class="panel-sm">
    <div class="panel-sm">
        <div class="card-header report-subtitle-1">
            
        </div>    
        <div class="card-body">
            @foreach($grupoprodutos as $grupoproduto)
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
                            <td>Codigo</td>
                            
                            <td align="lefth">Produto</td>
                            <td align="right">Custo R$</td>
                            <td align="right">Preço R$</td>
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
                                <td> {{$produto->id}} </td>
                                <td align="lefth"> {{$produto->produto_descricao}} </td>
                                <td align="right"> {{number_format($produto->valor_custo, 2, ',', '.')}} </td>
                                <td align="right"> {{number_format($produto->valor_venda, 2, ',', '.')}} </td>                           
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

<table class="table table-sm report-table">
    <tbody>
        <tr class="default">
            <td><h5>Total Geral</h5></td>
    </tbody>
</table>
@endsection