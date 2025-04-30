@extends('layouts.app')


@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Nova Autorizacao',
            'routeUrl' => route('autorizacao.update', $autorizacao->id),
            'method' => 'PUT',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'check'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'times'],
            ],
        ])
            @section('formFields')
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'checkbox',
                            'field' => 'cliente_id',
                            'label' => 'Encerrado',
                            'required' => true,
                            'autofocus' => true,
                            'displayField' => 'nome_razao',
                            'liveSearch' => false,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'dataSize' => 'mini'
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
                            'inputSize' => 7,
                            'indexSelected' => isset($cliente->id) ? $cliente->id : null,
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
                            'indexSelected' => $autorizacao->veiculo_id,
                        ],
                        [
                            'type' => 'number',
                            'field' => 'km_veiculo',
                            'label' => 'KM do Veículo',
                            'required' => true,
                            'inputSize' => 4,
                            'inputValue' => $autorizacao->km_veiculo,
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
                                    'indexSelected' => $autorizacao->bico_id,
                                    'liveSearch' => true,
                                ],
                            ],
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
    url: '{{ route('veiculos.json') }}',
    type: 'POST',
    data: cliente,
    dataType: 'JSON',
    cache: false,
    success: function (data) {
    $("#veiculo_id")
    .removeAttr('disabled')
    .find('option')
    .remove();


    $('#veiculo_id').append($('<option>', {value: '', text: 'Nada selecionado'}));

        $.each(data, function (i, item) {
        $('#veiculo_id').append($('
    <option>', {
        value: item.id,
        'data-tipo-controle-veiculo': item.modelo_veiculo.tipo_controle_veiculo.id,
        text : item.placa + ' - ' + item.modelo_veiculo.marca_veiculo.marca_veiculo + ' ' +
        item.modelo_veiculo.modelo_veiculo
        }));
        });

        @if (old('veiculo_id'))
            $('#veiculo_id').selectpicker('val', {{ old('veiculo_id') }});
        @else
            $('#veiculo_id').selectpicker('val', {{ $autorizacao->veiculo_id }});
        @endif

        $('.selectpicker').selectpicker('refresh');

        },
        error: function (data) {
        console.log(data);
        }
        });
        }


        BuscarVeiculo();
        $('#cliente_id').on('changed.bs.select', BuscarVeiculo);
        $('#cliente_id').on('hide.bs.select', BuscarVeiculo);



        $('#veiculo_id').on('changed.bs.select', (e) => {
        if ($('#'+e.target.id).find('option:selected').data('tipo-controle-veiculo') == 1) {
        $('#label__km_veiculo').html('KM do Veículo');
        } else {
        $('#label__km_veiculo').html('Horas trabalhadas');
        }
        });
    @endpush
