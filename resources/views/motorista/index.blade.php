@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $motoristas, 
        'model' => 'motorista',
        'tableTitle' => 'Mostoristas',
        'displayField' => 'nome',
        'actions' => ['edit', 'destroy'],
       
        
        ]);
    @endcomponent
@endsection