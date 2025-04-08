@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $ticket_prioridade, 
        'model' => 'ticket_prioridade',
        'tableTitle' => 'Ticket Prioridade ',
        'displayField' => 'ticket_prioridade',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection