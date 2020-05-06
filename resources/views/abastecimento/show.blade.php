@extends('layouts.relatorios')

@section('relatorio')
@php
 //dd($combustivel[0]->descricao);   
@endphp
<div class="container-fluid m-b-10">
    <div class="row">
        <div class="col col-sm-12 col-md-12 col-lg-12">
            <div class="card nf-panel">
                <div class="card-body">
                    <div class="float-left mr-auto">
                        <label for="#numero" class="nf-label">Número:</label>
                        <div id="numero">{{ $abastecimento->id }}</div>
                    </div>
                    <div class="float-right" style="margin-left: 25px">
                        <label for="#os_fechada" class="nf-label">status:</label>
                        <div id="os_fechada">{{ $abastecimento->id ?? 'Aberta' }}</div>
                    </div>
                    <div class="float-right" style="margin-left: 25px">
                        <label for="#data_os" class="nf-label">Data/Hora Abastecimento:</label>
                        <div id="data_os">{{ ($abastecimento->id ) ? date_format(date_create($abastecimento->data_hora_abastecimento), 'd/m/Y - H:i:s') : '___/___/______ - ___:___:___   ' }}</div>
                    </div>
                    <div class="float-right" style="margin-left: 25px">
                        <label for="#data_os" class="nf-label">Data/Hora:</label>
                        <div id="data_os">{{ date_format(date_create($abastecimento->created_at), 'd/m/Y - H:i:s') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-5 col-md-5 col-lg-5">
            <div class="card nf-panel">
                <label for="#cliente" class="nf-label">Cliente:</label>
                <div id="cliente">{{ $abastecimento->veiculo->cliente_id }} - {{ $abastecimento->veiculo->cliente->nome_razao }}</div>
            </div>
        </div>
        <div class="col col-sm-3 col-md-3 col-lg-3">
            <div class="card nf-panel">
                <label for="#departamento" class="nf-label">Departamento:</label>
                <div id="departamento">{{ isset($abastecimento->veiculo->departamento) ? $abastecimento->veiculo->departamento->departamento : '&nbsp;' }}</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="card nf-panel">
                <label for="#veiculo" class="nf-label">Veículo:</label>
                <div id="veiculo">{{ $abastecimento->veiculo->placa }}</div>
            </div>
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="card nf-panel">
                <label for="#km_atual" class="nf-label">Odômetro / Horímetro:</label>
                <div id="km_atual">{{ $abastecimento->km_veiculo }}</div>
            </div>
        </div>
    </div>
    {{--  Serviços  --}}
    <div class="row" align="center">
        <div class="col col-sm-12 col-md-12 col-lg-12">
            <div class="card nf-panel">
                <strong>Combustivel</strong> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-1 col-md-1 col-lg-1">
            <div class="card nf-panel">
                Bico
            </div>
        </div>
        <div class="col col-sm-7 col-md-7 col-lg-7">
            <div class="card nf-panel">
                Combustível
            </div>
        </div>
        <div class="col col-sm-1 col-md-1 col-lg-1">
            <div class="card nf-panel">
                Quantidade
            </div>
        </div>
        <div class="col col-sm-1 col-md-1 col-lg-1">
            <div class="card nf-panel">
                Vlr Unitario
            </div>
        </div>
        <div class="col col-sm-1 col-md-1 col-lg-1">
            <div class="card nf-panel">
                Desc.
            </div>
        </div>
        <div class="col col-sm-1 col-md-1 col-lg-1">
            <div class="card nf-panel">
                Total
            </div>
        </div>
    </div>
      
    
    <div class="row">
        <div class="col col-sm-1 col-md-1 col-lg-1">
            <div class="card nf-panel">
                <div>{{ $abastecimento->bico_id }}</div>
            </div>
        </div>
        <div class="col col-sm-7 col-md-7 col-lg-7">
            <div class="card nf-panel">
                <div>{{ $combustivel[0]->descricao }}</div>
            </div>
        </div>
        <div class="col col-sm-1 col-md-1 col-lg-1">
            <div class="card nf-panel">
                <div>{{ $abastecimento->volume_abastecimento }}</div>
            </div>
        </div>
        <div class="col col-sm-1 col-md-1 col-lg-1">
            <div class="card nf-panel">
                <div>{{ $abastecimento->valor_litro }}</div>
            </div>
        </div>
        <div class="col col-sm-1 col-md-1 col-lg-1">
            <div class="card nf-panel">
                <div>{{ $abastecimento->id }}</div>
            </div>
        </div>
        <div class="col col-sm-1 col-md-1 col-lg-1">
            <div class="card nf-panel">
                <div>{{ $abastecimento->valor_abastecimento }}</div>
            </div>
        </div>
    </div>
    
   
    <div class="row">
        <div class="col col-sm-10 col-md-10 col-lg-10">
            
        </div>
        <div class="col col-sm-2 col-md-2 col-lg-2">
            <div class="card nf-panel clearfix">
                <div class="pull-right">
                    <label for="#data_os" class="nf-label">Valor Total:</label>
                    <div id="data_os">{{ $abastecimento->valor_abastecimento }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-12 col-md-12 col-lg-12">
            <div class="card nf-panel">
                <label for="#obs" class="nf-label">Observações:</label>
                <div id="obs">{!! ($abastecimento->obs) ? $abastecimento->obs_abastecimento : '&nbsp;' !!}</div>
            </div>
        </div>
    </div>
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <div class="container-fluid m-b-10">
        <div class="row" align="center">
            <div class="col col-sm-1 col-md-1 col-lg-1">
            </div>
            <div class="col col-sm-4 col-md-4 col-lg-4">
                <div style="border-bottom: 1px solid"> </div>
            </div>
            <div class="col col-sm-2 col-md-2 col-lg-2">
            </div>
            <div class="col col-sm-4 col-md-4 col-lg-4">
                <div style="border-bottom: 1px solid"> </div>
            </div>
            <div class="col col-sm-1 col-md-1 col-lg-1">
            </div>
            <div class="col col-sm-1 col-md-1 col-lg-1">
            </div>
            <div class="col col-sm-4 col-md-4 col-lg-4" align="center">
                <strong>{{ $abastecimento->user->name ?? 'Usuário não informado' }}</strong> 
            </div>
            <div class="col col-sm-2 col-md-2 col-lg-2">
            </div>
            <div class="col col-sm-4 col-md-4 col-lg-4" align="center">
                <strong>{{ $abastecimento->veiculo->cliente->nome_razao }}</strong> 
            </div>
        </div>
    </div>
</div>
@endsection