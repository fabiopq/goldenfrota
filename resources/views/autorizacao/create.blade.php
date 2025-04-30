@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Nova Autorizacao',
            'routeUrl' => route('autorizacao.store'),
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
                            'type' => 'select',
                            'field' => 'cliente_id',
                            'label' => 'Cliente',
                            'required' => true,
                            'items' => $clientes,
                            'autofocus' => true,
                            'displayField' => 'nome_razao',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => false,
                            'inputSize' => 7,
                        ],
                    
                       
                    ],
                ])
                @endcomponent
                
                @component('components.form-group', [
                    'inputs' => [
                       
                        [
                            'type' => 'select',
                            'field' => 'veiculo_id',
                            'label' => 'Veículo',
                            'required' => true,
                            'items' => null,
                            'disabled' => true,
                            'inputSize' => 4,
                            'displayField' => 'placa',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                        ],
                        [
                            'type' => 'number',
                            'field' => 'km_veiculo',
                            'label' => 'KM do Veículo',
                            'required' => true,
                            'inputSize' => 4,
                            'inputValue' => 0,
                        ],
                
                       
                    ],
                ])
                @endcomponent
                
                <div class="card">
                    <div class="card-header">
                        <strong>AUTOMAÇÃO</strong>
                    </div>
                    <div class="card-body">
                        @component('components.form-group', [
                            'inputs' => [
                                [
                                    'type' => 'select',
                                    'field' => 'bico_id',
                                    'label' => 'Número do Bico',
                                    'required' => true,
                                    'items' => $bicos,
                                    'inputSize' => 4,
                                    'displayField' => 'num_bico',
                                    'keyField' => 'id',
                                    'defaultNone' => true,
                                    'liveSearch' => true,
                                ],
                                
                            ]
                        ])
                        @endcomponent
                    </div>
                </div>

            @endsection
        @endcomponent
    </div>
   
@endsection
@push('document-ready')

      
        var buscarVeiculos = function() {
            var cliente = {};

            cliente.id = $('#cliente_id').val();
            cliente._token = $('input[name="_token"]').val();

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

                    $('#veiculo_id').append($('<option>', {value: '', text: 'Nada selecionado'}));

                    $.each(data, function (i, item) {
                        $('#veiculo_id').append($('<option>', { 
                            value: item.id,
                            'data-tipo-controle-veiculo': item.modelo_veiculo.tipo_controle_veiculo.id,
                            text : item.placa + ' - ' + item.modelo_veiculo.marca_veiculo.marca_veiculo + ' ' + item.modelo_veiculo.modelo_veiculo
                        }));
                    });
                    
                    @if(old('modelo_veiculo_id'))
                    $('#modelo_veiculo_id').selectpicker('val', {{old('modelo_veiculo_id')}});
                    @endif

                    $('.selectpicker').selectpicker('refresh');
                },
                error: function (data) {
                }
            });
        }
       
        $('#cliente_id').on('changed.bs.select', buscarVeiculos);
       
        if ($('#cliente_id').val()) {
            buscarVeiculos();
        }

        $('#veiculo_id').on('changed.bs.select', (e) => {
            if ($('#'+e.target.id).find('option:selected').data('tipo-controle-veiculo') == 1) {
                $('#label__km_veiculo').html('KM do Veículo');
            } else {
                $('#label__km_veiculo').html('Horas trabalhadas');
            }
        });
@endpush

