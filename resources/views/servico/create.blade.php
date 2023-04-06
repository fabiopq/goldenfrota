@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Novo Serviço', 
            'routeUrl' => route('servico.store'), 
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
                            'field' => 'servico',
                            'label' => 'Serviço',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 12
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'grupo_servico_id',
                            'label' => 'Grupo de Serviço',
                            'required' => true,
                            'items' => $grupo_servicos,
                            'inputSize' => 8,
                            'displayField' => 'grupo_servico',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'defaultNone' => true
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor_servico',
                            'label' => 'Valor',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 4
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'textarea',
                            'field' => 'descricao',
                            'label' => 'Descrição',
                            'required' => true,
                            'autofocus' => true,
                        ],
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#meuModal">Primary</button>
    </div>
    <modal name="meuModal"></modal>
@endsection
