@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Veículo', 
            'routeUrl' => route('veiculo.update', $veiculo->id), 
            'method' => 'PUT',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'check'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'times']
                ]
            ])
            @section('formFields')
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'cliente_id',
                            'label' => 'Cliente',
                            'required' => true,
                            'items' => $clientes,
                            'autofocus' => true,
                            'inputSize' => 7,
                            'displayField' => 'nome_razao',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'indexSelected' => $veiculo->cliente_id
                        ],
                        [
                            'type' => 'select',
                            'field' => 'departamento_id',
                            'label' => 'Departamento',
                            'required' => true,
                            'items' => null,
                            'displayField' => 'departamento',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 4,
                            'indexSelected' => $veiculo->departamento_id
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $veiculo->ativo,
                            'items' => ['Não', 'Sim'],
                        ]
                    ]
                ])
                @endcomponent
                
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'grupo_veiculo_id',
                            'label' => 'Grupo de Veículos',
                            'required' => true,
                            'items' => $grupoVeiculos,
                            'inputSize' => 4,
                            'displayField' => 'grupo_veiculo',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'indexSelected' => $veiculo->grupo_veiculo_id
                        ],
                        [
                            'type' => 'input-btn',
                            'field' => 'grupo_id',
                            'label' => 'Novo',
                            'required' => true,
                            'inputSize' => 1,
                            'displayField' => 'grupo',
                            'keyField' => 'id',
                            'comando' => 'grupoVeiculoModal',
                        ],
                        [
                            'type' => 'text',
                            'field' => 'placa',
                            'label' => 'Placa',
                            'required' => true,
                            'inputSize' => 3,
                            'css' => 'text-uppercase',
                            'inputValue' => $veiculo->placa
                        ],
                        [
                            'type' => 'text',
                            'field' => 'tag',
                            'label' => 'TAG',
                            'inputSize' => 3,
                            'inputValue' => $veiculo->tag
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'marca_veiculo_id',
                            'label' => 'Marca',
                            'required' => true,
                            'items' => $marcaVeiculos,
                            'inputSize' => 5,
                            'displayField' => 'marca_veiculo',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'indexSelected' => $marcaVeiculo
                        ],
                        [
                            'type' => 'select',
                            'field' => 'modelo_veiculo_id',
                            'label' => 'Modelo',
                            'required' => true,
                            'items' => $modeloVeiculos,
                            'inputSize' => 5,
                            'displayField' => 'modelo_veiculo',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'indexSelected' => $veiculo->modelo_veiculo_id
                        ],
                        [
                            'type' => 'number',
                            'field' => 'ano',
                            'label' => 'Ano',
                            'inputSize' => 2,
                            'inputValue' => $veiculo->ano
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'renavam',
                            'label' => 'Renavam',
                            'inputSize' => 3,
                            'inputValue' => $veiculo->renavam
                        ],
                        [
                            'type' => 'text',
                            'field' => 'chassi',
                            'label' => 'Chassi',
                            'inputSize' => 3,
                            'inputValue' => $veiculo->chassi
                        ],
                      
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                      
                        [
                            'type' => 'number',
                            'field' => 'hodometro',
                            'label' => 'Km',
                            'inputSize' => 2,
                            'inputValue' => $veiculo->hodometro
                        ],
                        [
                            'type' => 'select',
                            'field' => 'hodometro_decimal',
                            'label' => 'Km Decimal',
                            'inputSize' => 1,
                            'indexSelected' => $veiculo->hodometro_decimal,
                            'items' => ['Não', 'Sim'],
                        ],
                        [
                            'type' => 'number',
                            'field' => 'media_minima',
                            'label' => 'Média Mínima',
                            'inputSize' => 2,
                            'inputValue' => $veiculo->media_minima
                        ],
                        [
                            'type' => 'number',
                            'field' => 'media_atual',
                            'label' => 'Média Atual',
                            'inputSize' => 2,
                            'inputValue' => $veiculo->media_atual
                        ],
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
    
    <div id="visulUsuarioModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visulUsuarioModalLabel">Detalhes do Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="visul_usuario"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-info" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    
    <div id="addGrupoVeiculoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGrupoVeiculoModalLabel">Cadastrar Grupo Veículo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="insert_form">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nome</label>
                            <div class="col-sm-10">
                                <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome do Grupo">
                            </div>
                        </div>
                                                
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <input type="submit" name="CadUser" id="CadUser" value="Cadastrar" class="btn btn-outline-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        var qnt_result_pg = 50; //quantidade de registro por página
        var pagina = 1; //página inicial
        $(document).ready(function () {
            listar_usuario(pagina, qnt_result_pg); //Chamar a função para listar os registros
        });
        
        function listar_usuario(pagina, qnt_result_pg){
            var dados = {
                pagina: pagina,
                qnt_result_pg: qnt_result_pg
            }
            $.post('listar_usuario.php', dados , function(retorna){
                //Subtitui o valor no seletor id="conteudo"
                $("#conteudo").html(retorna);
            });
        }
        
        $(document).ready(function(){
            $(document).on('click','.view_data', function(){
                var user_id = $(this).attr("id");
                //alert(user_id);
                //Verificar se há valor na variável "user_id".
                if(user_id !== ''){
                    var dados = {
                        user_id: user_id
                    };
                    $.post('visualizar.php', dados, function(retorna){
                        //Carregar o conteúdo para o usuário
                        $("#visul_usuario").html(retorna);
                        $('#visulUsuarioModal').modal('show'); 
                    });
                }
            });
            
            $('#addGrupoVeiculoModal').on('submit', function(event){
                event.preventDefault();
                //Receber os dados do formulário
                
                var request = $("#insert_form").serialize();
                $.post("grupo_veiculo.store")[]{
                                       
                });
            });
        });
    </script>

