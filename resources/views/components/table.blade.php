@php
    $displayField = isset($displayField) ? $displayField : 'name';
    $keyField = isset($keyField) ? $keyField : 'id';

    if (isset($colorLineCondition)) {
        $lineConditionField = $colorLineCondition['field'];
        $lineConditionValue = $colorLineCondition['value'];
        $lineCondicionClass = $colorLineCondition['class'];
    } else {
        $colorLineCondition = false;
    }
    $customMethods = isset($customMethods) ? $customMethods : [];

    $displayField = isset($displayField) ? $displayField : 'name';
    $keyField = isset($keyField) ? $keyField : 'id';
    $parameters = Request()->request->all() ?? [];
@endphp
<div class="card d-block card-primary">
    <div class="card-header">
        <div class="row">
            <div class="col">
                <h3>{{ __(isset($tableTitle) ? $tableTitle : 'tableTitle not informed...') }}</h3>
            </div>
        </div>


        <form id="searchForm" class="form" method="GET" action="{{ route($model . '.index') }}">
            {{ csrf_field() }}

            <div class="row">

                <div class="col">
                    <div class="form-group">

                        <div class="input-group">
                            <div _ngcontent-pcv-c127="" class="input-group-prepend">
                                <div _ngcontent-pcv-c127="" class="input-group-text">
                                    <input _ngcontent-pcv-c127="" id="ativos" type="checkbox"
                                        class="ng-valid ng-dirty ng-touched"> &nbsp;Ativos
                                </div>
                            </div>


                            <input type="text" class="form-control" id="searchField" name="searchField"
                                placeholder="Digite aqui para buscar"
                                value="{{ isset($_GET['searchField']) ? $_GET['searchField'] : '' }}">
                            <span class="input-group-append" data-toggle="tooltip" data-placement="top"
                                title="{{ __('strings.Search') }}" data-original-title="{{ __('Search') }}">
                                <button type="submit" class="btn btn-primary"><i
                                        class="fas fa-search"></i></span></button>
                            </span>

                        </div>
                    </div>
                </div>


                <div class="col-auto">


                    @permission('cadastrar-' . str_replace('_', '-', $model))
                        @if (Route::has($model . '.create'))
                            <a href="{{ route($model . '.create') }}" class="btn   btn-success" data-toggle="tooltip"
                                data-placement="top" title="{{ __('strings.New') }}"
                                data-original-title="{{ __('New') }}">
                                <i class="fas fa-plus"></i>
                            </a>
                        @endif
                    @endpermission
                    @foreach ($customMethods as $customMethod)
                        @component($customMethod['component'])
                        @endcomponent
                    @endforeach
                </div>
            </div>

            <div class="row">


                @if (isset($searchParms))


                    {{-- @component($searchParms, ['ordemServicoStatus' => $ordemServicoStatus])  --}}
                    @component($searchParms)
                    @endcomponent
                @endif
                @if (isset($total))
                    @component('components.input-text', [
                        'id' => 'total',
                        'name' => 'total',
                        'inputValue' => isset($total) ? 'R$ ' . number_format($total[0]->total, 2, ',', '.') : 'R$ 0,00',
                        'type' => 'number',
                        'field' => 'valor_abastecimento',
                        'label' => 'Valor Total',
                        'inputSize' => 2,
                        'readOnly' => true,
                    ])
                    @endcomponent

                @endif

            </div>
        </form>


    </div>

    <table class="table table-sm table-bordered table-striped table-hover" style="margin: 0px">
        <thead class="thead-light">
            <tr>
                @foreach ($captions as $field => $caption)
                    @if (is_array($caption))
                        <th>{{ __($caption['label']) }}</th>
                    @else
                        <th>{{ __($caption) }}</th>
                    @endif
                @endforeach
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                @if ($colorLineCondition)
                    <tr {{ $row->$lineConditionField == $lineConditionValue ? 'class=' . $lineCondicionClass : '' }}>
                    @else
                    <tr class="clickable-row" data-id="{{ $row->id }}"{{--  {{(!$row->ativo) ? 'class=danger' : ''}}  --}}>
                @endif
                @foreach ($captions as $field => $caption)
                    @if (is_array($caption))
                        @if ($caption['type'] == 'bool')
                            <td scope="row">{{ __($row->$field == '1' ? 'Sim' : 'Não') }}</td>
                        @endif
                        @if ($caption['type'] == 'tag')
                            <td scope="row"><span
                                    class="badge badge-pill badge-primary">{{ __($row->$field) }}</span></td>
                        @endif
                        {{--  
                        @if ($caption['type'] == 'datetime')
                            <td scope="row">{{ date_format(date_create($row->$field), 'd/m/Y H:i:s') }}</td>
                        @endif
                        --}}
                        @if ($caption['type'] == 'datetime')
                            <td scope="row">
                                @if (!empty($row->$field))
                                    {{ date_format(date_create($row->$field), 'd/m/Y H:i:s') }}
                                @else
                                    {{-- Campo vazio --}}
                                @endif
                            </td>
                        @endif

                        @if ($caption['type'] == 'date')
                            <td scope="row">
                                @if (!empty($row->$field))
                                    {{ date_format(date_create($row->$field), 'd/m/Y') }}
                                @else
                                    {{-- Campo vazio --}}
                                @endif
                            </td>
                        @endif
                        {{--  
                        @if ($caption['type'] == 'date')
                            <td scope="row">{{ date_format(date_create($row->$field), 'd/m/Y') }}</td>
                        @endif
                        --}}
                        @if ($caption['type'] == 'decimal')
                            <td scope="row">
                                <div align="right">{{ number_format($row->$field, $caption['decimais'], ',', '.') }}
                                </div>
                            </td>
                        @endif
                        @if ($caption['type'] == 'list')
                            <td scope="row">
                                <div align="right">{{ $caption['values'][$row->$field] }}</div>
                            </td>
                        @endif
                    @else
                        <td scope="row">
                            <div {{ is_numeric($row->$field) ? 'align=right' : '' }}>
                                {{ $row->$field }}
                            </div>
                        </td>
                    @endif
                @endforeach

                <td scope="row" class="text-center">

                    {{--  
                            @if (is_array($actions))
                                @foreach ($actions as $action)
                                    @if (is_array($action))
                                        @if (isset($action['custom_action']))
                                            @component($action['custom_action'], ['data' => $row])
                                            @endcomponent
                                        @else
                                                                @component('components.action', [
    'action' => $action['action'],
    'model' => $model,
    'row' => $row,
    'displayField' => $displayField,
    'keyField' => $keyField,
    'target' => $action['target'],
])
                                            @endcomponent
                                        @endif
                            @else
                                @component('components.action', [
    'action' => $action,
    'model' => $model,
    'row' => $row,
    'displayField' => $displayField,
    'keyField' => $keyField,
])
                                        @endcomponent
                                    @endif
                                @endforeach
                            @endif

                            --}}

                    @if (isset($detailFields))
                        <button type="button" data-id="{{ $row->id }}" tabindex="-1"
                            class="btn btn-sm btn-observacoes-item" data-toggle="tooltip" title="Detalhes"
                            data-original-title="Detalhes"><i style="display:block"
                                class="fa fa-angle-down submenu-icon"></i></button>
                    @endif

                    <div class="btn-group dropleft" data-toggle="tooltip" title="Ações">
                        <a data-toggle="dropdown" aria-expanded="false" type="button">
                            <i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">



                            @if (is_array($actions))
                                @foreach ($actions as $action)
                                    {{-- Verifica se a ação é uma string padrão (show, edit, destroy) --}}
                                    @if (is_string($action))
                                        @php
                                            // Define configurações básicas da ação
                                            switch ($action) {
                                                case 'show':
                                                    $tooltip = 'Visualizar';
                                                    $permission = 'listar-' . str_replace('_', '-', $model);
                                                    break;
                                                case 'edit':
                                                    $tooltip = 'Editar';
                                                    $permission = 'alterar-' . str_replace('_', '-', $model);
                                                    break;
                                                case 'destroy':
                                                    $tooltip = 'Remover';
                                                    $permission = 'excluir-' . str_replace('_', '-', $model);
                                                    break;
                                            }
                                        @endphp

                                        @permission($permission)
                                            {{-- Ação de deletar com modal de confirmação --}}
                                            @if ($action === 'destroy')
                                                <form id="deleteForm{{ $row->id }}"
                                                    action="{{ route($model . '.' . $action, [$model => $row->$keyField]) }}"
                                                    method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <a class="dropdown-item" data-toggle="modal"
                                                        data-target="#confirmDelete"
                                                        data-title="Remover {{ __('models.' . $model) }}"
                                                        data-message="Remover {{ __('models.' . $model) }}: {{ $row->$displayField }}?">
                                                        {{ $tooltip }}
                                                    </a>
                                                </form>
                                            @else
                                                {{-- Ações normais (show, edit) --}}
                                                <a class="dropdown-item"
                                                    href="{{ route($model . '.' . $action, [$model => $row->$keyField]) }}">
                                                    {{ $tooltip }}
                                                </a>
                                            @endif
                                        @endpermission

                                        {{-- Caso a ação seja um array (ação customizada) --}}
                                    @elseif (is_array($action))
                                        @php
                                            $targetAttr = isset($action['target']) ? 'target=' . $action['target'] : '';
                                        @endphp

                                        @if (isset($action['custom_action']))
                                            {{-- Componente Blade customizado --}}
                                            @component($action['custom_action'], ['data' => $row, 'target' => $targetAttr])
                                            @endcomponent
                                        @else
                                            {{-- Link padrão com target --}}
                                            <a class="dropdown-item"
                                                href="{{ route($model . '.' . $action['action'], [$model => $row->$keyField]) }}"
                                                {!! $targetAttr !!}>
                                                Visualizar
                                            </a>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>


                </td>


                </td>


                @if (isset($detailFields))
                    @foreach ($detailFields as $fieldDetail => $captiondetail)
                        @if (is_array($captiondetail))
                            @if ($captiondetail['type'] == 'bool')
                                <td scope="row">{{ __($row->$field == '1' ? 'Sim' : 'Não') }}</td>
                            @endif
                            @if ($captiondetail['type'] == 'tag')
                                <td scope="row"><span
                                        class="badge badge-pill badge-primary">{{ __($row->$field) }}</span></td>
                            @endif
                            @if ($captiondetail['type'] == 'datetime')
                                <td scope="row">{{ date_format(date_create($row->$field), 'd/m/Y H:i:s') }}</td>
                            @endif
                            @if ($captiondetail['type'] == 'date')
                                <td scope="row">{{ date_format(date_create($row->$field), 'd/m/Y') }}</td>
                            @endif
                            @if ($captiondetail['type'] == 'decimal')
                                <td scope="row">
                                    <div align="right">
                                        {{ number_format($row->$field, $caption['decimais'], ',', '.') }}
                                    </div>
                                </td>
                            @endif
                            @if ($captiondetail['type'] == 'list')
                                <td scope="row">
                                    <div align="right">{{ $captiondetail['values'][$row->$field] }}</div>
                                </td>
                            @endif
                        @else
                            <tr class="detail-row" id="detail-{{ $row->id }}" style="display: none;">
                                <td colspan="10">
                                    <strong>{{ $captiondetail }}</strong> {{ $row->$fieldDetail }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif




            @endforeach
        </tbody>
    </table>
    @if ($rows->links() != '')
        <div class="card-footer bg-light">
            <div class="d-flex">
                <div class="mx-auto">
                    {{ $rows->links() }}

                </div>
            </div>
        </div>
    @endif
</div>


<!-- Modal Dialog -->
@include('grupo_veiculo.modal')
@include('layouts.modal')
@include('components.email-modal', [
    'referenciaId' => 1,
    'destinatario' => ''
  ])

@push('document-ready')
    <!-- Dialog show event handler -->
    $('#confirmDelete').on('show.bs.modal', function (e) {
    $message = $(e.relatedTarget).attr('data-message');
    $(this).find('.modal-body p').text($message);
    $title = $(e.relatedTarget).attr('data-title');
    $(this).find('.modal-title').text($title);

    // Pass form reference to modal for submission on yes/ok
    var form = $(e.relatedTarget).closest('form');
    $(this).find('.modal-footer #confirm').data('form', form);
    });

    <!-- Form confirm (yes/ok) handler, submits form -->
    $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
    $(this).data('form').submit();
    });
    {{--
    $(function(){
        $("table tr").click(function(){
            $(".tabelaOculta").hide(); 
        alert(this.rowIndex);
        });
        });
        --}}

    $('.btn-observacoes-item').click(function () {

    var id = $(this).data('id');


    $('#detail-' + id).toggle();
    });
@endpush
