@extends('layouts.relatorios')

@section('relatorio')
<table class="table table-sm report-table">
    <thead>
        <tr class="info">
            <td>
                Id
            </td>
            <td>
                Nome
            </td>
            <td>
                CPF
            </td>
            <td>
                RG
            </td>
            <td>
                Validade CNH
            </td>

        </tr>
    </thead>
    <tbody>
        @foreach($motoristas as $motorista)
        <tr>
            <td>
                {{$motorista->id}}
            </td>
            <td>
                {{$motorista->nome}}
            </td>
            <td>
                {{$motorista->cpf}}
            </td>
            <td>
                {{$motorista->rg}}
            </td>
            <td>
            {{date_format(date_create($motorista->data_validade_habilitacao), 'd/m/Y')}}
                
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
@endsection