
<div class="modal fade" id="marcaVeiculoModal" tabindex="-1" aria-labelledby="marcaVeiculoModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="grupoVeiculoModalLabel">Cadastrar Marca de Veículos</h5>
               {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <form id="formMarcaVeiculoModal">
                    @csrf
                  
                    @component('components.input-text', [
                        'type' => 'text',
                        'field' => 'marca_veiculo',
                        'name' => 'marcaVeiculo',
                        'id' => 'marcaVeiculo',
                        'label' => 'Marca de Veículos',
                        'required' => true,
                        'autofocus' => true,
                        'inputSize' => 8
                    ])
                    @endcomponent
                    
                    <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" name = "saveMarcaVeiculo" id="saveMarcaVeiculo">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
