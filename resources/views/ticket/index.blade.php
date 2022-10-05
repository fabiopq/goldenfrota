@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $tickets, 
        'model' => 'ticket',
        'tableTitle' => 'Tickets',
        'displayField' => 'id',
        'actions' => [
            ['action' => 'show', 'target' => '_blank'], 'edit', 'destroy'],
            
            
        ]);
    @endcomponent
@endsection