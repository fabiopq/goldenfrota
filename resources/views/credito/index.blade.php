@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $creditos, 
        'model' => 'credito',
        'tableTitle' => 'Crédito',
        'displayField' => 'descricao',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection