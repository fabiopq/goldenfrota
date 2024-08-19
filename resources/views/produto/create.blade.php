@extends('layouts.app')

@section('content-no-app')
    @if (old('fornecedores'))
        {{-- {{ dd(old(str_replace('[]', '', 'fornecedores[]'))) }} --}}
    @endif
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Novo Produto',
            'routeUrl' => route('produto.store'),
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
                            'type' => 'text',
                            'field' => 'produto_descricao',
                            'label' => 'Descrição',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 6,
                        ],
                        [
                            'type' => 'text',
                            'field' => 'produto_desc_red',
                            'label' => 'Descrição Reduzida',
                            'inputSize' => 3,
                            'maxLength' => 10,
                        ],
                       
                        
                       
                        
                    ],
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        
                        [
                            'type' => 'select',
                            'field' => 'unidade_id',
                            'label' => 'Unidade',
                            'required' => true,
                            'items' => $unidades,
                            'inputSize' => 2,
                            'displayField' => 'unidade',
                            'keyField' => 'id',
                            'liveSearch' => true,
                        ],
                     
                
                        [
                            'type' => 'input-btn',
                            'field' => 'unidade_id',
                            'label' => 'Novo',
                            'required' => true,
                            'inputSize' => 1,
                            'displayField' => 'unidade',
                            'keyField' => 'id',
                            'comando' => 'unidadeModal',
                            'action' => 'create'
                        ],
                        [
                            'type' => 'select',
                            'field' => 'grupo_produto_id',
                            'label' => 'Grupo',
                            'required' => true,
                            'items' => $grupoProdutos,
                            'inputSize' => 4,
                            'displayField' => 'grupo_produto',
                            'keyField' => 'id',
                            'liveSearch' => true,
                        ],
                        [
                            'type' => 'input-btn',
                            'field' => 'grupo_id',
                            'label' => 'Novo',
                            'required' => true,
                            'inputSize' => 1,
                            'displayField' => 'grupo',
                            'keyField' => 'id',
                            'comando' => 'grupoProdutoModal',
                            'action' => 'create'
                        ],
                
                       
                    ],
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'number',
                            'field' => 'valor_custo',
                            'label' => 'Preço de Custo',
                            'inputSize' => 2,
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor_venda',
                            'label' => 'Preço de Venda',
                            'inputSize' => 2,
                        ],
                    ],
                ])
                @endcomponent


                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'controla_vencimento',
                            'label' => 'Controla Vencimento',
                            'inputSize' => 2,
                            'items' => ['Não', 'Sim'],
                        ],
                
                        [
                            'type' => 'number',
                            'field' => 'vencimento_dias',
                            'label' => 'Vencimento em Dias',
                            'readOnly' => true,
                            'inputSize' => 2,
                        ],
                        [
                            'type' => 'number',
                            'field' => 'vencimento_km',
                            'label' => 'Vencimento em Km',
                            'readOnly' => true,
                            'inputSize' => 2,
                        ],
                        [
                            'type' => 'number',
                            'field' => 'vencimento_horas_trabalhadas',
                            'label' => 'Vencimento em Horas/Trabalhadas',
                            'readOnly' => true,
                            'inputSize' => 3,
                        ],
                    ],
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'numero_serie',
                            'label' => 'Número de Série',
                            'inputSize' => 4,
                        ],
                        [
                            'type' => 'text',
                            'field' => 'codigo_barras',
                            'label' => 'Código de Barras',
                            'inputSize' => 4,
                        ],
                    ],
                ])
                @endcomponent
                <div class="row">
                    <div class="col-md-4">
                        @component('components.input-checklist-group', [
                            'items' => $fornecedores,
                            'label' => 'nome_razao',
                            'field' => 'fornecedores[]',
                            'title' => 'Fornecedores',
                            'value' => 'id',
                        ])
                        @endcomponent
                    </div>
                    <div class="col-md-8" id="estoque-produto-component">
                        {{-- @component('components.input-checklist-group', [
    'items' => $estoques,
    'label' => 'estoque',
    'field' => 'estoques[]',
    'title' => 'Estoques',
    'value' => 'id',
])
                        @endcomponent  --}}
                        <estoque-produto :estoques-data="{{ json_encode($listaEstoques) }}"
                            :old-data="{{ json_encode(old('estoques')) }}">
                            </estoque_produto>
                    </div>
                </div>
            @endsection
        @endcomponent
    </div>
    @include('unidade.modal')
    @include('grupo_produto.modal')
    <meta name="csrf-token" content="{{ Session::token() }}">

