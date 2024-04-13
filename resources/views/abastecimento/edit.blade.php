@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Abastecimento', 
            'routeUrl' => route('abastecimento.update', $abastecimento->id), 
            'method' => 'PUT',
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
                            'sideBySide' => true,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'inputValue' => \DateTime::createFromFormat('Y-m-d H:i:s', $abastecimento->data_hora_abastecimento)->format('d/m/Y H:i:s'),
                            'disabled' => ($abastecimento->eh_afericao)
                        ],
                        [
                            'type' => 'select',
                            'field' => 'cliente_id',
                            'label' => 'Cliente',
                            'items' => $clientes,
                            'displayField' => 'nome_razao',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 7,
                            'indexSelected' => isset($cliente->id) ? $cliente->id : null,
                            'disabled' => ($abastecimento->eh_afericao)
                        ],
                        [
                            'type' => 'checkbox',
                            'field' => 'eh_afericao',
                            'label' => 'Aferição',
                            'dataWidth' => 65,
                            'inputSize' => 1,
                            'dataSize' => 'default',
                            'disabled' => true,
                            'inputValue' => $abastecimento->eh_afericao
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
                            'items' => null,
                            'inputSize' => 6,
                            'displayField' => 'placa',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'indexSelected' => $abastecimento->veiculo_id,
                            'disabled' => ($abastecimento->eh_afericao)
                        ],
                        
                        [
                            'type' => 'number',
                            'field' => 'km_veiculo',
                            'label' => ($abastecimento->veiculo_id) ? ($abastecimento->veiculo->modelo_veiculo->tipo_controle_veiculo_id == 1) ? 'KM do Veículo' : 'Horas trabalhadas' : 'Km do Veículo',
                            'inputSize' => 3,
                            'inputValue' => $abastecimento->km_veiculo,
                            'disabled' => ($abastecimento->eh_afericao)
                        ],
                        [
                            'type' => 'number',
                            'field' => 'media_atual',
                            'label' => 'Média Atual',
                            'inputSize' => 3,
                            'inputValue' => $abastecimento->media_veiculo,
                            'disabled' => ($abastecimento->eh_afericao)                            
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [   
                    'inputs' => [
                        [
                            'type' => 'number',
                            'field' => 'volume_abastecimento',
                            'label' => 'Quantidade',
                            'required' => true,
                            'inputSize' => 4,
                            'disabled' => true,
                            'inputValue' => $abastecimento->volume_abastecimento,
                            'disabled' => ($abastecimento->eh_afericao)                           
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor_litro',
                            'label' => 'Valor Unitário',
                            'required' => true,
                            'inputSize' => 4,
                            'inputValue' => $abastecimento->valor_litro,
                            'disabled' => ($abastecimento->eh_afericao)                           
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor_abastecimento',
                            'label' => 'Valor Total',
                            'required' => true,
                            'inputSize' => 4,
                            'readOnly' => true,
                            'inputValue' => $abastecimento->valor_abastecimento,
                            'disabled' => ($abastecimento->eh_afericao)                             
                        ],
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
                            'defaultNone' => true,
                            'indexSelected' => $abastecimento->atendente_id,
                            'disabled' => ($abastecimento->eh_afericao)
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
                            'indexSelected' => $abastecimento->motorista_id,
                            'disabled' => ($abastecimento->eh_afericao)
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
                                    'disabled' => true,
                                    'indexSelected' => $abastecimento->bico_id,
                                    'liveSearch' => true,
                                ],
                                [
                                    'type' => 'number',
                                    'field' => 'encerrante_inicial',
                                    'label' => 'Encerrante Inicial',
                                    'required' => true,
                                    'inputSize' => 4,
                                    'disabled' => true,
                                    'inputValue' => $abastecimento->encerrante_inicial                    
                                ],
                                [
                                    'type' => 'number',
                                    'field' => 'encerrante_final',
                                    'label' => 'Encerrante Final',
                                    'required' => true,
                                    'inputSize' => 4,
                                    'disabled' => true,  
                                    'inputValue' => $abastecimento->encerrante_final             
                                ]
                            ]
                        ])
                        @endcomponent
                    </div>
                </div>
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
                                    'inputValue' => nl2br($abastecimento->obs_abastecimento),
                                    'disabled' => ($abastecimento->eh_afericao)
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
    var BuscarVeiculo = function() {

    if (Number($('#cliente_id').val()) == 0) {
        return
    } 

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
            
            @if(old('veiculo_id'))
            $('#veiculo_id').selectpicker('val', {{old('veiculo_id')}});
            @else                        
            $('#veiculo_id').selectpicker('val', {{$abastecimento->veiculo_id}});
            @endif

            $('.selectpicker').selectpicker('refresh');

        },
        error: function (data) {
            console.log(data);
        }
    });
}

var CalcularKmMedia = function() {
    var abastecimento = {};

    abastecimento.id = {{$abastecimento->id}};
    abastecimento.veiculo_id = $('#veiculo_id').val();
    abastecimento._token = $('input[name="_token"]').val();

    //console.log(abastecimento);
    $.ajax({
        url: '{{ route("ultimo_abastecimento.json") }}',
        type: 'POST',
        data: abastecimento,
        dataType: 'JSON',
        cache: false,
        success: function (abastecimento) {
            //console.log('retorno_json=' + abastecimento);
            //console.log(abastecimento.veiculo.modelo_veiculo.tipo_controle_veiculo_id);

            ObterMediaKmVeiculo(abastecimento.km_veiculo, abastecimento.veiculo.modelo_veiculo.tipo_controle_veiculo_id);
        },
        error: function (abastecimento) {
            console.log(abastecimento);
        }
    });
}

BuscarVeiculo();
$('#cliente_id').on('changed.bs.select', BuscarVeiculo);
$('#cliente_id').on('hide.bs.select', BuscarVeiculo);
$('#veiculo_id').on('change.bs.select', CalcularKmMedia);


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

function ObterMediaKmVeiculo(kmAnterior, tipoControle) {
    //var kmAnterior = BuscarUltimoAbastecimento();
    var kmAtual = $('#km_veiculo').val();
    var qtdAbastecimento = $('#volume_abastecimento').val();
    //km percorridos
    if (tipoControle == 1) {
        var mediaCalculada = ((kmAtual - kmAnterior) / qtdAbastecimento).toFixed(3);
    } else {
        //horas trabalhadas
        var mediaCalculada = (qtdAbastecimento / (kmAtual - kmAnterior)).toFixed(3);
    }
    

    //console.log('kmAnterior = ' + kmAnterior);
    //console.log('kmAtual = ' + kmAtual);
    //console.log('qtdAbastecimento = ' + qtdAbastecimento);
    //console.log('kmPercorrido = ' + (kmAtual - kmAnterior));
    //console.log('mediaCalculada = ' + mediaCalculada);


    $('#media_atual').val(mediaCalculada);
}

$('#volume_abastecimento').keyup(CalcValorAbastecimento);

$('#valor_litro').keyup(CalcValorAbastecimento);           

$('#km_veiculo').blur(CalcularKmMedia);

$('#volume_abastecimento').blur(CalcularKmMedia);

$('#veiculo_id').on('changed.bs.select', (e) => {
    if ($('#'+e.target.id).find('option:selected').data('tipo-controle-veiculo') == 1) {
        $('#label__km_veiculo').html('KM do Veículo');
    } else {
        $('#label__km_veiculo').html('Horas trabalhadas');
    }
});
@endpush
