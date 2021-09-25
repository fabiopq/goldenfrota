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
            'title' => 'Relatório de Abastecimentos - Bicos', 
            'routeUrl' => route('param_relatorio_abastecimentos_bico'), 
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
                            'inputValue' => date('01/m/Y'),
                            
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_final',
                            'label' => 'Data Final',
                            'inputSize' => 3,
                            'dateTimeFormat' => 'DD/MM/YYYY',
                            'picker_begin' => 'data_inicial',
                            'picker_end' => 'data_final',
                            'inputValue' => date('t/m/Y'),
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
                            'inputSize' => 5
                        ],
                        [
                            'type' => 'checkbox',
                            'field' => 'mostra_media',
                            'label' => 'KM Média',
                            'dataWidth' => 65,
                            'inputSize' => 1,
                            'dataSize' => 'default',
                            'disabled' => false
                        ]
                    ]
                ])  
                @endcomponent 
            @endsection
        @endcomponent
    </div>
    <script>
        $(document).ready(function() {
            var buscarDepartamentos = function() {
                var departamento = {};

                departamento.id = $('#cliente_id').val();
                departamento._token = $('input[name="_token"]').val();

                console.log(departamento);
                $.ajax({
                    url: '{{ route("departamentos.json") }}',
                    type: 'POST',
                    data: departamento,
                    dataType: 'JSON',
                    cache: false,
                    success: function (data) {
                        console.log(data);
                        if (data.length > 0) {
                            $("#departamento_id")
                                .removeAttr('disabled')
                                .find('option')
                                .remove();
                        } else {
                            if ($('#cliente_id').val() == -1) {
                                $("#departamento_id").attr('disabled', 'disabled');
                            }
                        }

                        $('#departamento_id').append($('<option>', { 
                                value: -1,
                                text : 'NADA SELECIONADO'
                        }));
                        $.each(data, function (i, item) {
                            $('#departamento_id').append($('<option>', { 
                                value: item.id,
                                text : item.departamento 
                            }));
                        });
                        
                        @if(old('departamento_id'))
                        $('#departamento_id').selectpicker('val', {{old('departamento_id')}});
                        @endif

                        $('.selectpicker').selectpicker('refresh');
                    }
                });                
            }

            var buscarVeiculos = function() {
                var cliente = {};

                cliente.id = $('#cliente_id').val();
                cliente._token = $('input[name="_token"]').val();

                //console.log(cliente);
                $.ajax({
                    url: '{{ route("veiculos.json") }}',
                    type: 'POST',
                    data: cliente,
                    dataType: 'JSON',
                    cache: false,
                    success: function (data) {
                        //console.log(data);
                        $("#veiculo_id")
                            .removeAttr('disabled')
                            .find('option')
                            .remove();

                        $('#veiculo_id').append($('<option>', { 
                                value: -1,
                                text : 'NADA SELECIONADO'
                        }));
                        $.each(data, function (i, item) {
                            $('#veiculo_id').append($('<option>', { 
                                value: item.id,
                                text : item.placa + ' - ' + item.marca_veiculo + ' ' + item.modelo_veiculo
                            }));
                        });
                        
                        @if(old('modelo_veiculo_id'))
                        $('#modelo_veiculo_id').selectpicker('val', {{old('modelo_veiculo_id')}});
                        @endif

                        $('.selectpicker').selectpicker('refresh');
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }

            var buscarVeiculosDepartamento = function() {
                var departamento = {};

                departamento.id = $('#departamento_id').val();
                departamento.cliente_id = $('#cliente_id').val();
                departamento._token = $('input[name="_token"]').val();

                console.log(departamento);
                $.ajax({
                    url: '{{ route("veiculos_departamento.json") }}',
                    type: 'POST',
                    data: departamento,
                    dataType: 'JSON',
                    cache: false,
                    success: function (data) {
                        console.log(data);
                        $("#veiculo_id")
                            .removeAttr('disabled')
                            .find('option')
                            .remove();

                        $('#veiculo_id').append($('<option>', { 
                                value: -1,
                                text : 'NADA SELECIONADO'
                        }));
                        $.each(data, function (i, item) {
                            $('#veiculo_id').append($('<option>', { 
                                value: item.id,
                                text : item.placa + ' - ' + item.marca_veiculo + ' ' + item.modelo_veiculo
                            }));
                        });
                        
                        @if(old('modelo_veiculo_id'))
                        $('#modelo_veiculo_id').selectpicker('val', {{old('modelo_veiculo_id')}});
                        @endif

                        $('.selectpicker').selectpicker('refresh');
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }

            var buscarPorCliente = function() {
                buscarDepartamentos();
                buscarVeiculos();
            }

            $('#cliente_id').on('changed.bs.select', buscarPorCliente);
            $('#departamento_id').on('changed.bs.select', buscarVeiculosDepartamento);
        });
    </script>
@endsection