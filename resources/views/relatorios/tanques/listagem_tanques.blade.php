@extends('layouts.relatorios')

@section('relatorio')
<table class="table table-sm report-table">
    <thead>
        <tr class="info">
            <td>
                Id
            </td>
            <td>
                Descrição
            </td>
            <td>
                Posto Abastecimento
            </td>
            <td>
                Combustível
            </td>
            <td>
                Capacidade
            </td>
            <td>
                Posição
            </td>
            
        </tr>
    </thead>
    <tbody>
       
        @foreach($tanques as $tanque) 
    
        <tr>
            <td>
                {{$tanque->id}}
            </td>
            <td>
                {{$tanque->descricao_tanque}}
            </td>
            <td>
                {{$tanque->posto_abastecimento}}
            </td>
            <td>
                {{$tanque->combustivel->descricao}}
            </td>
            <td>
                {{$tanque->capacidade}}
            </td>
            <td>
                {{ number_format($tanque->posicao, 3) }}
            </td>
            
        </tr>
        @endforeach
    </tbody>
</table>
@endsection