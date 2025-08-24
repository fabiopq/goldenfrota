@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Posição de Estoque',
            'routeUrl' => route('relatorio_posicao_estoque'),
            'formTarget' => '_blank',
            'method' => 'POST',
            'formButtons' => [['type' => 'submit', 'label' => 'Gerar Relatório', 'icon' => 'chart-line']],
        ])
            @section('formFields')
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select-mult',
                            'field' => 'estoque_id',
                            'label' => 'Estoque',
                            'required' => true,
                            'items' => $estoques,
                            'autofocus' => true,
                            'displayField' => 'estoque',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 4,
                        ],
                        [
                            'type' => 'select-mult',
                            'field' => 'grupo_produto_id',
                            'label' => 'Grupo de Produto',
                            'items' => $grupo_produtos,
                            'displayField' => 'grupo_produto',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 4,
                        ],
                        [
                            'type' => 'select-mult',
                            'field' => 'produto_id',
                            'label' => 'Produto',
                            'items' => $produtos,
                            'autofocus' => true,
                            'displayField' => 'produto_descricao',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 4,
                        ],
                    ],
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>


    @push('bottom-scripts')
    <script>
        $(document).ready(function() {
            var buscarProdutosPorGrupo = function() {
                var grupoProdutoIds = $('#grupo_produto_id').val();
                
                var dados = {
                    grupo_produto_ids: grupoProdutoIds,
                    _token: $('input[name="_token"]').val()
                };
    
                $.ajax({
                    url: '{{ route('produtos_pelo_grupo.json') }}',
                    type: 'POST',
                    data: dados,
                    dataType: 'JSON',
                    cache: false,
                    success: function(data) {
                        $("#produto_id")
                            .find('option')
                            .remove();
    
                        $('#produto_id').append($('<option>', {
                            value: '',
                            text: 'NADA SELECIONADO'
                        }));
    
                        $.each(data, function(i, item) {
                            $('#produto_id').append($('<option>', {
                                value: item.id,
                                text: item.produto_descricao
                            }));
                        });
    
                        $('.selectpicker').selectpicker('refresh');
                    },
                    error: function(xhr) {
                        console.error('Erro ao buscar produtos:', xhr.responseText);
                    }
                });
            };
    
            $('#grupo_produto_id').on('changed.bs.select', buscarProdutosPorGrupo);
        });
    </script>
    @endpush

@endsection
