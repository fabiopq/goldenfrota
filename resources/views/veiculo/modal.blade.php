<head>
    @include('layouts.main_header')
    @yield('head')
</head>

<div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Título do modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('marca_veiculo.store') }}" method="POST">


                    @component('components.form-group', [
                        'inputs' => [
                            [
                                'type' => 'text',
                                'field' => 'marca_veiculo',
                                'label' => 'Marca de Veículo',
                                'required' => true,
                                'autofocus' => true,
                                'inputValue' => isset($marcaVeiculo->marca_veiculo) ? $marcaVeiculo->marca_veiculo : '',
                            ],
                        ],
                    ])
                    @endcomponent

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                <input type="submit" value="Enviar" />
            </div>
        </div>
        </form>
    </div>
</div>
