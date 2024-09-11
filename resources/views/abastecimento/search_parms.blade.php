@php
    $abast_local = isset($_GET['abast_local']) ? $_GET['abast_local'] : -1;
    $data_inicial = isset($_GET['data_inicial']) ? $_GET['data_inicial'] : null;
    $data_final = isset($_GET['data_final']) ? $_GET['data_final'] : null;
    $posto_abastecimentos = isset($_GET['posto_abastecimentos']) ? compact($_GET['posto_abastecimentos']) : null;

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
    'inputValue' => $data_inicial,
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
    'inputValue' => $data_final,
])
@endcomponent

@component('components.input-select', [
    'id' => 'posto_abastecimentos',
    'name' => 'posto_abastecimentos_id',
    'type' => 'select',
    'field' => 'posto_abastecimentos_id',
    'label' => 'Posto Abastecimentos',
    'sideBySide' => true,
    'inputSize' => 3,
    'items' => $posto_abastecimentos,
    'displayField' => 'nome',
    'keyField' => 'id',
    'defaultNone' => false,
])
@endcomponent
<div class="col-sm-12 col-md-3 col-lg-3">
    <div class="form-group">
        @component('components.label', ['label' => 'Tipo de Abastecimento', 'field' => $abast_local])
        @endcomponent
        <div class="input-group">
            <div id="tipo_abastecimento" class="btn-group btn-group-toggle" data-toggle="buttons">
                <buttom class="btn btn-secondary {{ $abast_local == 1 ? ' active' : '' }}">
                    <input type="radio" name="abast_local" id="abast_local" value="1"> Local
                </buttom>
                <buttom class="btn btn-secondary {{ $abast_local == 0 ? ' active' : '' }}">
                    <input type="radio" name="abast_local" id="abast_externo" value="0"> Externo
                </buttom>
                <buttom class="btn btn-secondary {{ $abast_local == -1 ? ' active' : '' }}">
                    <input type="radio" name="abast_local" id="abast_todos" value="-1"> Todos
                </buttom>
            </div>
        </div>
    </div>
</div>
<meta name="csrf-token" content="{{ Session::token() }}">
@push('document-ready')
$("#tipo_abastecimento :input").change(function() {
    $("#searchForm").submit();
    })

    var theValue = '<?php echo isset($_GET['posto_abastecimentos_id']) ? $_GET['posto_abastecimentos_id'] : -1; ?>';
    console.log('theValue');
    console.log(theValue);
    

    $(document).ready(function() {
      
       $("#posto_abastecimentos_id").val('theValue');
   });

    var buscarOrdemServicoStatus = function() {
       
        var status = {};
        let opts = $("posto_abastecimentos option");
         console.log(opts.length);
      
       
        console.log('nulo');
            $.ajax({
            url: '{{ route("postoabastecimentos.json") }}',
            type: 'POST',
            data: {
                posto_abastecimentos: status,
                _token: $('meta[name=csrf-token]').attr('content'),
                 
            },
            dataType: 'JSON',
            cache: false,
            success: function (data) {
                console.log(data);
                console.log($('#posto_abastecimentos option').length); 
                if (('#posto_abastecimentos option').length <= 0){

                    if (data.length > 0) {
                    
                        $("#posto_abastecimentos")
                            .removeAttr('disabled')
                            .find('option')
                            .remove();
                    } else {
                        if ($('#posto_abastecimentos').val() == -1) {
                            $("#posto_abastecimentos").attr('disabled', 'disabled');
                        }
                    }

                }
                

                

                $('#posto_abastecimentos').append($('<option>', { 
                        value: -1,
                        text : 'TODOS'
                }));
                $.each(data, function (i, item) {
                    
                    $('#posto_abastecimentos').append($('<option>', { 
                        value: item.id,
                        text : item.nome 
                    }));
                });
                
                
                @if(old('posto_abastecimentos_id'))
                
                $('#posto_abastecimentos_id').selectpicker('val', {{old('posto_abastecimentos_id')}});
                @endif
                
                $('.selectpicker').selectpicker('refresh');
                $('.selectpicker').selectpicker('val', theValue);
               
            }
        
           
        }); 
         
      
           
    }

    {{--  $('#busca').on('changed.bs.select', buscarOrdemServicoStatus);--}}
    
    window.onload = buscarOrdemServicoStatus(); 
    {{-- $('#ordem_servico_status').on('changed.bs.select',$("#searchForm").submit()); --}}
  

    {{-- $('#ordem_servico_status').on('changed.bs.select', buscarOrdemServicoStatus); --}}
 

    {{-- $('#busca').on('click', buscarOrdemServicoStatus); --}}

        @endpush
