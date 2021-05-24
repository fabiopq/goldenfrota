@extends('layouts.app')
@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Motorista', 
            'routeUrl' => route('motorista.update', $motorista->id), 
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
                            'field' => 'nome',
                            'label' => 'Nome',
                            'required' => true,
                            'inputSize' => 6,
                            'inputValue' => $motorista->nome
                        ],
                        [
                            'type' => 'text',
                            'field' => 'apelido',
                            'label' => 'Apelido',
                            'inputSize' => 4,
                            'inputValue' => $motorista->apelido
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $motorista->ativo,
                            'items' => Array('Não', 'Sim'),
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'cpf',
                            'label' => 'CPF',
                            'required' => true,
                            'inputSize' => 3,
                            'inputValue' => $motorista->cpf
                        ],
                        [
                            'type' => 'text',
                            'field' => 'rg',
                            'label' => 'RG',
                            'required' => true,
                            'inputSize' => 3,
                            'inputValue' => $motorista->rg
                        ],
                        [
                            'type' => 'select',
                            'label' => 'Estado Civil',
                            'required' => true,
                            'items' => ['Solteiro','Casado'],
                            'inputSize' => 2,
                            'searchById' => false,
                            'indexSelected' => $motorista->estado_civil

                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_nascimento',
                            'label' => 'Data Nascimento',
                            'inputSize' => 2,
                            'sideBySide' => true,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'inputValue' => \DateTime::createFromFormat('Y-m-d H:i:s', $motorista->data_nascimento)->format('d/m/Y H:i:s'),
                           
                            
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_admissao',
                            'label' => 'Data Admissão',
                            'inputSize' => 2,
                            'sideBySide' => true,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'inputValue' => \DateTime::createFromFormat('Y-m-d H:i:s', $motorista->data_admissao)->format('d/m/Y H:i:s'),
                          
                            
                        ],
                        [
                            'type' => 'text',
                            'field' => 'tag',
                            'label' => 'TAG (Automação)',
                            'required' => false,
                            'inputSize' => 3,
                            'inputValue' => $motorista->tag
                        ],
                        
                    ]
                ])
                @endcomponent
                
                <div class="card">
                    <div class="card-header">
                        <strong>HABILITAÇÃO</strong>
                    </div>
                    <div class="card-body">
                        @component('components.form-group', [
                            'inputs' => [
                            [
                            'type' => 'text',
                            'field' => 'habilitacao',
                            'label' => 'Habilitação',
                            'required' => true,
                            'inputSize' => 3,
                            'inputValue' => $motorista->habilitacao

                        ],
                        [
                            'type' => 'select',
                            'field' => 'categoria',
                            'label' => 'Categoria',
                            'items' => ['A','B','C','D','E','AB',
                                       'AC','AD'],
                            'inputSize' => 2,
                            'searchById' => false,
                            'indexSelected' => $motorista->categoria


                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_validade_habilitacao',
                            'label' => 'Validade',
                            'inputSize' => 2,
                            'sideBySide' => true,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'inputValue' => \DateTime::createFromFormat('Y-m-d H:i:s', $motorista->data_validade_habilitacao)->format('d/m/Y H:i:s'),
                            
                        ],
                        [
                            'type' => 'text',
                            'field' => 'pontos_habilitacao',
                            'label' => 'Pontos',
                            'inputSize' => 1,
                            'inputValue' => $motorista->pontos

                        ],
                        [
                            'type' => 'select',
                            'field' => 'tipo_sanguineo',
                            'label' => 'Tipo Sanguineo',
                            'required' => true,
                            'items' => ['A+','A-','B+','B-','AB+','AB-',
                                       '0+','0-'],
                            'inputSize' => 2,
                            'searchById' => false,
                            'indexSelected' => $motorista->tipo_sanguineo
                        ],
                        [
                            'type' => 'select',
                            'field' => 'veiculo_id',
                            'label' => 'Veículo Padrão',
                            'required' => true,
                            'items' => $veiculos,
                            'displayField' => 'veiculo',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 3,
                            'indexSelected' => $motorista->veiculo_id
                        ], 
                        [
                            'type' => 'text',
                            'field' => 'observacoes',
                            'label' => 'Observações',
                            'required' => true,
                            'inputSize' => 6,
                            'inputValue' => $motorista->observacoes
                        ],
                        ]
                        ])
                        @endcomponent
                        
                    </div>
                
                
                </div>

                <div class="card">
                    <div class="card-header">
                        <strong>CONTATOS</strong>
                    </div>
                    <div class="card-body">
                        @component('components.form-group', [
                            'inputs' => [
                                [
                                    'type' => 'text',
                                    'field' => 'fone',
                                    'label' => 'Fone',
                                    'required' => true,
                                    'inputSize' => 2,
                                    'inputValue' => $motorista->fone,
                                    'css' => 'mask_phone'
                                ],
                                [
                                    'type' => 'text',
                                    'field' => 'email1',
                                    'label' => 'E-mail [1]',
                                    'inputSize' => 6,
                                    'inputValue' => $motorista->email
                                ],
                            ]
                        ])
                        @endcomponent
                        
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <strong>ENDEREÇO</strong>
                    </div>
                    <div class="card-body">
                        @component('components.form-group', [
                            'inputs' => [
                                [
                                    'type' => 'text',
                                    'field' => 'endereco',
                                    'label' => 'Endereço',
                                    'required' => true,
                                    'inputSize' => 11,
                                    'inputValue' => $motorista->endereco
                                ],
                                [
                                    'type' => 'text',
                                    'field' => 'numero',
                                    'label' => 'Número',
                                    'inputSize' => 1,
                                    'inputValue' => $motorista->bairro
                                ],
                            ]
                        ])
                        @endcomponent
                        @component('components.form-group', [
                            'inputs' => [
                                [
                                    'type' => 'text',
                                    'field' => 'bairro',
                                    'label' => 'Bairro',
                                    'inputSize' => 4,
                                    'inputValue' => $motorista->bairro,
                                ],
                                [
                                    'type' => 'text',
                                    'field' => 'cidade',
                                    'label' => 'Cidade',
                                    'inputSize' => 4,
                                    'inputValue' => $motorista->cidade,
                                ],
                                [
                                    'type' => 'text',
                                    'field' => 'cep',
                                    'label' => 'Cep',
                                    'inputSize' => 2,
                                    'inputValue' => $motorista->cep,
                                ],
                                [
                                    'type' => 'select',
                                    'field' => 'uf_id',
                                    'label' => 'UF',
                                    'required' => true,
                                    'items' => $ufs,
                                    'inputSize' => 2,
                                    'displayField' => 'uf',
                                    'liveSearch' => true,
                                    'keyField' => 'id',
                                    'indexSelected' => $motorista->uf_id,
                                    'searchById' => false
                                ]
                            ]
                        ])
                        @endcomponent
                    </div>
                </div>
            @endsection
        @endcomponent
    </div>
@endsection
@push('document-ready')
    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00)00000-0000' : '(00)0000-00009';
    },
    spOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
        },
        placeholder: '(__) ______-_____'
    };

    $('.mask_phone').mask(SPMaskBehavior, spOptions);

    $('#cep').mask('00.000-000', {placeholder: '__.___-___'});

    $("#cpf").mask('000.000.000-00', {placeholder: '___.___.___-__'});

    
@endpush