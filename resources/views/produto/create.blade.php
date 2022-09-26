@extends('layouts.app')

@section('content-no-app')
@if(old('fornecedores'))
{{-- {{ dd(old(str_replace('[]', '', 'fornecedores[]'))) }} --}}
@endif
<div class="card m-0 border-0">
    @component('components.form', [
    'title' => 'Novo Produto',
    'routeUrl' => route('produto.store'),
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
    'field' => 'produto_descricao',
    'label' => 'Descrição',
    'required' => true,
    'autofocus' => true,
    'inputSize' => 6
    ],
    [
    'type' => 'text',
    'field' => 'produto_desc_red',
    'label' => 'Descrição Reduzida',
    'inputSize' => 2,
    'maxLength' => 10
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
    ],
    [
    'type' => 'number',
    'field' => 'valor_custo',
    'label' => 'Preço de Custo',
    'inputSize' => 4
    ],
    [
    'type' => 'number',
    'field' => 'valor_venda',
    'label' => 'Preço de Venda',
    'inputSize' => 4
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
    ],
    [
    'type' => 'number',
    'field' => 'vencimento_dias',
    'label' => 'Vencimento em Dias',
    'readOnly' => true,
    'inputSize' => 3
    ],
    [
    'type' => 'number',
    'field' => 'vencimento_km',
    'label' => 'Vencimento em Km',
    'readOnly' => true,
    'inputSize' => 3
    ],
    [
    'type' => 'number',
    'field' => 'vencimento_horas_trabalhadas',
    'label' => 'Vencimento em Horas/Trabalhadas',
    'readOnly' => true,
    'inputSize' => 3
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
    'inputSize' => 6
    ],
    [
    'type' => 'text',
    'field' => 'codigo_barras',
    'label' => 'Código de Barras',
    'inputSize' => 6
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
            'value' => 'id'
            ])
            @endcomponent
        </div>
        <div class="col-md-8" id="estoque-produto-component">
            {{-- @component('components.input-checklist-group', [
                            'items' => $estoques,
                            'label' => 'estoque',
                            'field' => 'estoques[]',
                            'title' => 'Estoques',
                            'value' => 'id'
                        ])
                        @endcomponent  --}}
            <estoque-produto :estoques-data="{{ json_encode($listaEstoques) }}" :old-data="{{ json_encode(old('estoques')) }}">
                </estoque_produto>
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

var buscarUnidades = function() {
var unidade = {};
console.log($('#unidade_id').val());
unidade.id = $('#unidade_id').val();

console.log(unidade);
$.ajax({
url: '{{ route("unidades.json") }}',
type: 'POST',
data: unidade,
dataType: 'JSON',
cache: false,
success: function (data) {
console.log(data);
$("#unidade_id")
.removeAttr('disabled')
.find('option')
.remove();

$('#unidade_id').append($('<option>', {
    value: -1,
    text : 'NADA SELECIONADO'
    }));
    $.each(data, function (i, item) {
    $('#unidade_id').append($('
<option>', {
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


    
    $('#unidade_id').on('changed.bs.select', buscarUnidades);

    
    @endpush
    @push('bottom-scripts')
    <script src="{{ mix('js/estoqueproduto.js') }}"></script>
    @endpush