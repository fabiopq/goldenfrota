@extends('layouts.relatorios')

@section('relatorio')
@php
    $clienteVolume = 0;
    $clienteDistancia = 0;
    $departamentoVolume = 0;
    $valorDepartamento = 0;
    $distanciaTotal = 0;
    $valortotal = 0;
@endphp
{{--  {{dd($clientes)}}  --}}
@foreach($clientes as $cliente) 
@php
    
    $clienteVolume = 0;
    $clienteDistancia = 0;
@endphp
<div class="panel-sm">
    <div class="panel-sm">
        <div class="card-header report-subtitle-1">
            <h4> Cliente: {{$cliente->nome_razao}} </h4>
        </div>    
        <div class="card-body">
            @foreach($cliente->departamentos as $departamento)
            @php
                $departamentoVolume = 0;
                $departamentoDistancia = 0; 
                $valorDepartamento = 0;
                    
            @endphp
            <div class="panel-sm">
                <div class="card-header report-subtitle-1">
                    <h5>Departamento: {{$departamento->departamento}}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm report-table">
                        
                        <tbody>
                            @foreach($departamento->ordemservicos as $ordemservico)
                            @php
                                
                                $valorDepartamento += $ordemservico->valor_total;
                               // $clienteDistancia += $abastecimento->km_final - $abastecimento->km_inicial;
                                //$departamentoVolume += $abastecimento->consumo; 
                                //$departamentoDistancia += $abastecimento->km_final - $abastecimento->km_inicial;  
                                //$distanciaTotal += $abastecimento->km_final - $abastecimento->km_inicial;  
                                $valortotal += $ordemservico->valor_total;
                            @endphp
                            <thead> 
                                <td align="left"><b>Data/Hora: {{ date('d/m/Y H:i:s', strtotime($ordemservico->created_at)) }}</b></td>
                                <td align="left"><b>Ordem de Serviço: {{$ordemservico->id}} </b></td>
                                <td align="right"></td>
                                <td align="right"><b>Placa: {{$ordemservico->placa}} </b></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                
                            </thead>
                            <thead>
                                                               
                                <td align="left">Produto / Serviço</td>
                                <td align="right">Quantidade</td>
                                <td align="right">Valor Un.</td>
                                <td align="right">Valor Desconto</td>
                                <td align="right">Valor Acrescimo</td>
                                <td align="right">Valor Total</td>
                                
                            </thead>
                            
                            <tr class="success"> 
                                <td align="left"><h6><b>Total da Ordem de Serviço</b></h6></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"><h6><b>R$ {{number_format($ordemservico->valor_total,2, ',', '.')}}</b></h6> </td>
                                
                            </tr>
                            @endforeach
                            
                            <tr class="success"> 
                                <td align="left"><h6>Total do Departamento</h6></td>
                                <td align="right"></td>
                                <td align="right"><h6>R$ {{number_format($valorDepartamento,2, ',', '.')}}</h6> </td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endforeach
<table class="table table-sm report-table">
    <tbody>
        <tr class="default">
            <td><h5>Total Geral</h5></td>
            <td align="right"><h5></h5></td>
            <td align="right"><h5>Valor Total R$: {{number_format($valortotal, 2, ',', '.')}}</h5></td>

        </tr>
    </tbody>
</table>
@endsection