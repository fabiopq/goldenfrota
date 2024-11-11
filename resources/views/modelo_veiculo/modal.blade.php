
<div class="modal fade" id="modeloVeiculoModal" tabindex="-1" aria-labelledby="modeloVeiculoModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modeloVeiculoModalLabel">Cadastrar Modelo de Veículos</h5>
               {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <form id="formModeloVeiculoModal">
                    @csrf
                  
                    @component('components.form-group', [
                        'inputs' => [
                            [
                                'type' => 'text',
                                'field' => 'modelo_veiculo',
                                'label' => 'Modelo de Veículo',
                                'required' => true,
                                'autofocus' => true,
                                //'inputSize' => 4,
                            ],
                            [
                                'type' => 'select',
                                'field' => 'modal_marca_veiculo_id',
                                'label' => 'Marca de Veículo',
                                'required' => true,
                                'items' => $marcaVeiculos,
                                //'inputSize' => 4,
                                'displayField' => 'marca_veiculo',
                                'keyField' => 'id',
                                'liveSearch' => true,
                            ],
                            
                        ],
                    ])
                    @endcomponent
                    @component('components.form-group', [
                        'inputs' => [
                            [
                                'type' => 'number',
                                'field' => 'capacidade_tanque',
                                'label' => 'Capacidade do Tanque',
                                'required' => true,
                                'inputSize' => 5,
                            ],
                            [
                                'type' => 'select',
                                'field' => 'tipo_controle_veiculo_id',
                                'label' => 'Tipo de Controle',
                                'required' => true,
                                'items' => $tipoControleVeiculos,
                                'inputSize' => 5,
                                'displayField' => 'tipo_controle_veiculo',
                                'keyField' => 'id',
                                'liveSearch' => true,
                            ],
                        ],
                    ])
                    @endcomponent
    
                    <div class="card">
                        <div class="card-header">
                            <strong>CONTROLE</strong>
                        </div>
                        <div class="card-body">
                            @component('components.form-group', [
                                'inputs' => [
                                    [
                                        'type' => 'select',
                                        'field' => 'tipo_controle_bloqueio',
                                        'label' => 'Bloqueio',
                                        'required' => true,
                                        'items' => Array('Não Bloquear', 'Apenas Alertar', 'Bloquear'),
                                        'inputSize' => 4,
                                        'displayField' => 'tipo_controle_bloqueio',
                                        'keyField' => 'id',
                                        'liveSearch' => true,
                                        'inputValue' => 1,
                                    ],
                                    [
                                        'type' => 'number',
                                        'field' => 'media_ideal',
                                        'label' => 'Média Ideal',
                                        'required' => true,
                                        'inputSize' => 4,
                                        'inputValue' => 0,
                                    ],
                                    [
                                        'type' => 'number',
                                        'field' => 'variacao_negativa',
                                        'label' => 'Variação Negativa',
                                        'required' => true,
                                        'inputSize' => 4,
                                        'inputValue' => 0,
                                    ],
                                    [
                                        'type' => 'number',
                                        'field' => 'variacao_positiva',
                                        'label' => 'Variação Positiva',
                                        'required' => true,
                                        'inputSize' => 4,
                                        'inputValue' => 0,
                                    ],
                                ],
                            ])
                            @endcomponent
                        </div>
                    </div>                    
                    <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" name = "saveModeloVeiculo" id="saveModeloVeiculo">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
