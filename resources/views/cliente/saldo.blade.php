@extends('layouts.base')


<div class="panel-sm">
    <div class="panel-sm">
        <div class="card-header report-subtitle-1">
            <h5> Consulta Saldo: </h5>
        </div>
        <div class="card-body">

            <div class="panel-sm">
                <form class="form-horizontal" id="consultar-form">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cpf">CPF:</label>
                        <div class="col-sm-10">
                            <input type="text" name="cpf" class="form-control" id="cpf" placeholder="Digite o CPF do cliente">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="saldo">Saldo:</label>
                        <div class="col-sm-10">
                            <input type="text" name="saldo" class="form-control" id="saldo" placeholder="R$ 0,00">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Buscar</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>

@push('document-ready')


        
        var buscarDadosBico = function() {  
            var bico = {};

            bico.id = $('#cpf').val();
            bico._token = $('input[name="_token"]').val();

            $.ajax({
                url: '{{ route("saldo.json") }}',
                type: 'POST',
                data: bico,
                dataType: 'JSON',
                cache: false,
                success: function (data) {
                    $("#saldo").val(data.saldo);
                   
                    $("#saldo").focus();


                },
                error: function (data) {
                }
            });
        }

        $('#cpf').on('keyup', () => {
            buscarDadosBico(); 
            
        });
        $('#cpf').on('blur', () => {
            buscarDadosBico(); 
            
        });
 
@endpush
