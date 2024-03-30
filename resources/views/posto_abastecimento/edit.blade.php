@extends('layouts.app')
@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Posto de Abastecimento', 
            'routeUrl' => route('posto_abastecimento.update', $posto_abastecimento->id), 
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
                            'inputValue' => $posto_abastecimento->nome,
                            
                        ],
                        [
                            'type' => 'text',
                            'field' => 'ftp_server',
                            'label' => 'Servidor Ftp',
                            'inputSize' => 6,
                            'inputValue' => $posto_abastecimento->ftp_server,
                        ],
                        [
                            'type' => 'text',
                            'field' => 'ftp_user',
                            'label' => 'Usuario Ftp',
                            'inputSize' => 6,
                            'inputValue' => $posto_abastecimento->ftp_user,
                        ],
                        [
                            'type' => 'text',
                            'field' => 'ftp_pass',
                            'label' => 'Senha Ftp',
                            'inputSize' => 4,
                            'inputValue' => $posto_abastecimento->ftp_pass,
                        ],
                        [
                            'type' => 'text',
                            'field' => 'ftp_port',
                            'label' => 'Porta Ftp',
                            'inputSize' => 2,
                            'inputValue' => $posto_abastecimento->ftp_port,
                        ],
                        [
                            'type' => 'text',
                            'field' => 'ftp_root',
                            'label' => 'Pasta Raiz Ftp',
                            'inputSize' => 4,
                            'inputValue' => $posto_abastecimento->ftp_root,
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ftp_passive',
                            'label' => 'Passivo',
                            'inputSize' => 1,
                            'indexSelected' => $posto_abastecimento->ftp_passive,
                            'items' => ['Não', 'Sim'],
                        ],
                        
                        [
                            'type' => 'select',
                            'field' => 'ftp_ssl',
                            'label' => 'SSL',
                            'inputSize' => 1,
                            'indexSelected' => $posto_abastecimento->ftp_ssl,
                            'items' => ['Não', 'Sim'],
                        ],
                        [
                            'type' => 'text',
                            'field' => 'ftp_timeout',
                            'label' => 'Time Out',
                            'inputSize' => 2,
                            'inputValue' => $posto_abastecimento->ftp_timeout,
                        ]
                    ]
                ])
                @endcomponent

               
                
                
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