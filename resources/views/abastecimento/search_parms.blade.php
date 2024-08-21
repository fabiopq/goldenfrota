@php
    $abast_local = isset($_GET['abast_local']) ? $_GET['abast_local'] : -1;
    $data_inicial = isset($_GET['data_inicial']) ? $_GET['data_inicial'] : null;
    $data_final = isset($_GET['data_final']) ? $_GET['data_final'] : null;
  
@endphp
@component('components.input-datetime', [
    'id' => 'data_inicial',
    'name' => 'data_inicial',
    'field' => 'data_inicial',
    'label' => 'Data Inicial',
    'inputSize' => 3,
    'dateTimeFormat' => 'DD/MM/YYYY',
    'picker_begin' => 'data_inicial',
    'picker_end' => 'data_final',
    'inputValue' => $data_inicial
])
@endcomponent
@component('components.input-datetime', [
    'id' => 'data_final',
    'name' => 'data_final',
    'field' => 'data_final',
    'label' => 'Data Final',
    'inputSize' => 3,
    'dateTimeFormat' => 'DD/MM/YYYY',
    'picker_begin' => 'data_inicial',
    'picker_end' => 'data_final',
    'inputValue' => $data_final
])
@endcomponent
<div class="col-sm-12 col-md-3 col-lg-3">                   
    <div class="form-group">
        @component('components.label', ['label' => 'Tipo de Abastecimento', 'field' => $abast_local])
        @endcomponent
        <div class="input-group">
            <div id="tipo_abastecimento" class="btn-group btn-group-toggle" data-toggle="buttons" >
                <buttom class="btn btn-secondary {{$abast_local == 1 ? ' active' : ''}}">
                    <input type="radio" name="abast_local" id="abast_local" value="1"> Local
                </buttom>
                <buttom class="btn btn-secondary {{$abast_local == 0 ? ' active' : ''}}">
                    <input type="radio" name="abast_local" id="abast_externo" value="0"> Externo
                </buttom>
                <buttom class="btn btn-secondary {{$abast_local == -1 ? ' active' : ''}}">
                    <input type="radio" name="abast_local" id="abast_todos" value="-1"> Todos
                </buttom>
            </div>
        </div>
    </div>
</div>
@push('document-ready')
    $("#tipo_abastecimento :input").change(function() {
        $("#searchForm").submit();
    })
@endpush