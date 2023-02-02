@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Adicionar Cédito', 
            'routeUrl' => route('credito.store'), 
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
                        
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'produto_id',
                            'label' => 'Produtos',
                            'required' => false,
                            'items' => $produtos,
                            'inputSize' => 6,
                            'displayField' => 'produtos',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true
                        ],
                        
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'observacao',
                            'label' => 'Observação',
                            'required' => true,
                            'inputSize' => 3,
                            'css' => 'text-uppercase'
                        ],
                        [
                            'type' => 'text',
                            'field' => 'saldo_reais',
                            'label' => 'Saldo (moeda)',
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'text',
                            'field' => 'saldo_qtd',
                            'label' => 'Saldo (volume)',
                            'inputSize' => 3
                        ]
                        
                    ]
                ])
                @endcomponent
               
                
            @endsection
        @endcomponent
    </div>
@endsection

@push('document-ready')
   
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
