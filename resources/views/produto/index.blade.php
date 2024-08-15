@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $produtos, 
        'model' => 'produto',
        'tableTitle' => 'Produtos',
        'displayField' => 'produto_descricao',
        'actions' => [
            [
                'custom_action' => 'components.customActions.PosicaoEstoqueProduto',
                'target' => '_blank'
            ],
            'edit',
            'destroy'
        ]]);
    @endcomponent
@endsection