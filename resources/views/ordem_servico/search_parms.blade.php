@php
       
    $data_inicial = isset($_GET['data_inicial']) ? $_GET['data_inicial'] : date('01/m/Y');
    $data_final = isset($_GET['data_final']) ? $_GET['data_final'] : date('t/m/Y');
    $ordemServicoStatus = isset($_GET['ordem_servico_status']) ? $_GET['ordem_servico_status'] : null;

    $abast_local = isset($_GET['abast_local']) ? $_GET['abast_local'] : -1;
   // $data_inicial = isset($_GET['data_inicial']) ? $_GET['data_inicial'] : null;
   // $data_final = isset($_GET['data_final']) ? $_GET['data_final'] : null;
  
    

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
    'id' => 'ordem_servico_status',
    'name' => 'ordem_servico_status_id',
    'type' => 'select',
    'field' => 'ordem_servico_status_id',
    'label' => 'Status da O.S',
    'sideBySide' => true,
    'inputSize' => 3,
    'items' => $ordemServicoStatus,
    'displayField' => 'ordem_servico_status',
    'keyField' => 'id',
])
@endcomponent
<meta name="csrf-token" content="{{ Session::token() }}">
@push('document-ready')
    $("#tipo_abastecimento :input").change(function() {
    $("#searchForm").submit();
    })

    var buscarOrdemServicoStatus = function() {
        var status = {};

        $.ajax({
            url: '{{ route("ordemservicostatus.json") }}',
            type: 'POST',
            data: {
                ordem_servico_status: status,
                _token: $('meta[name=csrf-token]').attr('content'),
                 
            },
            dataType: 'JSON',
            cache: false,
            success: function (data) {
                console.log(data);
                console.log($('#ordem_servico_status option').length); 
                if (('#ordem_servico_status option').length <= 0){

                    if (data.length > 0) {
                    
                        $("#ordem_servico_status")
                            .removeAttr('disabled')
                            .find('option')
                            .remove();
                    } else {
                        if ($('#ordem_servico_status').val() == -1) {
                            $("#ordem_servico_status").attr('disabled', 'disabled');
                        }
                    }

                }
                

                

                $('#ordem_servico_status').append($('<option>', { 
                        value: -1,
                        text : 'TODOS'
                }));
                $.each(data, function (i, item) {
                    
                    $('#ordem_servico_status').append($('<option>', { 
                        value: item.id,
                        text : item.os_status 
                    }));
                });
                let opts = $('#ordem_servico_status option');
                console.log($('#ordem_servico_status option').length);
                
                @if(old('ordem_servico_status_id'))
                
                $('#ordem_servico_status_id').selectpicker('val', {{old('ordem_servico_status_id')}});
                @endif
                
                $('.selectpicker').selectpicker('refresh');
            }

            
        });                
    }

    {{--  $('#busca').on('changed.bs.select', buscarOrdemServicoStatus);--}}
     window.onload = buscarOrdemServicoStatus();

    {{-- $('#ordem_servico_status').on('changed.bs.select',$("#searchForm").submit()); --}}
  

    {{-- $('#ordem_servico_status').on('changed.bs.select', buscarOrdemServicoStatus); --}}
 

    {{-- $('#busca').on('click', buscarOrdemServicoStatus); --}}
@endpush
