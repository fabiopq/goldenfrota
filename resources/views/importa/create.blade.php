@extends('layouts.app')

@section('content')
@if (Session::has('success'))
	<div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ Session::get('success') }}
    </div>
@endif
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Importar Dados', 
            'routeUrl' => route('importa.store'), 
            'method' => 'POST',
            'fileUpload' => true,
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'check'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'times']
                ]
            ])
            @section('formFields')
               
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'file',
                            'field' => 'arquivo',
                            'label' => 'Grupo Produto',
                            'required' => true,
    ],
    [
                            'type' => 'file',
                            'field' => 'arquivo_servico',
                            'label' => 'Servico',
                            'required' => true,
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection