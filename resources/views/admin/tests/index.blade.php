@extends('layouts.admin')
@section('content')
@can('test_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.tests.create") }}">
                {{ trans('global.add') }} {{ trans('global.test.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('global.test.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('global.test.fields.code') }}
                        </th>
                        <th>
                            {{ trans('global.test.fields.name') }}
                        </th>
                        <th>
                            {{ trans('global.test.fields.value') }}
                        </th>
                        <th>
                            {{ trans('global.test.fields.student_id') }}
                        </th>
                        <th>
                            {{ trans('global.test.fields.subject_id') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tests as $key => $test)
                        <tr data-entry-id="{{ $test->id }}">
                            <td>
                            </td>
                            <td>
                            {{ $test->code ?? '' }}
                            </td>
                            <td>
                            {{ $test->value ?? '' }}
                            </td>
                            <td>
                            @if ($test->name == 'Daily')
                                Harian
                            @elseif($test->name == 'Middle')
                                Tengah Semester
                            @elseif ($test->name == 'End')
                                Akhir Semester
                            @else
                            @endif
                            </td>
                            <td>
                            {{ $test->student->name ?? '' }}
                            </td>
                            <td>
                            {{ $test->subject->name ?? '' }}
                            </td>                        
                            <td>
                                @can('test_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.tests.show', $test->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @can('test_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.tests.edit', $test->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('test_delete')
                                    <form action="{{ route('admin.tests.destroy', $test->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
    url: "{{ route('admin.tests.massDestroy') }}",
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
@can('test_delete')
  dtButtons.push(deleteButton)
@endcan

  $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
})

</script>
@endsection
@endsection