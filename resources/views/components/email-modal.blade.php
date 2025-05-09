<div class="modal fade" id="emailModal" tabindex="-1">
    <div class="modal-dialog">
      <form method="POST" action="{{ route('enviar.email') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Enviar E-mail</h5>
          </div>
          <div class="modal-body">
            <input type="hidden" name="referencia_id" value="{{ $referenciaId ?? '' }}">
            <div class="mb-3">
              <label>Para</label>
              <input type="email" name="destinatario" class="form-control" value="{{ $destinatario ?? '' }}" required>
            </div>
            <div class="mb-3">
              <label>Assunto</label>
              <input type="text" name="assunto" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Mensagem</label>
              <textarea name="mensagem" class="form-control" rows="4" required></textarea>
            </div>
            <div class="mb-3">
              <label>Anexos</label>
              <input type="file" name="anexos[]" class="form-control" multiple>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

            <button type="submit" class="btn btn-primary">Enviar</button>
          </div>
        </div>
      </form>
    </div>
  </div>