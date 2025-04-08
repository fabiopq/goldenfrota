@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $ticket_prioriedade, 
        'model' => 'ticket_prioriedade',
        'tableTitle' => 'Ticket Prioriedade ',
        'displayField' => 'ticket_prioriedade',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection