@extends('layouts.app')


@section('content')
    @component('components.table', [
        'captions' => $fields,
        'rows' => $ordem_servicos,
        'model' => 'ordem_servico',
        'tableTitle' => 'Ordens de Serviço',
        'displayField' => 'id',
        'actions' => [
            ['action' => 'show', 'target' => '_blank'],
            'edit',
            'destroy',
            [
                'custom_action' => 'components.customActions.FecharOdemServico'
            ],
            
           // [
           //     'custom_action' => 'components.customActions.FecharOdemServico',
           // ],
        ],
        'searchParms' => 'ordem_servico.search_parms',
        'total' => $totalOrdemServicos,
        'ordemServicoStatus' => $ordemServicoStatus,
        'details' => $detailFields,
    ]);
    @endcomponent
@endsection
