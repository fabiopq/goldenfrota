@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Novo Combustível',
            'routeUrl' => route('combustivel.store'),
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
                            'type' => 'text',
                            'field' => 'descricao',
                            'label' => 'Combustivel',
                            'required' => true,
                            'autofocus' => true,
                        ],
                    ],
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
                        ],
                        [
                            'type' => 'number',
                            'field' => 'custo',
                            'label' => 'Custo',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 4,
                            'inputValue' => 0,
                            
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor',
                            'label' => 'Valor',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 4,
                            'inputValue' => 0,
                        ],
                    ],
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection
