@extends('layouts.relatorios')

@section('relatorio')
<table class="table table-sm report-table">
    <thead>
        <tr class="info">
            <td>
                Id
            </td>
            <td>
                Nome/Razão
            </td>
            <td>
                CPF/CNPJ
            </td>
            <td>
                RG/IE
            </td>
            <td>
                Fone [1]
            </td>
            <td>
                Limite
            </td>
            <td>
                Endereço
            </td>
        </tr>
    </thead>
    <tbody>
        @foreach($clientes as $cliente) 
        <tr>
            <td>
                {{$cliente->id}}
            </td>
            <td>
                {{$cliente->nome_razao}}
            </td>
            <td>
                {{$cliente->cpf_cnpj}}
            </td>
            <td>
                {{$cliente->rg_ie}}
            </td>
            <td>
                {{$cliente->fone1}}
            </td>
            <td>
            {{number_format($cliente->limite, 2, ',', '.')}}
            </td>
            <td>
                {{$cliente->endereco.', '.$cliente->numero.' - '.$cliente->bairro.' - '.$cliente->cidade.'/'.$cliente->uf->uf}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection