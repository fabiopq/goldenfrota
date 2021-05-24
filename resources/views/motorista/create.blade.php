@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Novo Motorista', 
            'routeUrl' => route('motorista.store'), 
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
                            'field' => 'nome',
                            'label' => 'Nome',
                            'required' => true,
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'text',
                            'field' => 'apelido',
                            'label' => 'Apelido',
                            'inputSize' => 4
                        ],
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
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'text',
                            'field' => 'rg',
                            'label' => 'RG',
                            'required' => true,
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'select',
                            'label' => 'Estado Civil',
                            'required' => true,
                            'items' => ['Solteiro','Casado'],
                            'inputSize' => 2,
                            'searchById' => false
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_nascimento',
                            'label' => 'Data Nascimento',
                            'inputSize' => 2,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'sideBySide' => true,
                            'inputValue' => date('d/m/Y H:i:s')
                            
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_admissao',
                            'label' => 'Data Admissão',
                            'inputSize' => 2,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'sideBySide' => true,
                            'inputValue' => date('d/m/Y H:i:s')
                            
                        ],
                        [
                            'type' => 'text',
                            'field' => 'tag',
                            'label' => 'TAG (Automação)',
                            'required' => false,
                            'inputSize' => 3
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
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'select',
                            'field' => 'categoria',
                            'label' => 'Categoria',
                            'items' => ['A','B','C','D','E','AB',
                                       'AC','AD'],
                            'inputSize' => 2,
                            'searchById' => false,

                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_validade_habilitacao',
                            'label' => 'Validade',
                            'inputSize' => 2,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'sideBySide' => true,
                            'inputValue' => date('d/m/Y H:i:s')
                            
                        ],
                        [
                            'type' => 'text',
                            'field' => 'pontos_habilitacao',
                            'label' => 'Pontos',
                            'inputSize' => 1
                        ],
                        [
                            'type' => 'select',
                            'field' => 'tipo_sanguineo',
                            'label' => 'Tipo Sanguineo',
                            'required' => true,
                            'items' => ['A+','A-','B+','B-','AB+','AB-',
                                       '0+','0-'],
                            'inputSize' => 2,
                            'searchById' => false
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
                        ], 
                        [
                            'type' => 'text',
                            'field' => 'observacoes',
                            'label' => 'Observações',
                            'required' => true,
                            'inputSize' => 6
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
                                    'css' => 'mask_phone'
                                ],
                                [
                                    'type' => 'text',
                                    'field' => 'email1',
                                    'label' => 'E-mail [1]',
                                    'inputSize' => 6
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
                                    'inputSize' => 11
                                ],
                                [
                                    'type' => 'text',
                                    'field' => 'numero',
                                    'label' => 'Número',
                                    'inputSize' => 1
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
                                    'inputSize' => 4
                                ],
                                [
                                    'type' => 'text',
                                    'field' => 'cidade',
                                    'label' => 'Cidade',
                                    'inputSize' => 4
                                ],
                                [
                                    'type' => 'text',
                                    'field' => 'cep',
                                    'label' => 'Cep',
                                    'inputSize' => 2
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

    $('#tipo_pessoa_id').on('changed.bs.select', function (e) {
        $("#cpf_cnpj").val('');
        if ($("#tipo_pessoa_id").val() == 1) {
            $("#cpf").mask('000.000.000-00', {placeholder: '___.___.___-__'});
        } else {
            $("#cpf").mask('00.000.000/0000-00', {placeholder: '__.___.___/____-__'}); 
        }
    });
@endpush