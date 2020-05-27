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
                                $valortotal += $ordemservico->valor_total;
                            @endphp
                            <thead> 
                                <td align="left"><b>Data/Hora Abertura: {{ date('d/m/Y H:i:s', strtotime($ordemservico->created_at)) }}</b></td>
                                @if ($ordemservico->data_fechamento <> "")
                                <td align="left"><b>Data/Hora Fechamento: {{ date('d/m/Y H:i:s', strtotime($ordemservico->data_fechamento)) }}</b></td>
                                @else
                                <td align="left"></td>
                                @endif
                                <td align="left"><b>Número da O.S: {{$ordemservico->id}} </b></td>
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
                            
                            @foreach($ordemservico->produtos ?? [] as $produto)
                            
                            <tr> 
                                <td align="left"> {{$produto->id}} - {{$produto->produto_descricao}} </td>
                                <td align="right"> {{number_format($produto->quantidade,0, ',', '.')}} </td>
                                <td align="right"> {{number_format($produto->valor_produto,2, ',', '.')}} </td>
                                <td align="right"> {{number_format($produto->valor_desconto,2, ',', '.')}} </td>
                                <td align="right"> {{number_format($produto->valor_acrescimo,2, ',', '.')}} </td>
                                <td align="right"> {{number_format($produto->valor_cobrado,2, ',', '.')}} </td>
                            </tr>
                            @endforeach
                            
                            @foreach($ordemservico->servicos ?? [] as $servico)
                            
                            <tr> 
                                <td align="left"> {{$servico->id}} - {{$servico->descricao}} </td>
                                <td align="right"> 1 </td>
                                <td align="right"> {{number_format($servico->valor_servico,2, ',', '.')}} </td>
                                <td align="right"> {{number_format($servico->valor_desconto,2, ',', '.')}} </td>
                                <td align="right"> {{number_format($servico->valor_acrescimo,2, ',', '.')}} </td>
                                <td align="right"> {{number_format($servico->valor_cobrado,2, ',', '.')}} </td>
                                
                            </tr>
                            @endforeach
                            <tr class="success"> 
                                <td align="left"><b>Observações: {{$ordemservico->obs}}  </b></td>
                                <td align="right"></td>    
                                <td align="right"></td>   
                                <td align="right"></td>     
                                <td align="right"></td>   
                                <td align="right"></td>                          
                            </tr>
                            <tr class="success"> 
                                <td align="left"><h6><b>Total da Ordem de Serviço</b></h6></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"><h6><b>R$ {{number_format($ordemservico->valor_total,2, ',', '.')}}</b></h6> </td>
                                
                            </tr>
                            <tr class="success"> 
                                <td align="right"> </td>
                                <td align="right"> </td>
                                <td align="right"> </td>
                                <td align="right"> </td>
                                <td align="right"> </td>
                                <td align="right"> </td>                                
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