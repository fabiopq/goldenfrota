@extends('layouts.app')


@section('content')

    <div class="card m-0 border-0">

        @component('components.form', [
            'title' => 'Novo Alerta / Bloqueio',
            'routeUrl' => route('veiculo_status.store'),
            'method' => 'POST',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'check'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'times'],
            ],
        ])
            @section('formFields')
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'datetime',
                            'field' => 'data',
                            'label' => 'Data/Hora',
                            'required' => true,
                            'inputSize' => 2,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'sideBySide' => true,
                            'inputValue' => date('d/m/Y H:i:s'),
                        ],
                        [
                            'type' => 'select',
                            'field' => 'veiculo_id',
                            'label' => 'Veículo',
                            'required' => true,
                            'items' => $veiculos,
                            'displayField' => 'veiculo',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 4,
                        ],
                        [
                            'type' => 'select',
                            'field' => 'status_id',
                            'label' => 'Status',
                            'inputSize' => 3,
                            'indexSelected' => 2,
                            'items' => ['Alertar', 'Bloquear', 'Liberado'],
                        ],
                    ],
                ])
                @endcomponent
                <div class="card">
                    <div class="card-header">
                        <strong>Histórico</strong>
                    </div>
                    <div class="card-body">
                        @component('components.form-group', [
                            'inputs' => [
                                [
                                    'type' => 'textarea',
                                    'field' => 'historico',
                                    'label' => '',
                                    
                                ],
                                
                            ],
                        ])
                        @endcomponent
                    </div>
                </div>
            @endsection
        @endcomponent

        @include('veiculo.modal')

        <!-- Modal -->


    @endsection

    @push('document-ready')
        $('#placa').mask('SSS-0AA0', {placeholder: '___-____'});

        var buscarDepartamentos = function() {
        var departamento = {};

        departamento.id = $('#cliente_id').val();
        departamento._token = $('input[name="_token"]').val();

        console.log(departamento);
        $.ajax({
        url: '{{ route('departamentos.json') }}',
        type: 'POST',
        data: departamento,
        dataType: 'JSON',
        cache: false,
        success: function (data) {
        $("#departamento_id")
        .removeAttr('disabled')
        .find('option')
        .remove();


        $.each(data, function (i, item) {
        $('#departamento_id').append($('<option>', {
            value: item.id,
            text : item.departamento
            }));
            });

            @if (old('departamento_id'))
                $('#departamento_id').selectpicker('val', {{ old('departamento_id') }});
            @endif

            $('.selectpicker').selectpicker('refresh');
            }
            });
            }

            var buscarModeloVeiculos = function() {
            var marca = {};

            marca.id = $('#marca_veiculo_id').val();
            marca._token = $('input[name="_token"]').val();

            console.log(marca);
            $.ajax({
            url: '{{ route('modelo_veiculos.json') }}',
            type: 'POST',
            data: marca,
            dataType: 'JSON',
            cache: false,
            success: function (data) {
            console.log(data);
            $("#modelo_veiculo_id")
            .removeAttr('disabled')
            .find('option')
            .remove();


            $.each(data, function (i, item) {
            $('#modelo_veiculo_id').append($('
        <option>', {
            value: item.id,
            text : item.modelo_veiculo
            }));
            });

            @if (old('modelo_veiculo_id'))
                $('#modelo_veiculo_id').selectpicker('val', {{ old('modelo_veiculo_id') }});
            @endif

            $('.selectpicker').selectpicker('refresh');
            }
            });
            }

            $('#cliente_id').on('changed.bs.select', buscarDepartamentos);
            $('#marca_veiculo_id').on('changed.bs.select', buscarModeloVeiculos);

            if ($('#marca_veiculo_id').val()) {
            buscarModeloVeiculos();
            }

            if ($('#cliente_id').val()) {
            buscarDepartamentos();
            }
        @endpush
