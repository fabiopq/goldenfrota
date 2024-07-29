@extends('layouts.app')


@section('content')
    @component('components.table', [
        'captions' => $fields,
        'rows' => $veiculoStatus,
        'model' => 'veiculo_status',
        'tableTitle' => 'Veiculos Alertas',
        'displayField' => 'placa',
        'actions' => ['edit', 'destroy'],
        'searchParms' => 'veiculo_status.search_params'
    ])
        ;
    @endcomponent
@endsection
