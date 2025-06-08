{{--  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#emailModal">Enviar e-mail</button>

--}}

 {{--  
  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#emailModal">
    Enviar e-mail
  </a>
  --}}
  <a 
  href="#" 
  class="dropdown-item btn-enviar-email" 
  data-id="{{ $data->id }}" 
  {{-- data-email="{{ $row->cliente_email ?? '' }}" --}}
  >
  <i class="fa fa-envelope"></i> Enviar E-mail
</a>
