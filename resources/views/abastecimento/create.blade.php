@extends('layouts.app')


@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Novo Abastecimento', 
            'routeUrl' => route('abastecimento.store'), 
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
                            'field' => 'data_hora_abastecimento',
                            'label' => 'Data/Hora',
                            'required' => true,
                            'inputSize' => 4,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'sideBySide' => true,
                            'inputValue' => date('d/m/Y H:i'),
                            
                            
                        ],
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
                            'type' => 'checkbox',
                            'field' => 'eh_afericao',
                            'label' => 'Aferição',
                            'dataWidth' => 65,
                            'inputSize' => 1,
                            'dataSize' => 'default',
                            'disabled' => false,
                            'permission' => 'cadastrar-afericao'
                        ]
                    ]
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
                            'inputSize' => 8,
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
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'atendente_id',
                            'label' => 'Atendente',
                            'required' => true,
                            'items' => $atendentes,
                            'inputSize' => 6,
                            'displayField' => 'nome_atendente',
                            'liveSearch' => true,
                            'keyField' => 'id',
                           
                        ],
                        [
                            'type' => 'select',
                            'field' => 'motorista_id',
                            'label' => 'Motorista',
                            'required' => true,
                            'items' => $motoristas,
                            'inputSize' => 6,
                            'displayField' => 'nome',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                           
                        ]
                        ,
                        [
                            'type' => 'select',
                            'field' => 'posto_abastecimentos_id',
                            'label' => 'Posto Abastecimento',
                            'required' => true,
                            'items' => $postos,
                            'inputSize' => 6,
                            'displayField' => 'nome',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            //'defaultNone' => true,
                           
                        ]
                    ]
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
                                [
                                    'type' => 'number',
                                    'field' => 'encerrante_inicial',
                                    'label' => 'Encerrante Inicial',
                                    'required' => true,
                                    'inputSize' => 4,   
                                    'readOnly' => true                       
                                ],
                                [
                                    'type' => 'number',
                                    'field' => 'encerrante_final',
                                    'label' => 'Encerrante Final',
                                    'required' => true,
                                    'inputSize' => 4, 
                                    'readOnly' => true            
                                ]
                            ]
                        ])
                        @endcomponent
                    </div>
                </div>
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'combustivel_descricao',
                            'label' => 'Combustível',
                            'inputSize' => 6,
                            'readOnly' => true
                        ],
                        [
                            'type' => 'number',
                            'field' => 'volume_abastecimento',
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
                            'field' => 'valor_abastecimento',
                            'label' => 'Valor Total',
                            'required' => true,
                            'inputSize' => 2,
                            'readOnly' => true,
                        ]
                    ]
                ])
                @endcomponent
                <div class="card">
                    <div class="card-header">
                        <strong>OBSERVAÇÕES</strong>
                    </div>
                    <div class="card-body">
                        @component('components.form-group', [
                            'inputs' => [
                                [
                                    'type' => 'textarea',
                                    'field' => 'obs_abastecimento',
                                    'label' => false,
                                ]
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
function CalcValorAbastecimento() {
            var volume, valor_unitario = 0;
            volume = parseFloat($('#volume_abastecimento').val().replace(',', '.'));
            valor_unitario = parseFloat($('#valor_litro').val().replace(',', '.'));
            if ((volume > 0) && (valor_unitario > 0)) {
                $('#valor_abastecimento').val(volume * valor_unitario);
            } else {
                $('#valor_abastecimento').val(0);
            }
        }

        function CalcularEncerranteFinal() {
            var encIni, encFin, qtdAbast;
            encIni = parseFloat($('#encerrante_inicial').val().replace(',', '.'));
            qtdAbast = parseFloat($('#volume_abastecimento').val().replace(',', '.'));

            if (qtdAbast > 0) {
                $('#encerrante_final').val(encIni + qtdAbast);
            }

        }

        var buscarDadosBico = function() {  
            var bico = {};

            bico.id = $('#bico_id').val();
            bico._token = $('input[name="_token"]').val();

            $.ajax({
                url: '{{ route("bico.json") }}',
                type: 'POST',
                data: bico,
                dataType: 'JSON',
                cache: false,
                success: function (data) {
                    $("#encerrante_inicial").val(data.encerrante);
                    $("#combustivel_descricao").val(data.tanque.combustivel.descricao);
                    $("#valor_litro").val(data.tanque.combustivel.valor);
                    $("#volume_abastecimento").focus();
                    let cliente_id = $('#cliente_id').val();
                    let combustivel_id = data.tanque.combustivel.id;
                    if (cliente_id && combustivel_id) {
                        
                        
                        
                        $.ajax({
                            url: '{{ route("preco-cliente-item.valor") }}', // você vai criar essa rota
                            type: 'POST',
                            data: {
                                _token: $('input[name="_token"]').val(),
                                cliente_id: cliente_id,
                                combustivel_id: combustivel_id
                            },
                            dataType: 'JSON',
                            success: function(res) {
                                if (res.valor_unitario !== undefined) {
                                    $("#valor_litro").val(res.valor_unitario);
                                } else {
                                    $("#valor_litro").val(data.tanque.combustivel.valor); // fallback
                                }
                                $('#volume_abastecimento').focus();
                            }
                        });
                    }
                   

                   
                },
                error: function (data) {
                }
            });
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
            CalcularEncerranteFinal();
        });
        $('#volume_abastecimento').on('blur', () => {
            CalcValorAbastecimento();
            CalcularEncerranteFinal();
        });

        $('#valor_litro').on('keyup', () => {
            CalcValorAbastecimento();
        });

        $('#valor_litro').on('blur', () => {
            CalcValorAbastecimento();
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
@endpush
