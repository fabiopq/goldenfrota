@extends('layouts.relatorios')

@section('relatorio')
@php
$volumeTotal = 0;
$valorTotal = 0;
$fornecedor = 0;
@endphp

@foreach($entradas as $entrada)

<table class="table table-sm report-table">

    <tbody>
        <tr>
            <td colspan=4>


                <table class="table table-sm report-table">
                    <thead>

                        <tr class="info">
                            <td colspan=4>
                                <strong>Fornecedor: {{ $entrada->nome_razao }}</strong>
                                <strong> </strong>
                                <strong>Data: {{ date_format(date_create($entrada->data_doc), 'd/m/Y H:i:s') }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Data
                            </td>
                            <td>
                                Doc.
                            </td>
                            <td>
                                Tanque
                            </td>
                            <td>
                                Combústivel
                            </td>

                            <td align="right">
                                Quantidade
                            </td>
                            <td align="right">
                                R$ vlr Un
                            </td>
                            <td align="right">
                                R$ Total
                            </td>
                        </tr>
                    </thead>



                    <tbody>
                        @foreach($entrada->itens as $produto)
                         @php
                          $volumeTotal += $produto->quantidade;
                          $valorTotal += $produto->quantidade * $produto->valor_unitario;
                         @endphp


                        <tr>
                            <td>
                                {{ date_format(date_create($entrada->data_doc), 'd/m/Y H:i:s') }}
                            </td>
                            <td>
                                {{ $entrada->nr_docto }}
                            </td>
                            <td>
                                {{ $produto->tanque_id }}
                            </td>
                            <td>
                                {{ $produto->descricao }}
                            </td>
                            <td align="right">
                                {{ number_format($produto->quantidade, 2, ',', '.') }}
                            </td>
                            <td align="right">
                                {{ number_format($produto->valor_unitario, 3, ',', '.') }}
                            </td>
                            <td align="right">
                                {{ number_format($produto->quantidade * $produto->valor_unitario, 2, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </td>
        </tr>
    </tbody>
</table>

@endforeach
<table class="table table-sm report-table">
    <tbody>
        <tr class="default">
            <td>
                <h5>Total Geral</h5>
            </td>
            <td align="right">
                <h5>Volume: {{ number_format($volumeTotal, 3, ',', '.') }}</h5>
            </td>
            <td align="right">
                <h5>Valor Total: {{ number_format($valorTotal, 3, ',', '.') }}</h5>
            </td>
        </tr>
    </tbody>
</table>
@endsection