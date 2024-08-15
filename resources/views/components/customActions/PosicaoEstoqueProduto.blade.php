
{{--  <a class="btn btn-sm btn-success" href="{{ route('posicao_estoque_produto', ['produtoId' => $data->id]) }}"
    target="_blank">
    <i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="{{ __('Saldo em Estoque') }}"
        data-original-title="{{ __('Saldo em Estoque') }}"></i>
</a>
--}}
@php

    $target = isset($target) ?  $target : '';
    
    
@endphp



<a class="dropdown-item"
href="{{ route('posicao_estoque_produto', ['produtoId' => $data->id]) }} "{{ $target }}>Saldo em Estoque</a>
