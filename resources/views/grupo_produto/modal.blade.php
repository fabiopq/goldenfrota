
<div class="modal fade" id="grupoProdutoModal" tabindex="-1" aria-labelledby="grupoProdutoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="grupoProdutoModalLabel">Cadastrar Grupo Produto</h5>
               {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <form id="formGrupoProdutoModal">
                    @csrf
                  
                    @component('components.input-text', [
                        'type' => 'text',
                        'field' => 'grupoProduto',
                        'name' => 'grupoProduto',
                        'id' => 'grupoProduto',
                        'label' => 'Grupo',
                        'required' => true,
                        'autofocus' => true,
                        'inputSize' => 8
                    ])
                    @endcomponent
                    
                    <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" name = "saveGrupo" id="saveGrupo">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
