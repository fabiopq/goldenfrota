@php
    $inputSize = isset($inputSize) ? '-' . $inputSize : '-12';

    $items = isset($items) ? $items : false;
    $disabled = isset($disabled) ? $disabled : false;
    $autofocus = isset($autofocus) ? $autofocus : false;
    $required = isset($required) ? $required : false;
    $css = isset($css) ? $css : '';
    $defaultValue = isset($defaultValue) ? $defaultValue : false;

@endphp


<div class="col-auto">
    <div
        class="col col-sm col-md{{ $inputSize }} col-lg{{ $inputSize }} {{ $errors->has($field) ? ' has-error' : '' }}">
        @if (isset($label))
            @component('components.label', ['label' => $label, 'field' => $field, 'required' => $required])
            @endcomponent
        @endif

        <div class="input-group">
            <div id="{{ $field }}" class="btn-group btn-group-toggle" data-toggle="buttons">

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{ $comando }}">
                    +
                </button>
            </div>
        </div>
    </div>


</div>
