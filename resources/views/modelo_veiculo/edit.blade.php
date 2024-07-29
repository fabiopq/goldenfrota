@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Modelo de Veículo',
            'routeUrl' => route('modelo_veiculo.update', $modeloVeiculo->id),
            'method' => 'PUT',
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
                            'field' => 'modelo_veiculo',
                            'label' => 'Modelo de Veículo',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => $modeloVeiculo->modelo_veiculo,
                            'inputSize' => 4,
                        ],
                        [
                            'type' => 'select',
                            'field' => 'marca_veiculo_id',
                            'label' => 'Marca de Veículo',
                            'required' => true,
                            'items' => $marcaVeiculos,
                            'inputSize' => 4,
                            'displayField' => 'marca_veiculo',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'indexSelected' => $modeloVeiculo->marca_veiculo_id,
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $modeloVeiculo->ativo,
                            'items' => ['Não', 'Sim'],
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
                            'inputSize' => 4,
                            'inputValue' => $modeloVeiculo->capacidade_tanque,
                        ],
                        [
                            'type' => 'select',
                            'field' => 'tipo_controle_veiculo_id',
                            'label' => 'Tipo de Controle',
                            'required' => true,
                            'items' => $tipoControleVeiculos,
                            'inputSize' => 4,
                            'displayField' => 'tipo_controle_veiculo',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'indexSelected' => $modeloVeiculo->tipo_controle_veiculo_id,
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
                                    'label' => 'Controle de Bloqueio',
                                    'required' => true,
                                    'items' => ['Não Bloquear', 'Apenas Alertar', 'Bloquear'],
                                    'inputSize' => 4,
                                    'displayField' => 'tipo_controle_bloqueio',
                                    'keyField' => 'id',
                                    'liveSearch' => true,
                                    'indexSelected' => $modeloVeiculo->tipo_controle_bloqueio,
                                ],
                                [
                                    'type' => 'number',
                                    'field' => 'media_ideal',
                                    'label' => 'Média Ideal',
                                    'required' => true,
                                    'inputSize' => 2,
                                    'inputValue' => $modeloVeiculo->media_ideal,
                                ],
                                [
                                    'type' => 'number',
                                    'field' => 'variacao_negativa',
                                    'label' => 'Variação Negativa',
                                    'required' => true,
                                    'inputSize' => 2,
                                    'inputValue' => $modeloVeiculo->variacao_negativa,
                                ],
                                [
                                    'type' => 'number',
                                    'field' => 'variacao_positiva',
                                    'label' => 'Variação Positiva',
                                    'required' => true,
                                    'inputSize' => 2,
                                    'inputValue' => $modeloVeiculo->variacao_positiva,
                                ],
                            ],
                        ])
                        @endcomponent
                    </div>
                </div>
            @endsection
        @endcomponent
    </div>
@endsection
