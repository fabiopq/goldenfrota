@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $movimentacao_creditos, 
        'model' => 'movimentacao_credito',
        'tableTitle' => 'Movimentação de Creditos',
        'displayField' => 'id',
        'actions' => ['edit', 'destroy'],
        'searchParms' => 'abastecimento.search_parms'
        
        ]);
    @endcomponent
@endsection