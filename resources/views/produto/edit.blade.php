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
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'times']
                ]
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
                            'css' => 'text-uppercase'
                        ],
                        [
                            'type' => 'text',
                            'field' => 'produto_desc_red',
                            'label' => 'Descrição Reduzida',
                            'inputSize' => 2,
                            'maxLength' => 10,
                            'inputValue' => $produto->produto_desc_red,
                            'css' => 'text-uppercase'
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
                            'indexSelected' => $produto->grupo_produto_id
                        ]
                    ]
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
                            'inputSize' => 4,
                            'displayField' => 'unidade',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'indexSelected' => $produto->unidade_id
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor_custo',
                            'label' => 'Preço de Custo',
                            'inputSize' => 4,
                            'inputValue' => $produto->valor_custo
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor_venda',
                            'label' => 'Preço de Venda',
                            'inputSize' => 4,
                            'inputValue' => $produto->valor_venda
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'controla_vencimento',
                            'label' => 'Controla Vencimento',
                            'inputSize' => 3,
                            'items' => Array('Não', 'Sim'),
                            'indexSelected' => $produto->controla_vencimento
                        ],  
                        [
                            'type' => 'number',
                            'field' => 'vencimento_dias',
                            'label' => 'Vencimento em Dias',
                            'inputSize' => 3,
                            'readOnly' => !$produto->controla_vencimento,
                            'inputValue' => $produto->vencimento_dias
                        ],
                        [
                            'type' => 'number',
                            'field' => 'vencimento_km',
                            'label' => 'Vencimento em Km',
                            'inputSize' => 3,
                            'readOnly' => !$produto->controla_vencimento,
                            'inputValue' => $produto->vencimento_km
                        ],
                        [
                            'type' => 'number',
                            'field' => 'vencimento_horas_trabalhadas',
                            'label' => 'Vencimento em Horas/Trabalhadas',
                            'readOnly' => !$produto->controla_vencimento,
                            'inputSize' => 3,
                            'inputValue' => $produto->vencimento_horas_trabalhadas
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'numero_serie',
                            'label' => 'Número de Série',
                            'inputSize' => 6,
                            'inputValue' => $produto->numero_serie
                        ],
                        [
                            'type' => 'text',
                            'field' => 'codigo_barras',
                            'label' => 'Código de Barras',
                            'inputSize' => 6,
                            'inputValue' => $produto->codigo_barras
                        ]
                    ]
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
                            'indexSelected' => $produto->fornecedores()->pluck('fornecedor_id')
                        ])
                        @endcomponent
                    </div>
                    <div class="col-md-8" id="estoque-produto-component">
                        <estoque-produto :estoques-data="{{ json_encode($listaEstoques) }}" :old-data="{{ json_encode((old('estoques')) ? old('estoques') : $estoques) }}"></estoque-produto>                      
                    </div>
                </div>
            @endsection
        @endcomponent
    </div>
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
@endpush
@push('bottom-scripts')
    <script src="{{ mix('js/estoqueproduto.js') }}"></script>
@endpush