@php
    $inputSize = isset($inputSize) ? '-' . $inputSize : '-12';

    $items = isset($items) ? $items : false;
    $disabled = isset($disabled) ? $disabled : false;
    $autofocus = isset($autofocus) ? $autofocus : false;
    $required = isset($required) ? $required : false;
    $css = isset($css) ? $css : '';
    $defaultValue = isset($defaultValue) ? $defaultValue : false;

    switch ($action) {
        case 'search':
            $btn_style = 'btn-primary';
            $btn_icon = 'search';
            $tooltip = 'Pesquisar';
            // $permission = 'listar-' . str_replace('_', '-', $model);
            break;
        case 'edit':
            $btn_style = 'btn-warning';
            $btn_icon = 'edit';
            $tooltip = 'Editar';
            // $permission = 'alterar-' . str_replace('_', '-', $model);
            break;
        case 'destroy':
            $btn_style = 'btn-danger';
            $btn_icon = 'trash-alt';
            $tooltip = 'Remover';
            // $permission = 'excluir-' . str_replace('_', '-', $model);
            break;
        case 'create':
            $btn_style = 'btn-success';
            $btn_icon = 'plus';
            $tooltip = 'Novo';
            // $permission = 'excluir-' . str_replace('_', '-', $model);
            break;
    }

@endphp


<div class="col-auto">
    <div
        class="col col-sm col-md{{ $inputSize }} col-lg{{ $inputSize }} {{ $errors->has($field) ? ' has-error' : '' }}">
        @if (isset($label))
            @component('components.label', ['label' => $label, 'field' => $field, 'required' => $required])
            @endcomponent
        @endif

        <div class="input-group">
            <div id="{{ $field }}" class="btn-group btn-group-toggle" >

                <button type="button" class="btn btn-sm {{ $btn_style }}" data-toggle="modal" title="{{ $tooltip }}"
                data-original-title="{{ $tooltip }}" data-target="#{{ $comando }}">
                    <i class="fas fa-{{ $btn_icon }}"></i>
                </button>
            </div>
        </div>
    </div>


</div>
