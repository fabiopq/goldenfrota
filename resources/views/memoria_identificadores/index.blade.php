@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $memoria_identificadores, 
        'model' => 'memoria_identificadores',
        'tableTitle' => 'Mostoristas',
        'displayField' => 'nome',
        'actions' => ['edit', 'destroy'],
       
        
        ]);
    @endcomponent
@endsection