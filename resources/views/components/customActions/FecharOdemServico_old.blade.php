


    <a class="btn-success" href="/api/ordem_servico/fechar/158"  formmethod="post">
        <i class="fa fa-bars" data-toggle="tooltip" data-placement="top" title="{{__('Fechar OS')}}" data-original-title="{{__('Fazer Aferição')}}"></i>
    </a>

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
      
       
       
            $.ajax({
            url: '/api/ordem_servico/fechar/158',
            type: 'post',
            data: {
                posto_abastecimentos: status,
                
                 
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


    @endpush

