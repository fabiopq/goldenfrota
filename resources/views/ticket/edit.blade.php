@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Ticket', 
            'routeUrl' => route('ticket.update', $ticket->id), 
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
                            'inputSize' => 4,
                            'indexSelected' => $ticket->cliente_id
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ticket_status_id',
                            'label' => 'Status',
                            'required' => true,
                            'items' => $ticketStatus,
                            'autofocus' => true,
                            'displayField' => 'descricao',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => false,
                            'inputSize' => 3,
                            'indexSelected' => $ticket->ticket_status_id
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ticket_prioridade_id',
                            'label' => 'Prioridade',
                            'required' => true,
                            'items' => $ticketPrioridade,
                            'autofocus' => true,
                            'displayField' => 'descricao',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => false,
                            'inputSize' => 3,
                            'indexSelected' => $ticket->ticket_prioridade_id
                        ],
                        [
                            'type' => 'text',
                            'field' => 'solicitante',
                            'label' => 'Solicitante',
                            'required' => false,
                            'inputSize' => 2,
                            'inputValue' => $ticket->solicitante,
                            
                        ],                        
                        
                        [
                            'type' => 'text',
                            'field' => 'titulo',
                            'label' => 'Título',
                            'required' => true,
                            'inputSize' => 5,
                            'inputValue' => $ticket->titulo,
                            
                        ],
                        [
                            'type' => 'select',
                            'field' => 'atendente_atribuido_id',
                            'label' => 'Atendente Atribuido',
                            'required' => false,
                            'items' => $atendentes,
                            'autofocus' => true,
                            'displayField' => 'nome_atendente',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 3,
                            'indexSelected' => $ticket->atendente_atribuido_id
                        ],
                    
                    ]
                ])
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
                                    'inputSize' => 6,
                                    'inputValue' => $ticket->problema,
                                ],
                                [
                                    'type' => 'textarea',
                                    'field' => 'solucao',
                                    'label' => 'Solução',
                                    'inputSize' => 6,
                                    'inputValue' => $ticket->solucao,
                                ]
                            ]             ])
                        @endcomponent
                    </div>
                </div>
               
                
               
            @endsection
        @endcomponent
        
    </div>
    @include('ticket.modal')
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalExemplo">
                Abrir modal de demonstração
                </button>
@endsection