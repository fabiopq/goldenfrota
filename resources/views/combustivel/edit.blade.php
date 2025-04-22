@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Combustível', 
            'routeUrl' => route('combustivel.update', $combustivel->id), 
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
                            'type' => 'text',
                            'field' => 'descricao',
                            'label' => 'Combustível',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => $combustivel->descricao,
                            'inputSize' => 11
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $combustivel->ativo,
                            'items' => Array('Não', 'Sim'),
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'descricao_reduzida',
                            'label' => 'Desc. Reduzida',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 4,
                            'inputValue' => $combustivel->descricao_reduzida
                        ],
                        [
                            'type' => 'number',
                            'field' => 'custo',
                            'label' => 'Custo',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 4,
                            'inputValue' => $combustivel->custo
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor',
                            'label' => 'Valor',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 4,
                            'inputValue' => $combustivel->valor
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection