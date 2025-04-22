@extends('layouts.relatorios')

@section('relatorio')

@foreach($estoques as $estoque)
<table class="table table-sm report-table">
    <thead>
        <tr class="info">
            <td colspan="4">
                <h4>Estoque: {{ $estoque->estoque }}</h4>
            </td>
        </tr>
        <tr>
            <td>
                ID
            </td>
            <td>
                Produto
            </td>
            <td>
                Grupo de Produto
            </td>           
            <td align="right">
                Qtd. Entrada
            </td>
            <td align="right">
                Qtd. Saída
            </td>
        </tr>
    </thead>
    <tbody>
        @foreach($estoque->produtos as $produto)
            @php
            $totalEntrada = 0;
            $totalSaida = 0;
            @endphp
            @foreach($produto->movimentacao_produto as $movimentacao) 
                @php
                if ($movimentacao->tipo_movimentacao_produto->eh_entrada) {
                    $totalEntrada += $movimentacao->quantidade_movimentada;
                } else {
                    $totalSaida += $movimentacao->quantidade_movimentada;
                }
                @endphp

            @endforeach
            <tr>
                <td>
                    {{ $produto->id }}
                 </td>
                <td>
                   {{ $produto->produto_descricao }}
                </td>
                <td>
                   {{ $produto->grupo_produto->grupo_produto }}
                </td>
                <td align="right">
                    {{ number_format($totalEntrada, 3, ',', '.') }}
                </td>
                <td align="right">
                    {{ number_format($totalSaida, 3, ',', '.') }}
                </td>
            </tr>
        @endforeach        
    </tbody>
</table>
@endforeach
@endsection