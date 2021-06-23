@extends('layouts.admin')
@section('content')
@can('teacher_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.teachers.create") }}">
                {{ trans('global.add') }} {{ trans('global.teacher.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('global.teacher.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('global.teacher.fields.code') }}
                        </th>
                        <th>
                            {{ trans('global.teacher.fields.name') }}
                        </th>
                        <th>
                            {{ trans('global.teacher.fields.place') }}
                        </th>
                        <th>
                            {{ trans('global.teacher.fields.date') }}
                        </th>
                        <th>
                            {{ trans('global.teacher.fields.address') }}
                        </th>
                        <th>
                            {{ trans('global.teacher.fields.gender') }}
                        </th>
                        <th>
                            {{ trans('global.teacher.fields.email') }}
                        </th>
                        <th>
                            {{ trans('global.teacher.fields.phone') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $key => $teacher)
                        <tr data-entry-id="{{ $teacher->id }}">
                            <td>

                            </td>
                            <td>
                            {{ $teacher->code ?? '' }}
                            </td>
                            <td>
                            {{ $teacher->name ?? '' }}
                            </td>
                            <td>
                            {{ $teacher->place ?? '' }}
                            </td>
                            <td>
                            {{ $teacher->date ?? '' }}
                            </td>
                            <td>
                            {{ $teacher->address ?? '' }}
                            </td>
                            <td>
                            {{ $teacher->gender ?? '' }}
                            </td>
                            <td>
                            {{ $teacher->email ?? '' }}
                            </td>
                            <td>
                            {{ $teacher->phone ?? '' }}
                            </td>
                            <td>
                                @can('teacher_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.teachers.show', $teacher->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @can('teacher_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.teachers.edit', $teacher->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('teacher_delete')
                                    <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.users.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('user_delete')
  dtButtons.push(deleteButton)
@endcan

  $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
})

</script>
@endsection
@endsection