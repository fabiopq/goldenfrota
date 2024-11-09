@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Novo Modelo de Veículo',
            'routeUrl' => route('modelo_veiculo.store'),
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
                            'type' => 'text',
                            'field' => 'modelo_veiculo',
                            'label' => 'Modelo de Veículo',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 4,
                        ],
                        [
                            'type' => 'select',
                            'field' => 'marca_veiculo_id',
                            'label' => 'Marca de Veículo',
                            'required' => true,
                            'items' => $marcaVeiculos,
                            'inputSize' => 4,
                            'displayField' => 'marca_veiculo',
                            'keyField' => 'id',
                            'liveSearch' => true,
                        ],
                        [
                            'type' => 'input-btn',
                            'field' => 'marca_id',
                            'label' => 'Novo',
                            'required' => true,
                            'inputSize' => 1,
                            'displayField' => 'marca',
                            'keyField' => 'id',
                            'action' => 'create',
                            'comando' => 'marcaVeiculoModal',
                            
                            
                        ],
                    ],
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'number',
                            'field' => 'capacidade_tanque',
                            'label' => 'Capacidade do Tanque',
                            'required' => true,
                            'inputSize' => 4,
                        ],
                        [
                            'type' => 'select',
                            'field' => 'tipo_controle_veiculo_id',
                            'label' => 'Tipo de Controle',
                            'required' => true,
                            'items' => $tipoControleVeiculos,
                            'inputSize' => 4,
                            'displayField' => 'tipo_controle_veiculo',
                            'keyField' => 'id',
                            'liveSearch' => true,
                        ],
                    ],
                ])
                @endcomponent

                <div class="card">
                    <div class="card-header">
                        <strong>CONTROLE</strong>
                    </div>
                    <div class="card-body">
                        @component('components.form-group', [
                            'inputs' => [
                                [
                                    'type' => 'select',
                                    'field' => 'tipo_controle_bloqueio',
                                    'label' => 'Controle de Bloqueio (Ativa o )',
                                    'required' => true,
                                    'items' => Array('Não Bloquear', 'Apenas Alertar', 'Bloquear'),
                                    'inputSize' => 4,
                                    'displayField' => 'tipo_controle_bloqueio',
                                    'keyField' => 'id',
                                    'liveSearch' => true,
                                    'inputValue' => 1,
                                ],
                                [
                                    'type' => 'number',
                                    'field' => 'media_ideal',
                                    'label' => 'Média Ideal',
                                    'required' => true,
                                    'inputSize' => 2,
                                    'inputValue' => 0,
                                ],
                                [
                                    'type' => 'number',
                                    'field' => 'variacao_negativa',
                                    'label' => 'Variação Negativa',
                                    'required' => true,
                                    'inputSize' => 2,
                                    'inputValue' => 0,
                                ],
                                [
                                    'type' => 'number',
                                    'field' => 'variacao_positiva',
                                    'label' => 'Variação Positiva',
                                    'required' => true,
                                    'inputSize' => 2,
                                    'inputValue' => 0,
                                ],
                            ],
                        ])
                        @endcomponent
                    </div>
                </div>
            @endsection
        @endcomponent
    </div>

    

@include('marca_veiculo.modal')
<meta name="csrf-token" content="{{ Session::token() }}">
<!-- Modal -->
@endsection



@push('document-ready')

$('#saveMarcaVeiculo').click(function() {
    var grupoNome = $('#marcaVeiculo').val();
   
    console.log(grupoNome);
    $.ajax({
        url: "{{ route('marca_veiculo.store') }}",
        method: 'POST',
        data: {
            marca_veiculo: grupoNome,
            _token: $('meta[name=csrf-token]').attr('content'),
             
        },
        
        success: function(response) {
        
            buscarMarcaVeiculo();
            $('#marcaVeiculoModal').modal('hide');
           
            {{-- $('#unidade_id').append('<option value="' + response.id + '">' + response
            //     .name + '</option>');
            // $('#unidade_id').val(response.id);
            --}}
        },
        error: function(xhr) {
            alert('Error: ' + xhr.responseJSON.message);
            
        }
    });
});

var buscarMarcaVeiculo = function() {
    var grupo = {};

   

    $.ajax({
        url: '{{ route("marca_veiculos.json") }}',
        type: 'POST',
        
        data: {
            marca_veiculo: grupo,
            _token: $('meta[name=csrf-token]').attr('content'),
             
        },
        dataType: 'JSON',
        cache: false,
        success: function (data) {
            console.log(data);
            if (data.length > 0) {
                $("#marca_veiculo_id")
                    .removeAttr('disabled')
                    .find('option')
                    .remove();
            } else {
                if ($('#marca_veiculo_id').val() == -1) {
                    $("#marca_veiculo_id").attr('disabled', 'disabled');
                }
            }

            $('#marca_veiculo_id').append($('<option>', { 
                    value: -1,
                    text : 'NADA SELECIONADO'
            }));
            $.each(data, function (i, item) {
                $('#marca_veiculo_id').append($('<option>', { 
                    value: item.id,
                    text : item.marca_veiculo 
                }));
            });
            
            @if(old('marca_veiculo_id'))
            $('#marca_veiculo_id').selectpicker('val', {{old('marca_veiculo_id')}});
            @endif

            $('.selectpicker').selectpicker('refresh');
        }

        
    });   
}
@endpush

