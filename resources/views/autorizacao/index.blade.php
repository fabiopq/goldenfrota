@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $autorizacoes, 
        'model' => 'autorizacao',
        'tableTitle' => 'Autorizações',
        'displayField' => 'id',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection