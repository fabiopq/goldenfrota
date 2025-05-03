@extends('layouts.app')

@section('content')
    <div id="ordem_servico">
        <div class="card m-0 border-0">
            @component('components.form', [
                'title' => 'Nova Ordem de Serviço',
                'routeUrl' => route('ordem_servico.store'),
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
                                'type' => 'datetime',
                                'field' => 'created_at',
                                'label' => 'Data/Hora',
                                'required' => true,
                                'inputSize' => 2,
                                'dateTimeFormat' => 'DD/MM/YYYY HH:mm',
                                'sideBySide' => true,
                                'inputValue' => date('d/m/Y H:i'),
                            ],
                    
                            [
                                'type' => 'select',
                                'field' => 'ordem_servico_status_id',
                                'label' => 'Status',
                                'inputSize' => 2,
                                'items' => $ordemServicoStatus,
                                'displayField' => 'os_status',
                                'keyField' => 'id',
                            ],
                        ],
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
                                'inputSize' => 5,
                                'displayField' => 'nome_razao',
                                'keyField' => 'id',
                                'liveSearch' => true,
                                'defaultNone' => false,
                            ],
                            [
                                'type' => 'select',
                                'field' => 'veiculo_id',
                                'label' => 'Veiculo',
                                'required' => true,
                                'items' => null,
                                'inputSize' => 3,
                                'displayField' => 'placa',
                                'keyField' => 'id',
                                'liveSearch' => true,
                                'defaultNone' => true,
                            ],
                            [
                                'type' => 'number',
                                'field' => 'km_veiculo',
                                'label' => 'KM Atual',
                                'required' => true,
                                'inputSize' => 2,
                                'inputValue' => 0,
                            ],
                        ],
                    ])
                    @endcomponent

                    <ordem-servico :servicos-data="{{ json_encode($servicos) }}"
                        :old-servicos-data="{{ json_encode(old('servicos')) }}" v-bind:estoques="{{ json_encode($estoques) }}"
                        :old-estoque-id="{{ json_encode(old('estoque_id')) }}"
                        :old-produtos-data="{{ json_encode(old('produtos')) }}">
                    </ordem-servico>
                    @component('components.form-group', [
                        'inputs' => [
                            [
                                'type' => 'textarea',
                                'field' => 'defeito',
                                'label' => 'Problema Relatado',
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
                            ],
                        ],
                    ])
                    @endcomponent
                    
                @endsection
            @endcomponent
        </div>
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
        });
    </script>

@endpush
@endsection
