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
'inputSize' => 4,
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
'inputSize' => 4,
'dateTimeFormat' => 'DD/MM/YYYY',
'picker_begin' => 'data_inicial',
'picker_end' => 'data_final',
'inputValue' => $data_final
])
@endcomponent
<div class="col-sm-12 col-md-3 col-lg-3">
    <div class="form-group">
        @component('components.label', ['label' => 'Tipo de Movimentação', 'field' => $abast_local])
        @endcomponent
        <div class="input-group">
            <div id="tipo_abastecimento" class="btn-group btn-group-toggle" data-toggle="buttons">
                <buttom class="btn btn-secondary {{$abast_local == 1 ? ' active' : ''}}">
                    <input type="radio" name="abast_local" id="abast_local" value="1"> Entradas
                </buttom>
                <buttom class="btn btn-secondary {{$abast_local == 0 ? ' active' : ''}}">
                    <input type="radio" name="abast_local" id="abast_externo" value="0"> Saidas
                </buttom>
                <buttom class="btn btn-secondary {{$abast_local == -1 ? ' active' : ''}}">
                    <input type="radio" name="abast_local" id="abast_todos" value="-1"> Todos
                </buttom>
                <a class="btn btn-primary" id="ir-para-renovar" role="button" data-toggle="modal" data-target="#confirmDelete">Renovar</a>




                <div class="modal" tabindex="-1" id="confirmDelete" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="confirm"><i class="fas fa-thumbs-up"></i> Sim</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-thumbs-down"></i> Não</button>

                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    document.getElementById('confirm').addEventListener('click', function() {
                        window.location.href = "/renovar";
                    });
                </script>

            </div>
        </div>
    </div>
</div>
@push('document-ready')
$("#tipo_abastecimento :input").change(function() {
$("#searchForm").submit();
})
@endpush