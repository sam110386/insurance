<div class="box">
    @if(isset($title))
    <div class="box-header with-border">
        <h3 class="box-title"> {{ $title }}</h3>
    </div>
    @endif

    @if ( $grid->showTools() || $grid->showExportBtn() || $grid->showCreateBtn() )
    <div class="box-header with-border">
        <div class="pull-right">
            {!! $grid->renderColumnSelector() !!}
            <a class="btn btn-sm btn-primary grid-refresh custom-grid-refresh pull-right mr-1" title="{{trans('admin.refresh')}}"><i class="fa fa-refresh"></i><span class="hidden-xs"> {{trans('admin.refresh')}}</span></a>
            {!! $grid->renderExportButton() !!}
        </div>
        @if ( $grid->showTools() )
        <span class="pull-right">
            {!! $grid->renderHeaderTools() !!}
        </span>
        @endif
        {!! $grid->renderCreateButton() !!}
    </div>
    @endif

    {!! $grid->renderFilter() !!}

    {!! $grid->renderHeader() !!}

    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover" id="{{ $grid->tableID }}">
            <thead>
                <tr>
                    @foreach($grid->visibleColumns() as $column)
                    <th>
                        @if($loop->iteration === 1)
                            <input  type="checkbox" class="grid-select-all" />
                        @else
                            {{$column->getLabel()}}{!! $column->sorter() !!}
                        @endif
                    </th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach($grid->rows() as $row)
                <tr {!! $row->getRowAttributes() !!}>
                    @foreach($grid->visibleColumnNames() as $name)
                    <td {!! $row->getColumnAttributes($name) !!}>
                        {!! $row->column($name) !!}
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>

            {!! $grid->renderTotalRow() !!}

        </table>

    </div>

    {!! $grid->renderFooter() !!}

    <div class="box-footer clearfix">
        {!! $grid->paginator() !!}
    </div>
    <!-- /.box-body -->
</div>
