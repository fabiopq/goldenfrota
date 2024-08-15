
<div class="modal fade" id="grupoVeiculoModal" tabindex="-1" aria-labelledby="grupoVeiculoModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="grupoVeiculoModalLabel">Cadastrar Grupo de Veículos</h5>
               {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <form id="formGrupoVeiculoModal">
                    @csrf
                  
                    @component('components.input-text', [
                        'type' => 'text',
                        'field' => 'grupo_veiculo',
                        'name' => 'grupoVeiculo',
                        'id' => 'grupoVeiculo',
                        'label' => 'Grupo de Veículos',
                        'required' => true,
                        'autofocus' => true,
                        'inputSize' => 8
                    ])
                    @endcomponent
                    
                    <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" name = "saveGrupoVeiculo" id="saveGrupoVeiculo">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
