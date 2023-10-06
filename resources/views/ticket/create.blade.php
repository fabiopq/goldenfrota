@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Novo Ticket', 
            'routeUrl' => route('ticket.store'), 
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
                            'type' => 'datetime',
                            'field' => 'data_abertura',
                            'label' => 'Data/Hora',
                            'required' => true,
                            'inputSize' => 2,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'sideBySide' => true,
                            'inputValue' => date('d/m/Y H:i:s')
                        ],
                        [
                            'type' => 'select',
                            'field' => 'cliente_id',
                            'label' => 'Cliente',
                            'required' => true,
                            'items' => $clientes,
                            'autofocus' => true,
                            'displayField' => 'nome_razao',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 4 
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ticket_status_id',
                            'label' => 'Status',
                            'required' => true,
                            'items' => $clientes,
                            'autofocus' => true,
                            'displayField' => 'nome_razao',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 3 
                        ],
                        [
                            'type' => 'text',
                            'field' => 'solicitante',
                            'label' => 'Solicitante',
                            'required' => false,
                            'inputSize' => 4
                            
                        ],                        
                        
                        [
                            'type' => 'text',
                            'field' => 'titulo',
                            'label' => 'Título',
                            'required' => true,
                            'inputSize' => 7
                            
                        ],
                        [
                            'type' => 'select',
                            'field' => 'atendentes_id',
                            'label' => 'Atendente Atribuido',
                            'required' => false,
                            'items' => $atendentes,
                            'autofocus' => true,
                            'displayField' => 'nome_atendente',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 3 
                        ],
                    
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'titulo',
                            'label' => 'Título',
                            'required' => true,
                            'inputSize' => 7
                            
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'email',
                            'label' => 'E-mail',
                            'required' => true,
                            'inputValue' => isset($user->email) ? $user->email : '',
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'password',
                            'field' => 'password',
                            'label' => 'Senha',
                            'required' => true,
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'password',
                            'field' => 'password_confirmation',
                            'label' => 'Confirmação de Senha',
                            'required' => true,
                            'inputSize' => 6
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                            'inputs' => [
                                [
                                    'type' => 'textarea',
                                    'field' => 'problema',
                                    'label' => 'Problema',
                                    'inputSize' => 6
                                ],
                                [
                                    'type' => 'textarea',
                                    'field' => 'solucao',
                                    'label' => 'Solução',
                                    'inputSize' => 6
                                ]
                            ]             ])
                        @endcomponent
            @endsection
        @endcomponent
        <div class="card">
                    <div class="card-header">
                        <strong>Detalhes</strong>
                    </div>
                    <div class="card-body">
                        @component('components.form-group', [
                            'inputs' => [
                                [
                                    'type' => 'textarea',
                                    'field' => 'problema',
                                    'label' => 'Problema',
                                    'inputSize' => 6
                                ],
                                [
                                    'type' => 'textarea',
                                    'field' => 'solucao',
                                    'label' => 'Solução',
                                    'inputSize' => 6
                                ]
                            ]             ])
                        @endcomponent
                    </div>
                </div>
    </div>
@endsection