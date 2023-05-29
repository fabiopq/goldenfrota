@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Atendente', 
            'routeUrl' => route('atendente.update', $atendente->id), 
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
                            'field' => 'nome_atendente',
                            'label' => 'Nome',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => $atendente->nome_atendente,
                            'inputSize' => 11
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $atendente->ativo,
                            'items' => Array('Não', 'Sim'),
                            'searchById' => false
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
                                    'inputValue' => $atendente->usuario_atendente,
                                    'inputSize' => 6
                                ],
                                [
                                    'type' => 'text',
                                    'field' => 'senha_atendente',
                                    'label' => 'Identificação TAG (Hiro)',
                                    'required' => true,
                                    'inputValue' => $atendente->senha_atendente,
                                    'inputSize' => 6
                                ],
                                [
                                    'type' => 'password',
                                    'field' => 'senha_atendente_app',
                                    'label' => 'Senha APP',
                                    'required' => true,
                                    'inputValue' => $atendente->senha_atendente_app,
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
                                    'defaultNone' => true,
                                    'inputSize' => 6,
                                    'indexSelected' => $atendente->veiculo_id
                                ], 
                            ]
                        ])
                        @endcomponent
                    </div>
                </div>
            @endsection
        @endcomponent
    </div>
@endsection