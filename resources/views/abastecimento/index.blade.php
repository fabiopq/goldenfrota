@extends('layouts.app')

@section('content')
    @component('components.table', [
        'captions' => $fields, 
        'rows' => $abastecimentos, 
        'model' => 'abastecimento',
        'tableTitle' => 'Abastecimento',
        'displayField' => 'id',
        'actions' => [
            [
                'action' => 'show', 'target' => '_blank'
            ],
            [
                'custom_action' => 'components.customActions.AfericaoAbastecimento'
            ],
            'edit', 
            'destroy'
            ],
            'colorLineCondition' => 
            [
            'field' => 'inconsistencias_importacao',
            'value' => '1',
            'class' => 'danger'
            ],
            'searchParms' => 'abastecimento.search_parms'
        ]);
    @endcomponent
@endsection