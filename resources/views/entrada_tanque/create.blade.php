@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Nova Entrada de Combustível', 
            'routeUrl' => route('entrada_tanque.store'), 
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
                            'type' => 'number',
                            'field' => 'nr_docto',
                            'label' => 'Nr. Documento',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'text',
                            'field' => 'serie',
                            'label' => 'Série',
                            'required' => true,
                            'inputSize' => 3,
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_doc',
                            'label' => 'Data Documento',
                            'required' => true,
                            'inputSize' => 3,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'inputValue' => date('d/m/Y H:i:s')
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_entrada',
                            'label' => 'Data Entrada',
                            'required' => true,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'inputSize' => 3,
                            'inputValue' => date('d/m/Y H:i:s')
                        ],
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'fornecedor_id',
                            'label' => 'Fornecedor',
                            'required' => true,
                            'items' => $fornecedores,
                            'displayField' => 'nome_razao',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'inputSize' => 7
                        ],
                    ]
                ])
                @endcomponent
                <div id="entrada_tanque_combustiveis" class="{{ $errors->has('items') ? ' has-error' : '' }}">
                    <entrada_tanque :tanques-data="{{ json_encode($tanques) }}" :old-data="{{ json_encode(old('items')) }}"></entrada_tanque>
                    @if ($errors->has('items'))
                        <span class="help-block"> 
                            <strong>{{ $errors->first('items') }}</strong>
                        </span>
                    @endif
                </div> 
            @endsection
        @endcomponent
    </div>
@push('bottom-scripts')
    <script src="{{ mix('js/entradatanque.js') }}"></script>
@endpush
@endsection