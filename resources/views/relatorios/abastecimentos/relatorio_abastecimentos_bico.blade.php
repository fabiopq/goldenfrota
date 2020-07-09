@extends('layouts.relatorios')

@section('relatorio')
@php
    $qtdBico = 0;
    $vlrBico = 0;
    $qtdTotal = 0;
    $vlrTotal = 0;
@endphp

@foreach($bicos as $bico) 
@php
    $qtdBico = 0;
    $vlrBico = 0;
    
@endphp

<div class="panel-sm">
    <div class="panel-sm">
        <div class="card-header report-subtitle-1">
            <h4> Bico: {{$bico->num_bico}} - {{$bico->descricao_tanque}} - {{$bico->descricao}} </h4>
        </div>   
        

        <div class="card-body">
            <table class="table table-sm report-table">
                <thead>
                    <td>Data / Hora</td>
                    <td>Veículo</td>
                    @if ($media)
                        <td align="right">KM Média</td>
                    @endif
                    <td align="right">Enc. Inicial</td>
                    <td align="right">Enc. Final</td>
                    <td align="right">Quantidade</td>
                    <td align="right">Valor Unitário</td>
                    <td align="right">Valor Total</td>
                    
                </thead>
                <tbody>
                @foreach($bico->abastecimentos as $abastecimento)
                @php
                    $qtdBico += $abastecimento->volume_abastecimento;
                    $vlrBico += $abastecimento->valor_abastecimento;
                    $qtdTotal += $abastecimento->volume_abastecimento;
                    $vlrTotal += $abastecimento->valor_abastecimento;
                @endphp
                    <tr> 
                        <td> {{date_format(date_create($abastecimento->data_hora_abastecimento), 'd/m/Y H:i:s')}} </td>
                        <td> {{$abastecimento->placa}} </td>
                        
                        @if ($media)
                            <td align="right"> {{number_format($abastecimento->media_veiculo, 2, ',', '.')}} </td>
                        @endif
                        
                        <td align="right"> {{number_format($abastecimento->encerrante_inicial, 2, ',', '.')}} </td>
                        <td align="right"> {{number_format($abastecimento->encerrante_final, 2, ',', '.')}} </td>
                        <td align="right"> {{number_format($abastecimento->volume_abastecimento, 3, ',', '.')}} </td>
                        <td align="right"> {{number_format($abastecimento->valor_litro, 3, ',', '.')}} </td>
                        <td align="right"> {{number_format($abastecimento->valor_abastecimento, 3, ',', '.')}} </td>
                    </tr>
               
                    
                @endforeach
                    <tr class="success"> 
                        <td colspan=2>Total do Bico</td>
                       
                        @if ($media)
                            <td align="right"></td>
                        @endif

                        <td align="right"></td>                        
                        <td align="right"></td>
                        <td align="right">{{number_format($qtdBico, 3, ',', '.')}} </td>
                        <td align="right"> </td>
                        <td align="right">{{number_format($vlrBico, 3, ',', '.')}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endforeach
<table class="table table-sm report-table">
    <tbody>
        <tr class="default">
            <td><h5>Total Geral</h5></td>
            <td align="right"><h5>Quantidade Abastecida: {{number_format($qtdTotal, 3, ',', '.')}}</h5></td>
            <td align="right"><h5>Valor Abastecido: {{number_format($vlrTotal, 3, ',', '.')}}</h5></td>
        </tr>
    </tbody>
</table>
@endsection