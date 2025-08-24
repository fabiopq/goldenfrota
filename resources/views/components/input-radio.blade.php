{{--
    Componente para renderizar um grupo de botões de rádio.
    Para que os botões de rádio funcionem como um grupo (onde apenas um pode ser
    selecionado por vez), todos eles devem ter o mesmo atributo `name`.
    Este componente gerencia isso automaticamente, então você deve passar todas
    as opções para um único componente de rádio.

    Parâmetros esperados:
    - field: O nome do campo do formulário.
    - label: O rótulo para o grupo de botões de rádio.
    - inputSize: O tamanho da coluna na grade (1-12).
    - options: Um array de objetos, onde cada objeto tem 'value' e 'label'.
    - inputValue: O valor que deve estar selecionado por padrão.
    - disabled: Booleano para desabilitar o grupo de botões.
    - name: O atributo 'name' para o input de rádio.
    - id: O atributo 'id' base para o grupo.
    - css: Classes CSS adicionais para o input.
    - div_css: Classes CSS adicionais para a div principal.
    - vModel: O nome da variável Vue.js para biding.
    - visible: Booleano para controlar a visibilidade da div.
--}}
@php
    // Definição de valores padrão para evitar erros de "Undefined index"
    $inputSize = isset($inputSize) ? $inputSize : '12';
    $options = isset($options) ? $options : [];
    $inputValue = isset($inputValue) ? $inputValue : null;
    $disabled = isset($disabled) ? $disabled : false;
    $name = isset($name) ? $name : $field;
    $id = isset($id) ? $id : $field;
    $css = isset($css) ? $css : '';
    $div_css = isset($div_css) ? $div_css : '';
    $vModel = isset($vModel) ? $vModel : false;
    $visible = isset($visible) ? $visible : true;
@endphp

<div class="col-md-{{ $inputSize }} {{ $div_css }}" @if(!$visible) style="display: none;" @endif>
    <div class="form-group">
        @if(isset($label))
            @component('components.label', ['label' => $label, 'field' => $field])
            @endcomponent
        @endif
        <div class="input-group">
            {{-- Adicionado d-flex e flex-wrap para exibir as opções na horizontal --}}
            <div class="d-flex flex-wrap">
                @foreach ($options as $option)
                    <div class="custom-control custom-radio mr-3 {{ $css }}">
                        <input
                            type="radio"
                            id="{{ $id }}_{{ $option['value'] }}"
                            name="{{ $name }}"
                            class="custom-control-input"
                            value="{{ $option['value'] }}"
                            autocomplete="off"
                            {{-- O botão de rádio só será "checado" se o $inputValue corresponder ao $option['value'] --}}
                            @if ($inputValue == $option['value']) checked @endif
                            @if ($disabled) disabled @endif
                            @if ($vModel) v-model="{{ $vModel }}" @endif
                        >
                        <label class="custom-control-label" for="{{ $id }}_{{ $option['value'] }}">
                            {{ $option['label'] }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        @if ($errors->has($field))
            <span class="help-block">{{ $errors->first($field) }}</span>
        @endif
    </div>
</div>