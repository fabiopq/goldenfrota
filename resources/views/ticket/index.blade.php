@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $tickets, 
        'model' => 'ticket',
        'tableTitle' => 'Tickets',
        'displayField' => 'id',
        'actions' => ['edit', 'destroy'],
        'searchParms' => 'ticket.search_parms', 
       
    ]);
    @endcomponent
@endsection