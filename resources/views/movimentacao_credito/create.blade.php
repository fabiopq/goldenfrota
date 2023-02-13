@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Movimentar Crédito', 
            'routeUrl' => route('movimentacao_credito.store'), 
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
                            'type' => 'datetime',
                            'field' => 'data_movimentacao',
                            'label' => 'Data',
                            'required' => true,
                            'inputSize' => 2,
                            'inputValue' => date('d/m/Y H:i:s')
                        ],
                        [
                            'type' => 'number',
                            'field' => 'saldo',
                            'label' => 'Saldo Atual',
                            'required' => true,
                            'inputSize' => 2,
                            'readOnly' => true  
                                                       
                        ],
                        
                    ]
                ])
            @endcomponent
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
                            'inputSize' => 7 
                        ],
                        [
                            'type' => 'select',
                            'field' => 'tipo_movimentacao_credito_id',
                            'label' => 'Tipo Movimentação',
                            'required' => true,
                            'items' => $tipomovimentacao,
                            'autofocus' => true,
                            'displayField' => 'tipo_movimentacao_credito',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => false,
                            'inputSize' => 3 
                        ],
                                               
                        
                        
                    ]
                ])
                @endcomponent

                @component('components.form-group', [
                    'inputs' => [
                        
                        [
                            'type' => 'select',
                            'field' => 'combustivel_id',
                            'label' => 'Combustivel',
                            'required' => true,
                            'items' => $combustiveis,
                            'autofocus' => true,
                            'displayField' => 'descricao',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 5 
                        ],
                        [
                            'type' => 'number',
                            'field' => 'quantidade_movimentada',
                            'label' => 'Quantidade',
                            'required' => true,
                            'inputSize' => 2                            
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor_litro',
                            'label' => 'Valor Unitário',
                            'required' => true,
                            'inputSize' => 2                            
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor_total',
                            'label' => 'Valor Total',
                            'required' => true,
                            'inputSize' => 2                            
                        ],
                        
                    ]
                ])
            @endcomponent
            @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'textarea',
                            'field' => 'observacao',
                            'label' => 'Observações'
                        ]
                    ]
                ])
            @endcomponent

                
               
            @endsection
        @endcomponent
    </div>

@push('document-ready')
        function CalcValorAbastecimento() {
            var volume, valor_unitario = 0;
            volume = parseFloat($('#quantidade_movimentada').val().replace(',', '.'));
            valor_unitario = parseFloat($('#valor_litro').val().replace(',', '.'));
            if ((volume > 0) && (valor_unitario > 0)) {
                $('#valor_total').val(volume * valor_unitario);
            } else {
                $('#valor_total').val(0);
            }
        }

        function CalcLitragem() {
            var total, valor_unitario = 0;
            total = parseFloat($('#valor_total').val().replace(',', '.'));
            valor_unitario = parseFloat($('#valor_litro').val().replace(',', '.'));
            if ((total > 0) && (valor_unitario > 0)) {
                $('#quantidade_movimentada').val(total / valor_unitario);
            } else {
                $('#quantidade_movimentada').val(0);
            }
        }

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

                    $('#veiculo_id').append($('<option>', {value: null, text: 'Nada selecionado'}));

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
        $('#volume_abastecimento').on('keyup', () => {
            CalcValorAbastecimento(); 
            
        });
        $('#volume_abastecimento').on('blur', () => {
            CalcValorAbastecimento();
            
        });

        $('#valor_litro').on('keyup', () => {
            CalcValorAbastecimento();
        });

        $('#valor_litro').on('blur', () => {
            CalcValorAbastecimento();
        });

        $('#valor_total').on('keyup', () => {
            CalcLitragem();
        });

        $('#valor_total').on('blur', () => {
            CalcLitragem();
        });
        

        $('#cliente_id').on('changed.bs.select', buscarVeiculos);
        $('#bico_id').on('changed.bs.select', buscarDadosBico);

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

        var buscarDadosBico = function() {  
            var combustivel = {};

            combustivel.id = $('#combustivel_id').val();
            combustivel._token = $('input[name="_token"]').val();

            $.ajax({
                url: '{{ route("combustivel.json") }}',
                type: 'POST',
                data: combustivel,
                dataType: 'JSON',
                cache: false,
                success: function (data) {
                    
                    $("#valor_litro").val(data.valor);
                    $("#quantidade_movimentada").focus();


                    $('.selectpicker').selectpicker('refresh');
                },
                error: function (data) {
                }
            });
        }

        var buscarSaldoCredito = function() {  
            var cliente = {};

            cliente.id = $('#cliente_id').val();
            cliente._token = $('input[name="_token"]').val();

            $.ajax({
                url: '{{ route("saldocredito.json") }}',
                type: 'POST',
                data: cliente,
                dataType: 'JSON',
                cache: false,
                success: function (data) {
                    console.log(data);
                    
                    $("#saldo").val(data);
                    $("#quantidade_movimentada").focus();
                    
                                        
                    $('.selectpicker').selectpicker('refresh');
                },
                error: function (data) {
                   
                }
            });
        }


        $('#combustivel_id').on('changed.bs.select', buscarDadosBico);

        $('#cliente_id').on('changed.bs.select', buscarSaldoCredito);
@endpush
@endsection