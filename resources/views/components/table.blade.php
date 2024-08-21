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
                    @component($searchParms)
                    @endcomponent
                @endif
            </div>
        </form>

        <div class="row">
            <div class="col-sm">

            </div>
            <div class="col-sm">

            </div>

            @if (isset($total))
                <div class="col-sm" style="text-align: right;">

                    <h5>{{ __(isset($total) ? 'R$ ' . number_format($total[0]->total, 2, ',', '.') : 'R$ 0,00') }}</h5>

                </div>
            @endif

        </div>


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
                    <tr {{--  {{(!$row->ativo) ? 'class=danger' : ''}}  --}}>
                @endif
                @foreach ($captions as $field => $caption)
                    @if (is_array($caption))
                        @if ($caption['type'] == 'bool')
                            <td scope="row">{{ __($row->$field == '1' ? 'Sim' : 'Não') }}</td>
                        @endif
                        @if ($caption['type'] == 'tag')
                        <td scope="row"><span class="badge badge-pill badge-primary">{{ __($row->$field) }}</span></td>
                            
                           
                        @endif
                        @if ($caption['type'] == 'datetime')
                            <td scope="row">{{ date_format(date_create($row->$field), 'd/m/Y H:i:s') }}</td>
                        @endif
                        @if ($caption['type'] == 'date')
                            <td scope="row">{{ date_format(date_create($row->$field), 'd/m/Y') }}</td>
                        @endif
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


                    <div class="btn-group dropleft">
                        <a data-toggle="dropdown" aria-expanded="false" type="button">
                            <i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            @if (is_array($actions))
                                @foreach ($actions as $action)
                                    <?php
                                    switch ($action) {
                                        case 'show':
                                            $btn_style = 'btn-success';
                                            $btn_icon = 'eye';
                                            $tooltip = 'Visualizar';
                                            $permission = 'listar-' . str_replace('_', '-', $model);
                                            break;
                                        case 'edit':
                                            $btn_style = 'btn-warning';
                                            $btn_icon = 'edit';
                                            $tooltip = 'Editar';
                                            $permission = 'alterar-' . str_replace('_', '-', $model);
                                            break;
                                        case 'destroy':
                                            $btn_style = 'btn-danger';
                                            $btn_icon = 'trash-alt';
                                            $tooltip = 'Remover';
                                            $permission = 'excluir-' . str_replace('_', '-', $model);
                                            break;
                                    }
                                    $target = isset($action['target']) ? 'target=' . $action['target'] : '';
                                    
                                    ?>
                                    @if (is_array($action))
                                        @if (isset($action['custom_action']))
                                            @component($action['custom_action'], ['data' => $row, 'target' => $target])
                                            @endcomponent/
                                        @else
                                            <a class="dropdown-item"
                                                href="{{ route($model . '.' . $action['action'], array_add($parameters, $model, $row->$keyField)) }}"
                                                {{ $target }}>Show</a>
                                        @endif
                                    @else
                                        @permission($permission)
                                            @if ($action == 'destroy')
                                                <form id="deleteForm{{ $row->id }}"
                                                    action="{{ route($model . '.' . $action, ['$model' => $row->$keyField]) }}"
                                                    method="POST" style="display: inline">
                                                    <input type="hidden" name="backUrlParams"
                                                        value="{{ json_encode(Request()->request->all()) }}">
                                                    <span data-toggle="tooltip" data-placement="top"
                                                        title="{{ $tooltip }}"
                                                        data-original-title="{{ $tooltip }}">

                                                        <a class="dropdown-item" data-toggle="modal"
                                                            data-target="#confirmDelete"
                                                            data-title="{{ __('Remover ') . __('models.' . $model) }}"
                                                            data-message="Remover {{ __('models.' . $model) . ': ' . $row->$displayField }}?">{{ $tooltip }}</a>
                                                    </span>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                </form>
                                            @else
                                                <a class="dropdown-item"
                                                    href="{{ route($model . '.' . $action, array_add($parameters, $model, $row->$keyField)) }}">{{ $tooltip }}</a>
                                            @endif
                                        @endpermission
                                    @endif
                                @endforeach
                            @endif


                        </div>
                    </div>


                </td>


                </td>

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
@include('layouts.modal')

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
@endpush
