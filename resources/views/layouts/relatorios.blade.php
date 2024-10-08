@extends('layouts.base')

@push('header-styles')
    <link href="{{ mix('css/report.css') }}" rel="stylesheet" media="all">
@endpush

@section('body')

    <div class="card" style="margin-bottom: 80px">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3">
                    @if (isset($parametro))
                        <img src="{{ asset($parametro->logotipo) }}" width="200px">
                    @else
                        <img src="{{ asset('images/logo_golden_relatorio.png') }}"
                            alt="Golden Service - Controle de Frotas">
                    @endif


                </div>
                @if (isset($parametro))
                    <div class="col-sm-2 col-md-10 col-lg-10">
                        <div class="row">
                            {{ $parametro->cliente->nome_razao }} 

                            
                        </div>
                        <div class="row">
                            CNPJ: {{ $parametro->cliente->cpf_cnpj }}
                        </div>

                    </div>
                @endif
                <div class="col col-sm-10 col-md-10 col-lg-10" align="center">
                    <h3>{{ $titulo }}</h3>
                </div>
            </div>
        </div>
        @if (isset($parametros) && count($parametros) > 0)
            <div class="panel-sm">
                <div class="card-header">
                    <div class="row"><span class="parametro-relatorio" style="margin: 4px">Parâmetros selecionados</span>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 col-md-10 col-lg-10">
                            @foreach ($parametros as $parametro)
                                <span class="btn-sm btn-default parametro-relatorio">{{ $parametro }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @yield('relatorio')
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-bottom">
        <div class="ml-auto">
            <span data-toggle="tooltip" data-placement="top" title="Imprimir" data-original-title="Imprimir">
                <a href="javascript:window.print()" class="btn btn-success ml-auto" style="margin-right: 10px"
                    id="btn-report-print">
                    <i class="fas fa-print"></i>
                </a>
            </span>
            <span data-toggle="tooltip" data-placement="top" title="Fechar" data-original-title="Fechar">
                <a href="javascript:window.close()" class="btn btn-danger ml-auto" style="margin-right: 10px"
                    id="btn-report-close">
                    <i class="fas fa-times"></i>
                </a>
            </span>
        </div>
    </nav>
@endsection
