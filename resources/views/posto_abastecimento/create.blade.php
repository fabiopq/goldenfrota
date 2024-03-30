@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        
        @component('components.form', [
            'title' => 'Novo Posto de Abastecimentos', 
            'routeUrl' => route('posto_abastecimento.store'), 
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
                           
                        ],
                        [
                            'type' => 'text',
                            'field' => 'ftp_server',
                            'label' => 'Servidor Ftp',
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'text',
                            'field' => 'ftp_user',
                            'label' => 'Usuario Ftp',
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'text',
                            'field' => 'ftp_pass',
                            'label' => 'Senha Ftp',
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'text',
                            'field' => 'ftp_port',
                            'label' => 'Porta Ftp',
                            'inputSize' => 2,
                            'inputValue' => 21,
                        ],
                        [
                            'type' => 'text',
                            'field' => 'ftp_root',
                            'label' => 'Pasta Raiz Ftp',
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ftp_passive',
                            'label' => 'Passivo',
                            'inputSize' => 1,
                            'items' => ['Não', 'Sim'],
                            'indexSelected' => 1,
                        ],
                        
                        [
                            'type' => 'select',
                            'field' => 'ftp_ssl',
                            'label' => 'SSL',
                            'inputSize' => 1,
                            'items' => ['Não', 'Sim'],
                        ],
                        [
                            'type' => 'text',
                            'field' => 'ftp_timeout',
                            'label' => 'Time Out',
                            'inputSize' => 2,
                            'inputValue' => 30,
                        ]
                    ]
                ])
                @endcomponent
               
               
                        
                
            @endsection
        @endcomponent
       
@include('veiculo.modal')

<!-- Modal -->


@endsection

@push('document-ready')
    $('#placa').mask('SSS-0AA0', {placeholder: '___-____'});

    var buscarDepartamentos = function() {
        var departamento = {};

        departamento.id = $('#cliente_id').val();
        departamento._token = $('input[name="_token"]').val();

        console.log(departamento);
        $.ajax({
            url: '{{ route("departamentos.json") }}',
            type: 'POST',
            data: departamento,
            dataType: 'JSON',
            cache: false,
            success: function (data) {
                $("#departamento_id")
                    .removeAttr('disabled')
                    .find('option')
                    .remove();


                $.each(data, function (i, item) {
                    $('#departamento_id').append($('<option>', { 
                        value: item.id,
                        text : item.departamento 
                    }));
                });
                
                @if(old('departamento_id'))
                $('#departamento_id').selectpicker('val', {{old('departamento_id')}});
                @endif

                $('.selectpicker').selectpicker('refresh');
            }
        });
    }

    
    
@endpush
