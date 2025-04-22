@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $precoclientes, 
        'model' => 'preco_cliente',
        'tableTitle' => 'Preços Clientes',
        'displayField' => 'id',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection