
<div class="modal fade" id="unidadeModal" tabindex="-1" aria-labelledby="grupoProdutoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="grupoProdutoModalLabel">Cadastrar Unidade</h5>
               {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <form id="formUnidade">
                    @csrf
                  
                    @component('components.input-text', [
                        'type' => 'text',
                        'field' => 'unidade',
                        'name' => 'unidadeNome',
                        'id' => 'unidadeNome',
                        'label' => 'Unidade',
                        'required' => true,
                        'autofocus' => true,
                        'inputSize' => 8
                    ])
                    @endcomponent
                    @component('components.input-select', [
                        'type' => 'select',
                        'field' => 'permite_fracionamento',
                        'label' => 'Permite Fracionamento',
                        'name' => 'permite_fracionamento',
                        'id' => 'permite_fracionamento',
                        'inputSize' => 3,
                        'items' => Array('Não', 'Sim'),
                    ])
                    @endcomponent
                    <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" name = "saveUnidade" id="saveUnidade">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{--
@section('scripts')
<script>
    $(document).ready(function() {
        
        $('#saveGroup').click(function() {
            console.log('departamento');
            $.ajax({
                url: "{{ route('unidade.storejson') }}",
                method: 'POST',
                data: {
                    name: $('#unidade').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    
                    $('#unidadeModal').modal('hide');
                    // $('#unidade_id').append('<option value="' + response.id + '">' + response
                    //     .name + '</option>');
                    // $('#unidade_id').val(response.id);
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });
    });

    /*function salvarUnidade() {
           // let nome = document.getElementById('nomeUnidade').value;
            let token = document.querySelector('input[name="_token"]').value;

            fetch('{{ route('unidade.storejson') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ nome: unidade })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                   /* let select = document.getElementById('unidade_id');
                    let option = document.createElement('option');
                    option.value = data.grupo_produto.id;
                    option.text = data.grupo_produto.nome;
                    select.add(option);
                    select.value = data.grupo_produto.id;
                    
                    $('#unidadeModal').modal('hide');
                }
            });
        }
        */
</script>

@endsection

--}}
