@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Entrada Tanques', 
            'routeUrl' => route('relatorio_entrada_tanque'), 
            'formTarget' => '_blank',
            'method' => 'POST',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Gerar Relatório', 'icon' => 'chart-line'],
                ]
            ])
            @section('formFields')
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'datetime',
                            'field' => 'data_inicial',
                            'label' => 'Data Inicial',
                            'inputSize' => 3,
                            'dateTimeFormat' => 'DD/MM/YYYY',
                            'picker_begin' => 'data_inicial',
                            'picker_end' => 'data_final',
                            'inputValue' => date('01/m/Y'),
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_final',
                            'label' => 'Data Final',
                            'inputSize' => 3,
                            'dateTimeFormat' => 'DD/MM/YYYY',
                            'picker_begin' => 'data_inicial',
                            'picker_end' => 'data_final',
                            'inputValue' => date('t/m/Y')
                        ],
                        [
                            'type' => 'btn-group',
                            'field' => 'tipo_relatorio',
                            'label' => 'Tipo de Relatório',
                            'radioButtons' => [
                                [
                                    'label' => 'Sintético',
                                    'value' => 1
                                ],
                                [
                                    'label' => 'Analítico',
                                    'value' => 2
                                ],
                            ],
                            'inputSize' => 3,
                            'defaultValue' => 1
                        ],
                      ]  
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        
                        [
                            'type' => 'select',
                            'field' => 'fornecedor_id',
                            'label' => 'Fornecedor',
                            'items' => $fornecedores,
                            'displayField' => 'nome_razao',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'disabled' => false,
                            'defaultNone' => true,
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'select',
                            'field' => 'combustivel_id',
                            'label' => 'Combustivel',
                            'items' => $combustiveis,
                            'displayField' => 'descricao',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'disabled' => false,
                            'defaultNone' => true,
                            'inputSize' => 4
                        ],
                        
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
    <script>
        $(document).ready(function() {
            var clearSelect = function (selectComponentId) {
                $(selectComponentId)
                    .attr('disabled', 'disabled')
                    .find('option')
                    .remove();
                    $(selectComponentId).selectpicker('refresh');
            }

            

            var buscarProdutos = function() {
                var grupo_produto = {};

                if(!$('#grupo_produto_id').val()) {
                    clearSelect('#produto_id');
                } else {              
                    grupo_produto.id = $('#grupo_produto_id').val();
                    grupo_produto._token = $('input[name="_token"]').val();

                    $.ajax({
                        url: '{{ route("produtos_pelo_grupo.json") }}',
                        type: 'POST',
                        data: grupo_produto,
                        dataType: 'JSON',
                        cache: false,
                        success: function (data) {
                            $("#produto_id")
                                .removeAttr('disabled')
                                .find('option')
                                .remove(); 

                            $('#produto_id').append($('<option>', {
                                value: '',
                                text: 'Nada Selecionado'
                            }));

                            $.each(data, function (i, item) {
                                $('#produto_id').append($('<option>', { 
                                    value: item.id,
                                    text : item.produto_descricao
                                }));
                            });
                            
                            @if(old('produto_id'))
                            $('#produto_id').selectpicker('val', {{old('produto_id')}});
                            @endif

                            $('.selectpicker').selectpicker('refresh');
                        },
                        error: function (data) {
                        }
                    });
                }
            }
            
            $('#estoque_id').on('changed.bs.select', buscarGrupoProdutos);
            $('#grupo_produto_id').on('changed.bs.select', buscarProdutos);

            if ($('#estoque_id').val()) {
                buscarGrupoProdutos();
            }

            if ($('#grupo_produto_id').val()) {
                buscarProdutos();
            }
        });
    </script>
@endsection