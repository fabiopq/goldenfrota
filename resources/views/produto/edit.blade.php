@extends('layouts.app')

@section('content')
    {{--  {{ dd($estoques) }}  --}}
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Produto',
            'routeUrl' => route('produto.update', $produto->id),
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
                            'field' => 'produto_descricao',
                            'label' => 'Descrição',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 6,
                            'inputValue' => $produto->produto_descricao,
                            'css' => 'text-uppercase',
                        ],
                        [
                            'type' => 'text',
                            'field' => 'produto_desc_red',
                            'label' => 'Descrição Reduzida',
                            'inputSize' => 2,
                            'maxLength' => 10,
                            'inputValue' => $produto->produto_desc_red,
                            'css' => 'text-uppercase',
                        ],
                        
                    ],
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
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
                            'indexSelected' => $produto->grupo_produto_id,
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
                            'indexSelected' => $produto->unidade_id,
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
                            'indexSelected' => $produto->controla_vencimento,
                        ],
                        [
                            'type' => 'number',
                            'field' => 'vencimento_dias',
                            'label' => 'Vencimento em Dias',
                            'inputSize' => 2,
                            'readOnly' => !$produto->controla_vencimento,
                            'inputValue' => $produto->vencimento_dias,
                        ],
                        [
                            'type' => 'number',
                            'field' => 'vencimento_km',
                            'label' => 'Vencimento em Km',
                            'inputSize' => 2,
                            'readOnly' => !$produto->controla_vencimento,
                            'inputValue' => $produto->vencimento_km,
                        ],
                        [
                            'type' => 'number',
                            'field' => 'vencimento_horas_trabalhadas',
                            'label' => 'Vencimento em Horas/Trabalhadas',
                            'readOnly' => !$produto->controla_vencimento,
                            'inputSize' => 3,
                            'inputValue' => $produto->vencimento_horas_trabalhadas,
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
                            'inputSize' => 6,
                            'inputValue' => $produto->numero_serie,
                        ],
                        [
                            'type' => 'text',
                            'field' => 'codigo_barras',
                            'label' => 'Código de Barras',
                            'inputSize' => 6,
                            'inputValue' => $produto->codigo_barras,
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
                            'indexSelected' => $produto->fornecedores()->pluck('fornecedor_id'),
                        ])
                        @endcomponent
                    </div>
                    <div class="col-md-8" id="estoque-produto-component">
                        <estoque-produto :estoques-data="{{ json_encode($listaEstoques) }}"
                            :old-data="{{ json_encode(old('estoques') ? old('estoques') : $estoques) }}"></estoque-produto>
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
