@php
    $abast_local = isset($_GET['abast_local']) ? $_GET['abast_local'] : -1;
    $data_inicial = isset($_GET['data_inicial']) ? $_GET['data_inicial'] : null;
    $data_final = isset($_GET['data_final']) ? $_GET['data_final'] : null;
    $data_incio = mktime(0, 0, 0, date('m') , 1 , date('Y'));
    $data_fim = mktime(23, 59, 59, date('m'), date("t"), date('Y'));
@endphp
@extends('layouts.app')


@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Relatório de Aferições', 
            'routeUrl' => route('param_relatorio_afericoes'), 
            'formTarget' => '_blank',
            'method' => 'POST',
            'cancelRoute' => 'home',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Gerar Relatório', 'icon' => 'chart-line'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'times']
                ]
            ])
            @section('formFields')
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'datetime',
                            'field' => 'data_inicial',
                            'label' => 'Data Inicial',
                            'inputSize' => 3,
                            'dateTimeFormat' => 'DD/MM/YYYY',
                            'picker_begin' => 'data_inicial',
                            'picker_end' => 'data_final',
                            'inputValue' => date('dd/mm/yyyy',$data_incio)
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_final',
                            'label' => 'Data Final',
                            'inputSize' => 3,
                            'dateTimeFormat' => 'DD/MM/YYYY',
                            'picker_begin' => 'data_inicial',
                            'picker_end' => 'data_final',
                            'inputValue' => date('dd/mm/yyyy',$data_fim)
                        ],
                        [
                            'type' => 'select',
                            'field' => 'bico_id',
                            'label' => 'Bico',
                            'required' => true,
                            'items' => $bicos,
                            'autofocus' => true,
                            'displayField' => 'num_bico',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 5,
                            'searchById' => true
                        ]
                    ]
                ])  
                @endcomponent 
            @endsection
        @endcomponent
    </div>
    
@endsection

