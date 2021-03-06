@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Novo Tipo de Movimentação de Produto', 
            'routeUrl' => route('tipo_movimentacao_produto.store'), 
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
                            'field' => 'tipo_movimentacao_produto',
                            'label' => 'Tipo de Movimentação de Produto',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 7
                        ],
                        [
                            'type' => 'select',
                            'field' => 'eh_entrada',
                            'label' => 'Entrada',
                            'inputSize' => 1,
                            'items' => Array('Não', 'Sim'),
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection