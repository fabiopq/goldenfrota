@extends('layouts.app_sem_main')
@section('content')
<div class="panel-sm">
    <div class="panel-sm">
        <div class="card-header report-subtitle-1">
            <h5> Consulta Saldo: </h5>
        </div>
        <div class="card-body">

            <div class="panel-sm">
                <form class="form-horizontal" id="consultar-form">
               
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cpf">CPF:</label>
                        <div class="col-sm-10">
                            <input type="text" name="cpf" class="form-control" id="cpf" placeholder="Digite o CPF do cliente">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="Cliente">Cliente:</label>
                        <div class="col-sm-10">
                            <input type="text" name="nome" class="form-control" id="nome" placeholder="Cliente">
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
                            <button  id="btn-consultar" name="btn-consultar" class="btn btn-success">Buscar</button>
                        </div>
                    </div>
                   



                </form>
               
               

            </div>

        </div>
    </div>

    @push('document-ready')
        $(document).ready(function() {
            $('#btn-consultar').click(function() {
                var cpf = $('#cpf').val();
                var marca = {};

                marca.cpf = $('#cpf').val();
                marca._token = $('input[name="_token"]').val();

                $.ajax({
                    url: '{{ route("saldo.json") }}',
                    type: 'POST',
                    data:marca,
                    success: function(data) {
                        $('#saldo').val('500');
                        $('#saldo').val(data.saldo.toFixed(2)); // Formatar o saldo como moeda
                    },
                    error: function() {
                        alert('Erro ao consultar o cliente.');
                    }
                });
            });
            
            
            
        });
    @endpush
    
    @endsection