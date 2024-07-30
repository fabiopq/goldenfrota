@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Novo Ticket',
            'routeUrl' => route('ticket.store'),
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
                            'type' => 'datetime',
                            'field' => 'data_abertura',
                            'label' => 'Data/Hora',
                            'required' => true,
                            'inputSize' => 2,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'sideBySide' => true,
                            'inputValue' => date('d/m/Y H:i:s'),
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
                        ],
                    ],
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'cliente_id',
                            'label' => 'Cliente',
                            'required' => false,
                            'items' => $clientes,
                            'autofocus' => true,
                            'displayField' => 'nome_razao',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 4,
                        ],
                        [
                            'type' => 'text',
                            'field' => 'cliente',
                            'label' => 'Cliente',
                            'required' => true,
                            'inputSize' => 4,
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
                        ],
                        [
                            'type' => 'text',
                            'field' => 'solicitante',
                            'label' => 'Solicitante',
                            'required' => false,
                            'inputSize' => 2,
                        ],
                
                        [
                            'type' => 'text',
                            'field' => 'titulo',
                            'label' => 'Título',
                            'required' => true,
                            'inputSize' => 5,
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
                        ],
                    ],
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
                                ],
                                [
                                    'type' => 'textarea',
                                    'field' => 'solucao',
                                    'label' => 'Solução',
                                    'inputSize' => 6,
                                ],
                            ],
                        ])
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
@push('document-ready')
    var buscarVeiculos = function() {
    var cliente = {};

    $('#veiculo_id').append($('#cliente_id').val());


    cliente._token = $('input[name="_token"]').val();


    }


    $('#cliente_id').on('changed.bs.select', buscarVeiculos);


    if ($('#cliente_id').val()) {
    buscarVeiculos();
    }

    $('#veiculo_id').on('changed.bs.select', (e) => {
    if ($('#'+e.target.id).find('option:selected').data('tipo-controle-veiculo') == 1) {
    $('#label__km_veiculo').html('KM do Veículo');
    } else {
    $('#label__km_veiculo').html('Horas trabalhadas');
    }
    });
@endpush
