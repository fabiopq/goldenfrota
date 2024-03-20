@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Configurações do Sistema', 
            'routeUrl' => route('setting.update'), 
            'method' => 'PUT',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'check'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'times']
                ]
            ])
            @section('formFields')
                @foreach ($groups as $group) 
                    <div class="card">
                        <div class="card-header">
                            <strong>{{ $group->group_name }}</strong>
                        </div>
                        <div class="card-body">
                        @foreach ($group->settings()->get() as $setting)
                            @if ($setting->data_type == 'string') 
                                @component('components.form-group', [
                                    'inputs' => [
                                        [
                                            'type' => 'text',
                                            'field' => 'groups['.$group->id.']['.$setting->key.']',
                                            'label' => $setting->description,
                                            'inputValue' => $setting->value
                                        ]
                                    ]
                                ])
                                @endcomponent
                            @endif                
                            @if ($setting->data_type == 'integer' || $setting->data_type == 'double') 
                                @component('components.form-group', [
                                    'inputs' => [
                                        [
                                            'type' => 'number',
                                            'field' => 'groups['.$group->id.']['.$setting->key.']',
                                            'label' => $setting->description,
                                            'inputValue' => $setting->value
                                        ]
                                    ]
                                ])
                                @endcomponent
                            @endif
                            @if ($setting->data_type == 'boolean') 
                                @component('components.form-group', [
                                    'inputs' => [
                                        [
                                            'type' => 'select',
                                            'field' => 'groups['.$group->id.']['.$setting->key.']',
                                            'label' => $setting->description,
                                            'items' => array('Não', 'Sim'),
                                            'indexSelected' => $setting->value,
                                            'inputSize' => 2,
                                        ]
                                    ]
                                ])
                                @endcomponent
                            @endif
                        @endforeach
                        </div>
                    </div>
                @endforeach
            @endsection
        @endcomponent
    </div>
@endsection