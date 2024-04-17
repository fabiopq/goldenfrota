@extends('layouts.app')
<form action="{{ route('veiculo.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <button type="submit">Upload</button>
</form>

@section('content')

    <div class="card m-0 border-0">
        
        @component('components.form', [
            'title' => 'Novo Veículo', 
            'routeUrl' => route('veiculo.store'), 
            'method' => 'POST',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'check'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'times']
                ]
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
                            'defaultNone' => true,
                            'inputSize' => 8
                        ],
                        
                        
                        [
                            'type' => 'select',
                            'field' => 'departamento_id',
                            'label' => 'Departamento',
                            'required' => true,
                            'items' => null,
                            'displayField' => 'departamento',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 4,
                            'disabled' => true,
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'grupo_veiculo_id',
                            'label' => 'Grupo de Veículos',
                            'required' => true,
                            'items' => $grupoVeiculos,
                            'inputSize' => 6,
                            'displayField' => 'grupo_veiculo',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true
                        ],
                        [
                            'type' => 'text',
                            'field' => 'placa',
                            'label' => 'Placa',
                            'required' => true,
                            'inputSize' => 3,
                            'css' => 'text-uppercase'
                        ],
                        [
                            'type' => 'text',
                            'field' => 'tag',
                            'label' => 'TAG',
                            'inputSize' => 3
                        ]
                    ]
                ])
                @endcomponent
               
               
                        
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'marca_veiculo_id',
                            'label' => 'Marca',
                            'required' => true,
                            'items' => $marcaVeiculos,
                            'inputSize' => 5,
                            'displayField' => 'marca_veiculo',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'indexSelected' => isset($veiculo->marca_veiculo_id) ? $veiculo->marca_veiculo_id : ''
                        ],
                        [
                            'type' => 'select',
                            'field' => 'modelo_veiculo_id',
                            'label' => 'Modelo',
                            'required' => true,
                            'items' => null,
                            'disabled' => true,
                            'inputSize' => 5,
                            'displayField' => 'modelo_veiculo',
                            'liveSearch' => true,
                            'keyField' => 'id'
                        ],
                        [
                            'type' => 'number',
                            'field' => 'ano',
                            'label' => 'Ano',
                            'inputSize' => 2
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'renavam',
                            'label' => 'Renavam',
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'text',
                            'field' => 'chassi',
                            'label' => 'Chassi',
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'number',
                            'field' => 'hodometro',
                            'label' => 'Km',
                            'inputSize' => 2
                        ],
                        
                        [
                            'type' => 'select',
                            'field' => 'hodometro_decimal',
                            'label' => 'Km Decimal',
                            'inputSize' => 1,
                            'indexSelected' => 1,
                            'items' => ['Não', 'Sim'],
                        ],
                        [
                            'type' => 'number',
                            'field' => 'media_minima',
                            'label' => 'Média Mínima',
                            'inputSize' => 3
                        ],
                    ]
                ])
                @endcomponent
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
            url: '{{ route("departamentos.json") }}',
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
                
                @if(old('departamento_id'))
                $('#departamento_id').selectpicker('val', {{old('departamento_id')}});
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
            url: '{{ route("modelo_veiculos.json") }}',
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
                    $('#modelo_veiculo_id').append($('<option>', { 
                        value: item.id,
                        text : item.modelo_veiculo 
                    }));
                });

                @if(old('modelo_veiculo_id'))
                $('#modelo_veiculo_id').selectpicker('val', {{old('modelo_veiculo_id')}});
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
