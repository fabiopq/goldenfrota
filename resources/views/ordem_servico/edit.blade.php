@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Ordem de Servico',
            'routeUrl' => route('ordem_servico.update', $ordemServico->id),
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
                            'type' => 'datetime',
                            'field' => 'created_at',
                            'label' => 'Data/Hora',
                            'required' => true,
                            'inputSize' => 2,
                            'sideBySide' => true,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm',
                            'inputValue' => \DateTime::createFromFormat('Y-m-d H:i:s', $ordemServico->created_at)->format(
                                'd/m/Y H:i:s'),
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ordem_servico_status_id',
                            'label' => 'Status',
                            'inputSize' => 2,
                            'items' => $ordemServicoStatus,
                            'displayField' => 'os_status',
                            'keyField' => 'id',
                            'disabled' => !$ordemServico->ordem_servico_status->em_aberto,
                            'indexSelected' => $ordemServico->ordem_servico_status_id,
                        ],
                        [
                            'type' => 'select',
                            'field' => 'cliente_id',
                            'label' => 'Cliente',
                            'items' => $ordemServico->cliente->get(),
                            'inputSize' => 5,
                            'displayField' => 'nome_razao',
                            'keyField' => 'id',
                            'disabled' => false,
                            'liveSearch' => true,
                            'indexSelected' => isset($ordemServico->cliente_id) ? $ordemServico->cliente_id : 0,
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
                            'required' => false,
                            'items' => $veiculos,
                            'displayField' => 'veiculo',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 3,
                            'indexSelected' => $ordemServico->veiculo_id,
                        ],
                
                        [
                            'type' => 'number',
                            'field' => 'km_veiculo',
                            'label' => 'KM Atual',
                            'required' => true,
                            'inputSize' => 2,
                            'inputValue' => $ordemServico->km_veiculo,
                        ],
                    ],
                ])
                @endcomponent
                <div id="ordem_servico">
                    @if ($ordemServico->estoque_id)
                        <ordem-servico :servicos-data="{{ json_encode($servicos) }}"
                            :old-servicos-data="{{ old('servicos') ? json_encode(old('servicos')) : json_encode($ordemServico->servicos) }}"
                            v-bind:estoques="{{ json_encode($estoques) }}"
                            :old-estoque-id="{{ old('estoque_id') ? json_encode(old('estoque_id')) : $ordemServico->estoque_id }}"
                            :old-produtos-data="{{ old('produtos') ? json_encode(old('produtos')) : json_encode($ordemServico->produtos) }}">
                        </ordem-servico>
                    @else
                        <ordem-servico :servicos-data="{{ json_encode($servicos) }}"
                            :old-servicos-data="{{ json_encode(old('servicos')) }}" v-bind:estoques="{{ json_encode($estoques) }}"
                            :old-estoque-id="{{ json_encode(old('estoque_id')) }}"
                            :old-produtos-data="{{ json_encode(old('produtos')) }}">
                        </ordem-servico>
                    @endif


                </div>


                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'textarea',
                            'field' => 'defeito',
                            'label' => 'Problema Relatado',
                            'inputValue' => $ordemServico->defeito,
                        ],
                    ],
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'textarea',
                            'field' => 'obs',
                            'label' => 'Atividade Realizada',
                            'inputValue' => $ordemServico->obs,
                        ],
                    ],
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>

    @push('bottom-scripts')
        <script src="{{ mix('js/os.js') }}"></script>

        <script>
            $(document).ready(function() {
                var buscarVeiculos = function() {
                    var cliente = {};

                    cliente.id = $('#cliente_id').val();
                    cliente._token = $('input[name="_token"]').val();

                    $.ajax({
                        url: '{{ route('veiculos.json') }}',
                        type: 'POST',
                        data: cliente,
                        dataType: 'JSON',
                        cache: false,
                        success: function(data) {
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

                            @if (old('veiculo_id'))
                                $('#veiculo_id').selectpicker('val', {{ old('veiculo_id') }});
                            @else
                                $('#veiculo_id').selectpicker('val', {{ $ordemServico->veiculo_id }});
                            @endif

                            $('.selectpicker').selectpicker('refresh');
                        }
                    });
                }
                $('#cliente_id').on('changed.bs.select', buscarVeiculos);

                if ($('#cliente_id').val()) {
                    buscarVeiculos();
                }
            });
        </script>
    @endpush
@endsection
