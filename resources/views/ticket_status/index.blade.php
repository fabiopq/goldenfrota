@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $ticket_status, 
        'model' => 'ticket_status',
        'tableTitle' => 'Ticket Status ',
        'displayField' => 'ticket_status',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection