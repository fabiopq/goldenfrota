<!-- resources/views/modals/cliente.blade.php -->
<div class="modal fade" id="clienteModal" tabindex="-1" role="dialog" aria-labelledby="clienteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="{{ route('cliente.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @component('components.form-group', [
                        'inputs' => [
                            [
                                'type' => 'select',
                                'field' => 'tipo_pessoa_id',
                                'label' => 'Tipo Pessoa',
                                'required' => true,
                                'autofocus' => true,
                                'items' => [''],
                                'inputSize' => 6,
                                'displayField' => 'tipo_pessoa',
                                'keyField' => 'id',
                                'liveSearch' => true,
                            ],
                            [
                                'type' => 'text',
                                'field' => 'nome_razao',
                                'label' => 'Nome/Razão Social',
                                'required' => true,
                                'inputSize' => 6,
                            ],
                        ],
                    ])
                    @endcomponent

                    @component('components.form-group', [
                        'inputs' => [
                            [
                                'type' => 'text',
                                'field' => 'cpf_cnpj',
                                'label' => 'CPF/CNPJ',
                                'required' => true,
                                'inputSize' => 6,
                            ],
                            [
                                'type' => 'text',
                                'field' => 'telefone',
                                'label' => 'Telefone',
                                'inputSize' => 6,
                            ],
                        ],
                    ])
                    @endcomponent
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </form>
    </div>
</div>