@endsection

@push('document-ready')
    $('#controla_vencimento').on('changed.bs.select', (e) => {
    $('#vencimento_dias').prop('readonly', (e.target.value == 0));
    $('#vencimento_km').prop('readonly', (e.target.value == 0));
    $('#vencimento_horas_trabalhadas').prop('readonly', (e.target.value == 0));
    if (e.target.value == 0) {
    $('#vencimento_dias').val('');
    $('#vencimento_km').val('');
    $('#vencimento_horas_trabalhadas').val('');
    }
    });

    $('#saveUnidade').click(function() {
        var unidadeNome = $('#unidadeNome').val();
        var permite_fracionamento = $('#permite_fracionamento').val();
        console.log(unidadeNome);
        $.ajax({
            url: "{{ route('unidade.store') }}",
            method: 'POST',
            data: {
                unidade: unidadeNome,
                permite_fracionamento: permite_fracionamento,
                _token: $('meta[name=csrf-token]').attr('content'),
                 
            },
            
            success: function(response) {
            
                buscarUnidade();
                $('#unidadeModal').modal('hide');
               
                {{-- $('#unidade_id').append('<option value="' + response.id + '">' + response
                //     .name + '</option>');
                // $('#unidade_id').val(response.id);
                --}}
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseJSON.message);
                
            }
        });
    });

    var buscarUnidade = function() {
        var unidades = {};

        $.ajax({
            url: '{{ route("unidades.json") }}',
            type: 'POST',
            data: {
                unidade: unidades,
                _token: $('meta[name=csrf-token]').attr('content'),
                 
            },
            dataType: 'JSON',
            cache: false,
            success: function (data) {
                console.log(data);
                if (data.length > 0) {
                    $("#unidade_id")
                        .removeAttr('disabled')
                        .find('option')
                        .remove();
                } else {
                    if ($('#unidade_id').val() == -1) {
                        $("#unidade_id").attr('disabled', 'disabled');
                    }
                }

                $('#unidade_id').append($('<option>', { 
                        value: -1,
                        text : 'NADA SELECIONADO'
                }));
                $.each(data, function (i, item) {
                    $('#unidade_id').append($('<option>', { 
                        value: item.id,
                        text : item.unidade 
                    }));
                });
                
                @if(old('unidade_id'))
                $('#unidade_id').selectpicker('val', {{old('unidade_id')}});
                @endif

                $('.selectpicker').selectpicker('refresh');
            }

            
        });                
    }

    $('#saveGrupo').click(function() {
        var grupoNome = $('#grupoProduto').val();
       
        console.log(grupoNome);
        $.ajax({
            url: "{{ route('grupo_produto.store') }}",
            method: 'POST',
            data: {
                grupo_produto: grupoNome,
                _token: $('meta[name=csrf-token]').attr('content'),
                 
            },
            
            success: function(response) {
            
                buscarGrupo();
                $('#grupoProdutoModal').modal('hide');
               
                {{-- $('#unidade_id').append('<option value="' + response.id + '">' + response
                //     .name + '</option>');
                // $('#unidade_id').val(response.id);
                --}}
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseJSON.message);
                
            }
        });
    });

    var buscarGrupo = function() {
        var grupo = {};

       

        $.ajax({
            url: '{{ route("grupo_produtos.json") }}',
            type: 'POST',
            
            data: {
                grupo_produto: grupo,
                _token: $('meta[name=csrf-token]').attr('content'),
                 
            },
            dataType: 'JSON',
            cache: false,
            success: function (data) {
                console.log(data);
                if (data.length > 0) {
                    $("#grupo_produto_id")
                        .removeAttr('disabled')
                        .find('option')
                        .remove();
                } else {
                    if ($('#grupo_produto_id').val() == -1) {
                        $("#grupo_produto_id").attr('disabled', 'disabled');
                    }
                }

                $('#grupo_produto_id').append($('<option>', { 
                        value: -1,
                        text : 'NADA SELECIONADO'
                }));
                $.each(data, function (i, item) {
                    $('#grupo_produto_id').append($('<option>', { 
                        value: item.id,
                        text : item.grupo_produto 
                    }));
                });
                
                @if(old('grupo_produto_id'))
                $('#unidade_id').selectpicker('val', {{old('grupo_produto_id')}});
                @endif

                $('.selectpicker').selectpicker('refresh');
            }

            
        });                
    }



    

    @endpush
    
    @push('bottom-scripts')
        <script src="{{ mix('js/estoqueproduto.js') }}"></script>
    @endpush
