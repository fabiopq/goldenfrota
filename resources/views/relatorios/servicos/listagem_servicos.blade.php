@extends('layouts.relatorios')

@section('relatorio')
<table class="table table-sm report-table">
    <thead>
        <tr class="info">
            <td>
                Id
            </td>
            <td>
                SERVIÇO
            </td>
            <td>
                DESCRIÇÃO
            </td>
            
        </tr>
    </thead>
    <tbody>
        @foreach($servicos as $servico) 
        <tr>
            <td>
                {{$servico->id}}
            </td>
            <td>
                {{$servico->servico }}
            </td>
            <td>
                {{$servico->descricao}}
            </td>
            
        </tr>
        @endforeach
    </tbody>
</table>
@endsection