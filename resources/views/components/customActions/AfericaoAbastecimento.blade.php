{{--  
@permission('cadastrar-afericao')
    @if ($data->eh_afericao)
        <button class="btn btn-sm btn-success" disabled>
            <i class="fas fa-gas-pump" data-toggle="tooltip" data-placement="top" title="{{ __('É aferição') }}"
                data-original-title="{{ __('É aferição') }}"></i>
        </button>
    @else
        <a class="btn btn-sm btn-success" href="{{ route('afericao.create', ['abastecimento' => $data->id]) }}">
            <i class="fas fa-gas-pump" data-toggle="tooltip" data-placement="top" title="{{ __('Fazer aferição') }}"
                data-original-title="{{ __('Fazer Aferição') }}"></i>
        </a>
    @endif
@endpermission
--}}

@permission('cadastrar-afericao')
    @if ($data->eh_afericao)
        <a class="dropdown-item" disabled href="{{ route('afericao.create', ['abastecimento' => $data->id]) }}">É
            aferição</a>
    @else
        
        <a class="dropdown-item" href="{{ route('afericao.create', ['abastecimento' => $data->id]) }}">Fazer aferição</a>
    @endif
@endpermission
