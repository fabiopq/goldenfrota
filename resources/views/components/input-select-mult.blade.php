@php
    $inputSize = isset($inputSize) ? '-'.$inputSize : '-12';
    $disabled = isset($disabled) ? $disabled : false;
    $autofocus = isset($autofocus) ? $autofocus : false;
    $required = isset($required) ? $required : false;
    $css = isset($css) ? $css : '';
    $indexSelected = isset($indexSelected) ? (array) $indexSelected : [];
    $liveSearch = isset($liveSearch) ? $liveSearch : false;
    $defaultNone = isset($defaultNone) ? $defaultNone : false;
    $vModel = isset($vModel) ? $vModel : false;
    $div_css = isset($div_css) ? $div_css : '';
    $searchById = isset($searchById) ? $searchById : true;
    
    // Adicionando a variável para seleção múltipla e checkboxes
    $multiple = true;
    $fieldName = $name.'[]';
    
    // As variáveis `keyField` e `displayField` precisam ser definidas
    $keyField = isset($keyField) ? $keyField : 'id';
    $displayField = isset($displayField) ? $displayField : 'name';
@endphp

<div class="col col-sm col-md{{$inputSize}} col-lg{{$inputSize}} {{ $errors->has($field) ? ' has-error' : '' }} {{$div_css}}">
    @if(isset($label))
        @component('components.label', ['label' => $label, 'field' => $field, 'required' => $required])
        @endcomponent
    @endif
    
    <select ref="{{'ref_'.$name}}" 
     class="form-control selectpicker {{$css}} custom-select-btn" 
     {{ ($vModel) ? 'v-model='.$vModel : '' }} 
     data-none-selected-text="{{__('strings.NothingSelected')}}" 
     data-style="btn-secondary" 
     {{ $liveSearch ? 'data-live-search=true' : '' }} 
     id="{{$id}}" 
     name="{{$fieldName}}" 
     {{ $required ? 'required' : '' }} 
     {{ $autofocus ? 'autofocus' : '' }} 
     {{ $disabled ? 'disabled="disabled"' : '' }} 
     multiple
     data-actions-box="true" 
     data-select-all-text="Selecionar Todos"
     data-deselect-all-text="Remover Seleção"
     data-selected-text-format="count > 2">
        
        @if(isset($items))
            {{-- Adicionando a opção "Nenhum Selecionado" apenas se não for seleção múltipla --}}
            @if($defaultNone && !$multiple)
                <option selected value="">{{__('strings.NothingSelected')}}</option>
            @endif
            
            @if(is_array($items) && is_string(key($items)))
                {{-- Lógica para arrays associativos --}}
                @foreach($items as $key => $value)
                    <option value="{{ $key }}" {{ in_array($key, $indexSelected) ? 'selected' : '' }}>
                        {{ (($searchById) ? $key . ' - ' : '') . $value }}
                    </option>
                @endforeach
            @else
                {{-- Lógica para coleções de objetos (aqui está a correção) --}}
                @foreach($items as $item)
                    {{-- Verifica se a propriedade existe antes de tentar acessá-la --}}
                    @php
                        $itemKey = isset($item->$keyField) ? $item->$keyField : null;
                        $itemDisplay = isset($item->$displayField) ? $item->$displayField : '';
                    @endphp
                    <option value="{{ $itemKey }}" {{ in_array($itemKey, $indexSelected) || ($itemKey == old($field)) ? 'selected' : '' }}>
                        {{ (($searchById) ? $itemKey . ' - ' : '') . $itemDisplay }}
                    </option>
                @endforeach
            @endif
        @endif
    </select>

    @if ($errors->has($field))
        <span class="invalid-feedback d-block">
            <strong>{{ $errors->first($field) }}</strong>
        </span>
    @endif
</div>