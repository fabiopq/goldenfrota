<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Ordem de Serviço</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        th {
            background-color: #f0f0f0;
            text-align: left;
        }

        .section-title {
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h3>EMPRESA:{{ $parametro->cliente->nome_razao }}</h3>
    <h3>CNPJ: {{ $parametro->cliente->cpf_cnpj }}</h3>
    <h1 style="text-align: center;">Ordem de Serviço - {{ $ordemServico->id }}</h1>

    <table>
        <tr>
            <th>Status</th>
            <td>{{ $ordemServico->ordem_servico_status->os_status ?? 'Aberta' }}</td>
            <th>Data Abertura</th>
            <td>{{ date('d/m/Y - H:i:s', strtotime($ordemServico->created_at)) }}</td>
            <th>Data Fechamento</th>
            <td>{{ $ordemServico->fechada ? date('d/m/Y - H:i:s', strtotime($ordemServico->data_fechamento)) : '---' }}
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <th>Cliente</th>
            <td colspan="2">{{ $ordemServico->cliente_id }} - {{ $ordemServico->cliente->nome_razao }}</td>
            <th>Cpf / Cnpj</th>
            <td>{{ $ordemServico->cliente->cpf_cnpj }}</td>
        </tr>
        <tr>
            <th>Departamento</th>
            <td>{{ $ordemServico->veiculo->departamento->departamento ?? 'Não Informado' }}</td>
            <th>Veículo</th>
            <td>{{ $ordemServico->veiculo->placa ?? 'Não Informado' }}</td>
            <th>Odômetro / Horímetro</th>
            <td>{{ $ordemServico->km_veiculo }}</td>
        </tr>
    </table>
    @if ($ordemServico->servicos && $ordemServico->servicos->count() > 0)
        <div class="section-title">Serviços</div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Serviço</th>
                    <th>Valor</th>
                    <th>Acréscimo</th>
                    <th>Desconto</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ordemServico->servicos as $servico)
                    <tr>
                        <td>{{ $servico->servico_id }}</td>
                        <td>{{ $servico->servico->servico }}</td>
                        <td>{{ number_format($servico->valor_servico, 2, ',', '.') }}</td>
                        <td>{{ number_format($servico->valor_acrescimo, 2, ',', '.') }}</td>
                        <td>{{ number_format($servico->valor_desconto, 2, ',', '.') }}</td>
                        <td>{{ number_format($servico->valor_cobrado, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <div class="section-title">Produtos</div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Produto</th>
                <th>Qtd</th>
                <th>Valor Un.</th>
                <th>Acréscimo</th>
                <th>Desconto</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ordemServico->produtos as $item)
                <tr>
                    <td>{{ $item->produto_id }}</td>
                    <td>{{ $item->produto->produto_descricao }}</td>
                    <td>{{ $item->quantidade }}</td>
                    <td>{{ number_format($item->valor_produto, 2, ',', '.') }}</td>
                    <td>{{ number_format($item->valor_acrescimo, 2, ',', '.') }}</td>
                    <td>{{ number_format($item->valor_desconto, 2, ',', '.') }}</td>
                    <td>{{ number_format($item->valor_cobrado, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table>
        <tr>
            <th>Valor Total</th>
            <td colspan="6" style="text-align: right; font-weight: bold;">
                {{ number_format($ordemServico->valor_total, 2, ',', '.') }}
            </td>
        </tr>
    </table>

    <div class="section-title">Problema Relatado</div>
    <p>{!! $ordemServico->defeito ?? '&nbsp;' !!}</p>

    <div class="section-title">Atividades Realizadas</div>
    <p>{!! $ordemServico->obs ?? '&nbsp;' !!}</p>

    <br><br><br>

    <table style="margin-top: 30px;">
        <tr>
            <td style="border: none; text-align: center;">
                ____________________________<br>
                {{ $ordemServico->user->name ?? 'Usuário não informado' }}
            </td>
            <td style="border: none; text-align: center;">
                ____________________________<br>
                {{ $ordemServico->cliente->nome_razao ?? '' }}
            </td>
        </tr>
    </table>
</body>

</html>
