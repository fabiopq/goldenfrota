@extends('layouts.app')

@section('content')
@component('components.table', [
'captions' => $fields,
'rows' => $movimentacao_creditos,
'model' => 'movimentacao_credito',
'tableTitle' => 'Movimentação de Crédito',
'displayField' => 'id',
'actions' => [


'edit',
'destroy'
],

'searchParms' => 'movimentacao_credito.search_parms'
]);
@endcomponent
@endsection