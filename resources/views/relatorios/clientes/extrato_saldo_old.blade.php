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
                    Saldo
                </td>
            </tr>
        </thead>
        <tbody>

           
                <tr>
                    <td>
                        {{ $cliente->id }}
                    </td>
                    <td>
                        {{ $cliente->nome_razao }}
                    </td>
                    <td>
                        {{ $cliente->cpf_cnpj }}
                    </td>
                    <td>
                        {{ $cliente->rg_ie }}
                    </td>
                    <td>
                        {{ $cliente->fone1 }}
                    </td>
                    <td>
                        {{ number_format($cliente->limite, 2, ',', '.') }}
                    </td>
                    <td>
                        {{ number_format($saldo, 2, ',', '.') }}
                    </td>

                </tr>
            
        </tbody>
    </table>
@endsection
