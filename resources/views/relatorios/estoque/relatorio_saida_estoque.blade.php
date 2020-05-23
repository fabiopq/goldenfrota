@extends('layouts.relatorios')

@section('relatorio')
@php
   
    $departamentoVolume = 0;
    $valorDepartamento = 0;
    $distanciaTotal = 0;
    $valortotal = 0;
@endphp
{{--  {{dd($clientes)}}  --}}
@foreach($clientes as $cliente) 
<div class="panel-sm">
    <div class="panel-sm">
        <div class="card-header report-subtitle-1">
            <h4> Cliente: {{$cliente->nome_razao}} </h4>
        </div>    
        <div class="card-body">
            @foreach($cliente->departamentos as $departamento)
            @php
                $departamentoVolume = 0;
                $valorDepartamento = 0; 
                $quantidadeDepartamento = 0;
                   
            @endphp
            <div class="panel-sm">
                <div class="card-header report-subtitle-1">
                    <h5>Departamento: {{$departamento->departamento}}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm report-table">
                        <thead>
                            <td align="left">ID</td>
                            <td align="left">Produto</td>
                            <td align="left">Quantidade</td>
                            <td align="right">Valor Un. Medio</td>
                            <td align="right">Valor Total</td>
                                                   
                            
                        </thead>
                        <tbody>
                            @foreach($departamento->saidaestoques as $saidaestoque)
                            @php
                                $valorTotalItem = 0;
                                $valorTotalItem = $saidaestoque->quantidade * $saidaestoque->valor_unitario;
                                $valorDepartamento += $valorTotalItem;
                                $quantidadeDepartamento += $saidaestoque->quantidade;
                                $valortotal += $valorDepartamento;
                            @endphp
                            <tr> 
                            <td align="left">{{ $saidaestoque->id}}</td>
                            <td align="left"> {{$saidaestoque->produto_descricao}} </td>
                            <td align="left">{{$saidaestoque->quantidade}} </td>
                            <td align="right"> R$ {{number_format($saidaestoque->valor_unitario,2, ',', '.')}} </td>
                            <td align="right"> R$ {{number_format($valorTotalItem,2, ',', '.')}} </td>               
                            </tr>
                            @endforeach
                            <tr class="success"> 
                                <td align="left"><h6><b>Total do Departamento</b></h6></td>
                                <td align="left"></td>
                                <td align="left"><h6><b>{{number_format($quantidadeDepartamento,2, ',', '.')}}</b></h6> </td>
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