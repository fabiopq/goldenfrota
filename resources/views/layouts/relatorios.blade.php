@extends('layouts.base')

@push('header-styles')
    <link href="{{ mix('css/report.css') }}" rel="stylesheet" media="all">
@endpush

@section('body')

    {{-- A classe "report-container" foi adicionada para removermos a margem na impressão --}}
    <div class="card report-container" style="margin-bottom: 80px">
        <div class="card-header">
            {{-- GRID DO CABEÇALHO CORRIGIDO E SIMPLIFICADO --}}
            <div class="row align-items-center">
                {{-- Coluna do Logotipo --}}
                <div class="col-3">
                    @if (isset($parametro) && $parametro->logotipo)
                        <img src="{{ asset($parametro->logotipo) }}" width="200px" alt="Logotipo">
                    @else
                        <img src="{{ asset('images/logo_golden_relatorio.png') }}" alt="Golden Service - Controle de Frotas">
                    @endif
                </div>

                {{-- Coluna do Título e Informações da Empresa --}}
                <div class="col-9 text-center">
                    @if (isset($parametro))
                        <h5 class="mb-0">{{ $parametro->cliente->nome_razao }}</h5>
                        <p class="mb-2">CNPJ: {{ $parametro->cliente->cpf_cnpj }}</p>
                    @endif
                    <h3>{{ $titulo }}</h3>
                </div>
            </div>
        </div>

        @if (isset($parametros) && count($parametros) > 0)
            <div class="card-body border-bottom">
                <div class="row">
                    <div class="col-12">
                        <strong class="parametro-relatorio d-block mb-2">Parâmetros selecionados:</strong>
                        @foreach ($parametros as $parametro)
                            <span class="btn btn-sm btn-outline-secondary parametro-relatorio">{{ $parametro }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- O conteúdo do seu relatório (tabelas, etc.) será injetado aqui --}}
        @yield('relatorio')
    </div>


    {{-- 
        SOLUÇÃO PRINCIPAL: A classe "d-print-none" do Bootstrap 
        esconde este elemento inteiro na hora de imprimir.
    --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-bottom d-print-none">
        <div class="ml-auto">
            <span data-toggle="tooltip" data-placement="top" title="Exportar para Excel">
                <button class="btn btn-primary ml-auto" style="margin-right: 10px" id="btn-exportar-excel">
                    <i class="fas fa-file-excel"></i>
                </button>
            </span>

            <span data-toggle="tooltip" data-placement="top" title="Imprimir">
                <a href="javascript:window.print()" class="btn btn-success ml-auto" style="margin-right: 10px">
                    <i class="fas fa-print"></i>
                </a>
            </span>
            <span data-toggle="tooltip" data-placement="top" title="Fechar">
                <a href="javascript:window.close()" class="btn btn-danger ml-auto" style="margin-right: 10px">
                    <i class="fas fa-times"></i>
                </a>
            </span>
        </div>
    </nav>

@endsection

@push('scripts')
    {{-- Scripts para exportar para Excel --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        document.getElementById("btn-exportar-excel").addEventListener("click", function() {
            // Tenta encontrar uma tabela com a classe 'report-table' dentro do yield
            const table = document.querySelector('.report-table'); 
            if (table) {
                var wb = XLSX.utils.table_to_book(table, { sheet: "Relatório" });
                XLSX.writeFile(wb, "relatorio.xlsx");
            } else {
                alert("Nenhuma tabela encontrada para exportar.");
            }
        });
    </script>
@endpush

@push('css')
    {{-- CSS para remover a margem inferior extra apenas na impressão --}}
    <style>
        @media print {
            .report-container {
                margin-bottom: 0 !important;
            }
        }
    </style>
@endpush