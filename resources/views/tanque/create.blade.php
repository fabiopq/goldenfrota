@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Novo Tanque', 
            'routeUrl' => route('tanque.store'), 
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
                            'type' => 'text',
                            'field' => 'num_tanque',
                            'label' => 'N. Tanque',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => isset($tanque->num_tanque) ? $tanque->num_tanque : '',
                            'inputSize' => 1
                        ],
                        
                        [
                            'type' => 'text',
                            'field' => 'descricao_tanque',
                            'label' => 'Tanque Descrição',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => isset($tanque->descricao_tanque) ? $tanque->descricao_tanque : '',
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'select',
                            'field' => 'combustivel_id',
                            'label' => 'Combustível',
                            'required' => true,
                            'items' => $combustiveis,
                            'inputSize' => 4,
                            'displayField' => 'descricao',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'indexSelected' => isset($tanque->combustivel_id) ? $tanque->combustivel_id : ''
                        ],
                        [
                            'type' => 'select',
                            'field' => 'posto_abastecimento_id',
                            'label' => 'Posto de Abastecimentos',
                            'required' => true,
                            'items' => $postoabastecimentos,
                            'autofocus' => true,
                            'displayField' => 'nome',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 6,
                            'indexSelected' => isset($tanque->posto_abastecimento_id) ? $tanque->posto_abastecimento_id : ''

                        ],
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'capacidade',
                            'label' => 'Capacidade',
                            'required' => true,
                            'inputSize' => 4,
                            'inputValue' => isset($tanque->capacidade) ? $tanque->capacidade : ''
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection



