@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Nova Ordem de Serviço', 
            'routeUrl' => route('ordem_servico.store'), 
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
                            'inputSize' => 6,
                            'displayField' => 'nome_razao',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'defaultNone' => true
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
                        ],
                        [
                            'type' => 'number',
                            'field' => 'km_veiculo',
                            'label' => 'KM Atual',
                            'required' => true,
                            'inputSize' => 3
                        ]
                    ]
                ])
                @endcomponent
                <div id="os_servicos" class="{{ $errors->has('os_servicos') ? ' has-error' : '' }}">
                    <ordem_servico_servico :servicos-data="{{ json_encode($servicos) }}" :old-data="{{ json_encode(old('servicos')) }}"></ordem_servico_servico>
                    @if ($errors->has('os_servicos'))
                        <span class="help-block">
                            <strong>{{ $errors->first('os_servicos') }}</strong>
                        </span>
                    @endif
                    <ordem_servico_produto v-bind:estoques="{{ json_encode($estoques) }}" :estoque-error="{{ $errors->has('estoque_id') ? json_encode(['msg' => $errors->first('estoque_id')]) : 'null' }}" :old-estoque-id="{{ json_encode(['estoque_id' => old('estoque_id')]) }}" {{--  :produtos-data="{{ json_encode($produtos) }}"  --}} :old-data="{{ json_encode(old('items')) }}"></ordem_servico_produto>
                </div>
                
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'textarea',
                            'field' => 'obs',
                            'label' => 'Observações'
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'number',
                            'field' => 'valor_total',
                            'label' => 'Valor Total',
                            'inputValue' => 10
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@push('bottom-scripts')
    <script src="{{ mix('js/osservico.js') }}"></script>

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
                        $("#veiculo_id")
                            .removeAttr('disabled')
                            .find('option')
                            .remove();
                        
                        $.each(data, function (i, item) {
                            $('#veiculo_id').append($('<option>', { 
                                value: item.id,
                                text : item.placa 
                            }));
                        });

                        @if(old('veiculo_id'))
                        $('#veiculo_id').selectpicker('val', {{old('veiculo_id')}});
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