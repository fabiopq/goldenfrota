@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Novo Atendente', 
            'routeUrl' => route('atendente.store'), 
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
                            'field' => 'nome_atendente',
                            'label' => 'Nome',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => isset($atendente->nome_atendente) ? $atendente->nome_atendente : '',
                            'inputSize' => 12
                        ]
                    ]
                ])
                @endcomponent
                <div class="card">
                    <div class="card-header">
                        <strong>Automação (Hiro)</strong>
                    </div>
                    <div class="card-body">
                        @component('components.form-group', [
                            'inputs' => [
                                [
                                    'type' => 'text',
                                    'field' => 'usuario_atendente',
                                    'label' => 'Nome (Hiro)',
                                    'required' => true,
                                    'inputValue' => isset($atendente->usuario_atendente) ? $atendente->usuario_atendente : '',
                                    'inputSize' => 6
                                ],
                                [
                                    'type' => 'text',
                                    'field' => 'senha_atendente',
                                    'label' => 'Identificação TAG (Hiro)',
                                    'required' => true,
                                    'inputValue' => isset($atendente->senha_atendente) ? $atendente->senha_atendente : '',
                                    'inputSize' => 6
                                ],
                                 [
                                   'type' => 'select',
                                    'field' => 'veiculo_id',
                                    'label' => 'Veículo (opcional)',
                                    'required' => true,
                                    'items' => $veiculos,
                                    'displayField' => 'veiculo',
                                    'liveSearch' => true,
                                    'keyField' => 'id',
                                    'indexSelected' => 0,
                                    'defaultNone' => true,
                                      'inputSize' => 6,
                              ] , 
                            ]
                        ])
                        @endcomponent
                    </div>
                </div>
            @endsection
        @endcomponent
    </div>
@endsection