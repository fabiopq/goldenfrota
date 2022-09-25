@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Listagem de Produtos', 
            'routeUrl' => route('param_relatorio_listagem_produtos'), 
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
                            'type' => 'select',
                            'field' => 'grupo_produto_id',
                            'label' => 'Grupo de Produtos',
                            'items' => $grupo_produtos,
                            'displayField' => 'grupo_produto',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'select',
                            'field' => 'produto_id',
                            'label' => 'Produto',
                            'items' => $produtos,
                            'autofocus' => true,
                            'displayField' => 'produto_descricao',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 4
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
    @push('document-ready')
        $(document).ready(function() {
            var buscarProdutos = function() {
                var grupo_produto = {};

                grupo_produto.id = $('#grupo_produto_id').val();
                grupo_produto._token = $('input[name="_token"]').val();

                console.log(grupo_produto);
                $.ajax({
                    url: '{{ route("produtos_pelo_grupo.json") }}',
                    type: 'POST',
                    data: grupo_produto,
                    dataType: 'JSON',
                    cache: false,
                    success: function (data) {
                        console.log(data);
                        $("#produto_id")
                            .removeAttr('disabled')
                            .find('option')
                            .remove();

                            $('#produto_id').append($('<option>', { 
                                value: -1,
                                text : 'Nada Selecionado' 
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
                    }
                });
            }
            $('#grupo_produto_id').on('changed.bs.select', buscarProdutos);
            
            if ($('#grupo_produto_id').val()) {
                buscarProdutos();
            }
        });
    @endpush
@endsection