@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $posto_abastecimentos, 
        'model' => 'posto_abastecimento',
        'tableTitle' => 'Nome',
        'displayField' => 'nome',
        'actions' => ['edit', 'destroy']
        ]);
    @endcomponent
@endsection