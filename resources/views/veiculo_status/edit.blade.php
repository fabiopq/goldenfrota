@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Veículo', 
            'routeUrl' => route('veiculo_status.update', $veiculoStatus->id), 
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
                            'field' => 'data',
                            'label' => 'Data/Hora',
                            'required' => true,
                            'inputSize' => 2,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'sideBySide' => true,
                            'inputValue' => date('d/m/Y H:i:s'),
                        ],
                        [
                            'type' => 'select',
                            'field' => 'veiculo_id',
                            'label' => 'Veículo',
                            'required' => true,
                            'items' => $veiculos,
                            'displayField' => 'veiculo',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 4,
                            'indexSelected' => $veiculoStatus->veiculo_id,
                        ],
                        [
                            'type' => 'select',
                            'field' => 'status_id',
                            'label' => 'Status',
                            'inputSize' => 3,
                            'indexSelected' => $veiculoStatus->status_id,
                            'items' => ['Alertar', 'Bloquear', 'Liberado'],
                        ],
                        
                        
                    ]
                ])
                @endcomponent
                
                <div class="card">
                    <div class="card-header">
                        <strong>Histórico</strong>
                    </div>
                    <div class="card-body">
                        @component('components.form-group', [
                            'inputs' => [
                                [
                                    'type' => 'textarea',
                                    'field' => 'historico',
                                    'label' => '',
                                    'inputValue' => $veiculoStatus->historico
                                ],
                            ],
                        ])
                        @endcomponent
                    </div>
                </div>
                
                
            @endsection
        @endcomponent
    </div>
    
    <div id="visulUsuarioModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visulUsuarioModalLabel">Detalhes do Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="visul_usuario"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-info" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    
    <div id="addGrupoVeiculoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGrupoVeiculoModalLabel">Cadastrar Grupo Veículo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="insert_form">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nome</label>
                            <div class="col-sm-10">
                                <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome do Grupo">
                            </div>
                        </div>
                                                
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <input type="submit" name="CadUser" id="CadUser" value="Cadastrar" class="btn btn-outline-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    
@endsection


