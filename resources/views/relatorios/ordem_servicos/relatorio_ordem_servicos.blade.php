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
                        <thead>
                            <td>Data/Hora Abertura</td>
                            <td>Data/Hora Fechamento</td>
                            <td align="left">Número</td>
                            <td align="right"></td>
                            <td align="right">Placa / Veículo</td>
                            <td align="right">Odômetro / Horímetro:</td>
                            <td align="right">Valor</td>
                                                   
                            
                        </thead>
                        <tbody>
                            @foreach($departamento->ordemservicos as $ordemservico)
                            @php
                             
                                $valorDepartamento += $ordemservico->valor_total;
                                $valortotal += $ordemservico->valor_total;
                            @endphp
                            <tr> 
                              <td align="left">{{ date('d/m/Y H:i:s', strtotime($ordemservico->created_at)) }}</td>
                              @if ($ordemservico->data_fechamento <> "")
                              <td align="left">{{ date('d/m/Y H:i:s', strtotime($ordemservico->data_fechamento)) }}</td>
                              @else
                              <td align="left"></td>
                              @endif
                                <td align="left"> {{$ordemservico->id}} </td>
                                <td align="right"></td>
                                <td align="right"> {{$ordemservico->placa}} </td>
                                <td align="right">{{number_format($ordemservico->km_veiculo,0, ',', '.')}} </td>
                                <td align="right">R$ {{number_format($ordemservico->valor_total,2, ',', '.')}} </td>
                                
                            </tr>
                            @endforeach
                            <tr class="success"> 
                                <td align="left"><h6><b>Total do Departamento</b></h6></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"><h6><b>R$ {{number_format($valorDepartamento,2, ',', '.')}}</b></h6> </td>
                                
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