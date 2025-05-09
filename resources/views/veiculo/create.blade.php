@extends('layouts.app')


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
                            'inputSize' => 4,
                            'displayField' => 'grupo_veiculo',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true
                        ],
                        [
                            'type' => 'input-btn',
                            'field' => 'grupo_id',
                            'label' => 'Novo',
                            'required' => true,
                            'inputSize' => 1,
                            'displayField' => 'grupo',
                            'keyField' => 'id',
                            'comando' => 'grupoVeiculoModal',
                            'action' => 'create',
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
                            'inputSize' => 4,
                            'displayField' => 'marca_veiculo',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'indexSelected' => isset($veiculo->marca_veiculo_id) ? $veiculo->marca_veiculo_id : ''
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
                        [
                            'type' => 'select',
                            'field' => 'modelo_veiculo_id',
                            'label' => 'Modelo',
                            'required' => true,
                            'items' => null,
                            'disabled' => true,
                            'inputSize' => 4,
                            'displayField' => 'modelo_veiculo',
                            'liveSearch' => true,
                            'keyField' => 'id'
                        ],
                        [
                            'type' => 'input-btn',
                            'field' => 'modelo_id',
                            'label' => 'Novo',
                            'required' => true,
                            'inputSize' => 1,
                            'displayField' => 'modelo',
                            'keyField' => 'id',
                            'action' => 'create',
                            'comando' => 'modeloVeiculoModal',
                            
                            
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
                            'inputSize' => 2,
                            'inputValue' => '0'
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
                            'inputSize' => 2,
                            'inputValue' => '0'
                        ],
                        [
                            'type' => 'number',
                            'field' => 'media_atual',
                            'label' => 'Média Atual',
                            'inputSize' => 2
                        ],
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
        @include('veiculo.modal')
        @include('grupo_veiculo.modal')
        @include('modelo_veiculo.modal')
        @include('marca_veiculo.modal')    
        @include('components.email-modal', [
  'referenciaId' => 1,
  'destinatario' => '$ordemServico->cliente->email'
])
    
<meta name="csrf-token" content="{{ Session::token() }}">
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

    
    $('#saveGrupoVeiculo').click(function() {
        var grupoNome = $('#grupoVeiculo').val();
       
        console.log(grupoNome);
        $.ajax({
            url: "{{ route('grupo_veiculo.store') }}",
            method: 'POST',
            data: {
                grupo_veiculo: grupoNome,
                _token: $('meta[name=csrf-token]').attr('content'),
                 
            },
            
            success: function(response) {
            
                buscarGrupoVeiculo();
                $('#grupoVeiculoModal').modal('hide');
               
                {{-- $('#unidade_id').append('<option value="' + response.id + '">' + response
                //     .name + '</option>');
                // $('#unidade_id').val(response.id);
                --}}
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = Object.values(errors).map(error => error.join(' ')).join('\n');
                    alert(errorMessage);
                } else {
                    alert("Erro ao cadastrar o produto");
                }
            }
        });
    });

    var buscarGrupoVeiculo = function() {
        var grupo = {};

       

        $.ajax({
            url: '{{ route("grupo_veiculos.json") }}',
            type: 'POST',
            
            data: {
                grupo_veiculo: grupo,
                _token: $('meta[name=csrf-token]').attr('content'),
                 
            },
            dataType: 'JSON',
            cache: false,
            success: function (data) {
                console.log(data);
                if (data.length > 0) {
                    $("#grupo_veiculo_id")
                        .removeAttr('disabled')
                        .find('option')
                        .remove();
                } else {
                    if ($('#grupo_veiculo_id').val() == -1) {
                        $("#grupo_veiculo_id").attr('disabled', 'disabled');
                    }
                }

                $('#grupo_veiculo_id').append($('<option>', { 
                        value: -1,
                        text : 'NADA SELECIONADO'
                }));
                $.each(data, function (i, item) {
                    $('#grupo_veiculo_id').append($('<option>', { 
                        value: item.id,
                        text : item.grupo_veiculo 
                    }));
                });
                
                @if(old('grupo_veiculo_id'))
                $('#grupo_veiculo_id').selectpicker('val', {{old('grupo_veiculo_id')}});
                @endif

                $('.selectpicker').selectpicker('refresh');
            }

            
        });   
    }

    $('#saveModeloVeiculo').click(function() {
        var modeloNome = $('#modelo_veiculo').val();
        var modeloMarca = $('#modal_marca_veiculo_id').val();
        var modeloCapacidade = $('#capacidade_tanque').val();
        var modeloTipoControle = $('#tipo_controle_veiculo_id').val();
        var modeloBloqueio = $('#tipo_controle_bloqueio').val();
        var modeloMediaIdeal = $('#media_ideal').val();
        var modeloVariacaoNegativa = $('#variacao_negativa').val();
        var modeloVariacaoPositiva = $('#variacao_positiva').val();
        
       
       
        
        $.ajax({
            url: "{{ route('modelo_veiculo.store') }}",
            method: 'POST',
            data: {
                modelo_veiculo: modeloNome,
                marca_veiculo_id: modeloMarca,
                capacidade_tanque: modeloCapacidade,
                tipo_controle_veiculo_id: modeloTipoControle,
                tipo_controle_bloqueio: modeloBloqueio,
                media_ideal: modeloMediaIdeal,
                variacao_negativa: modeloVariacaoNegativa,
                variacao_positiva:modeloVariacaoPositiva,
                _token: $('meta[name=csrf-token]').attr('content'),
                 
            },
            
            success: function(response) {
            
                buscarModeloVeiculos();
                $('#modeloVeiculoModal').modal('hide');
               
                {{-- $('#unidade_id').append('<option value="' + response.id + '">' + response
                //     .name + '</option>');
                // $('#unidade_id').val(response.id);
                --}}
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = Object.values(errors).map(error => error.join(' ')).join('\n');
                    alert(errorMessage);
                } else {
                    alert("Erro ao cadastrar o produto");
                }
            }


        });
    });

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
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = Object.values(errors).map(error => error.join(' ')).join('\n');
                    alert(errorMessage);
                } else {
                    alert("Erro ao cadastrar o produto");
                }
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
                        $("#modal_marca_veiculo_id")
                        .removeAttr('disabled')
                        .find('option')
                        .remove();
                        
                } else {
                    if ($('#marca_veiculo_id').val() == -1) {
                        $("#marca_veiculo_id").attr('disabled', 'disabled');
                    }
                    if ($('#modal_marca_veiculo_id').val() == -1) {
                        $("#modal_marca_veiculo_id").attr('disabled', 'disabled');
                    }
                }

                $('#marca_veiculo_id').append($('<option>', { 
                        value: -1,
                        text : 'NADA SELECIONADO'
                }));
                $('#modal_marca_veiculo_id').append($('<option>', { 
                    value: -1,
                    text : 'NADA SELECIONADO'
            }));
                $.each(data, function (i, item) {
                    $('#marca_veiculo_id').append($('<option>', { 
                        value: item.id,
                        text : item.marca_veiculo 
                    }));
                });
                $.each(data, function (i, item) {
                    $('#modal_marca_veiculo_id').append($('<option>', { 
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
