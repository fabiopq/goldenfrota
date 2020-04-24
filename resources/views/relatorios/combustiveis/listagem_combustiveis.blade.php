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
                Valor
            </td>
        </tr>
    </thead>
    <tbody>
        @foreach($combustiveis as $combustivel) 
        <tr>
            <td>
                {{$combustivel->id}}
            </td>
            <td>
                {{$combustivel->descricao}}
            </td>
            <td>
                {{number_format($combustivel->valor, 3, ',', '.')}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection