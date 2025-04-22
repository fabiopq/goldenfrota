@extends('layouts.app')


@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Novo Preço Cliente',
            'routeUrl' => route('preco_cliente.update', $preco_cliente->id),
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
                            'type' => 'select',
                            'field' => 'cliente_id',
                            'label' => 'Cliente',
                            'required' => true,
                            'items' => $clientes,
                            'inputSize' => 5,
                            'displayField' => 'nome_razao',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'defaultNone' => true,
                            'indexSelected' => $preco_cliente->cliente_id,
                        ],
                    ],
                ])
                @endcomponent

                <div id="preco-cliente" class="{{ $errors->has('items') ? ' has-error' : '' }}">
                    <preco-cliente :combustiveis-data="{{ json_encode($combustiveis) }}"
                        :old-data="{{ json_encode(old('items') ?? $preco_cliente->preco_cliente_items) }}"></preco-cliente>
                    @if ($errors->has('items'))
                        <span class="help-block">
                            <strong>{{ $errors->first('items') }}</strong>
                        </span>
                    @endif
                </div>
            @endsection
        @endcomponent
    </div>
    @push('bottom-scripts')
        <script src="{{ mix('js/precocliente.js') }}"></script>
    @endpush

@endsection