@include('grupo_veiculo.modal')
<meta name="csrf-token" content="{{ Session::token() }}">

@endsection

@push('document-ready')
    $('#placa').mask('SSS-9AA9', {placeholder: '___-____'});
            
    var buscarDepartamentos = function() {
        var departamento = {};

        departamento.id = $('#cliente_id').val();
        departamento._token = $('input[name="_token"]').val();

        console.log(departamento);
        $.ajax({
            url: '{{ route("departamentos.json") }}',
            type: 'POST',
            data: departamento,
            dataType: 'JSON',
            cache: false,
            success: function (data) {
                console.log(data);
                $("#departamento_id")
                    .removeAttr('disabled')
                    .find('option')
                    .remove();

                $('#departamento_id').append('<option disabled selected value style="display:none"> Nada Selecionado </option>');

                $.each(data, function (i, item) {
                    $('#departamento_id').append($('<option>', { 
                        value: item.id,
                        text : item.departamento 
                    }));
                });
                
                @if(old('departamento_id'))
                $('#departamento_id').selectpicker('val', {{old('departamento_id')}});
                @else
                $('#departamento_id').selectpicker('val', {{$veiculo->departamento_id}});
                @endif

                $('.selectpicker').selectpicker('refresh');
            }
        });
    }

    var buscarModeloVeiculos = function() {
        var marca = {};

        marca.id = $('#marca_veiculo_id').val();
        marca._token = $('input[name="_token"]').val();

        console.log(marca);
        $.ajax({
            url: '{{ route("modelo_veiculos.json") }}',
            type: 'POST',
            data: marca,
            dataType: 'JSON',
            cache: false,
            success: function (data) {
                console.log(data);
                $("#modelo_veiculo_id")
                    .removeAttr('disabled')
                    .find('option')
                    .remove();


                $.each(data, function (i, item) {
                    $('#modelo_veiculo_id').append($('<option>', { 
                        value: item.id,
                        text : item.modelo_veiculo 
                    }));
                });

                @if(old('modelo_veiculo_id'))
                $('#modelo_veiculo_id').selectpicker('val', {{old('modelo_veiculo_id')}});
                @endif

                $('.selectpicker').selectpicker('refresh');
            }
        });
    }

    $('#saveGrupoVeiculo').click(function() {
        var grupoNome = $('#grupoVeiculo').val();
       
        console.log(grupoNome);
        $.ajax({
            url: "{{ route('grupo_veiculo.store') }}",
            method: 'POST',
            data: {
                grupo_veiculo: grupoNome,
                _token: $('meta[name=csrf-token]').attr('content'),
                 
            },
            
            success: function(response) {
            
                buscarGrupoVeiculo();
                $('#grupoVeiculoModal').modal('hide');
               
                {{-- $('#unidade_id').append('<option value="' + response.id + '">' + response
                //     .name + '</option>');
                // $('#unidade_id').val(response.id);
                --}}
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseJSON.message);
                
            }
        });
    });

    var buscarGrupoVeiculo = function() {
        var grupo = {};

       

        $.ajax({
            url: '{{ route("grupo_veiculos.json") }}',
            type: 'POST',
            
            data: {
                grupo_veiculo: grupo,
                _token: $('meta[name=csrf-token]').attr('content'),
                 
            },
            dataType: 'JSON',
            cache: false,
            success: function (data) {
                console.log(data);
                if (data.length > 0) {
                    $("#grupo_veiculo_id")
                        .removeAttr('disabled')
                        .find('option')
                        .remove();
                } else {
                    if ($('#grupo_veiculo_id').val() == -1) {
                        $("#grupo_veiculo_id").attr('disabled', 'disabled');
                    }
                }

                $('#grupo_veiculo_id').append($('<option>', { 
                        value: -1,
                        text : 'NADA SELECIONADO'
                }));
                $.each(data, function (i, item) {
                    $('#grupo_veiculo_id').append($('<option>', { 
                        value: item.id,
                        text : item.grupo_veiculo 
                    }));
                });
                
                @if(old('grupo_veiculo_id'))
                $('#grupo_veiculo_id').selectpicker('val', {{old('grupo_veiculo_id')}});
                @endif

                $('.selectpicker').selectpicker('refresh');
            }

            
        });   
    }

    $('#cliente_id').on('changed.bs.select', buscarDepartamentos);
    $('#marca_veiculo_id').on('changed.bs.select', buscarModeloVeiculos);
    
    if ($('#marca_veiculo_id').val()) {
        buscarModeloVeiculos();
    }

    if ($('#cliente_id').val()) {
        buscarDepartamentos();
    }

@endpush
