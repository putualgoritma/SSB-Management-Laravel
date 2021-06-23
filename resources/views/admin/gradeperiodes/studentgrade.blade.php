@extends('layouts.admin')
@section('content')
@can('gradeperiode_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.gradeperiodes.students", [$gradeperiode->id]) }}">
                {{ trans('global.add') }} {{ trans('global.student.title_singular') }}
            </a>
        </div>
    </div>
    
@endcan
<div class="card">

    <div class="card-header">
        {{ trans('global.student.title_singular') }} {{ trans('global.list') }} ({{ $gradeperiode->grade->name }}/{{ $gradeperiode->periode->name }})
    </div>

    <div class="card-body">
    <div class="form-group">
         <div class="col-md-6">
             </div> 
        </div>
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('global.student.fields.code') }}
                        </th>
                        <th>
                            {{ trans('global.student.fields.name') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($studentgradeperiodes as $key => $studentgradeperiode)
                        <tr data-entry-id="{{ $studentgradeperiode->id }}">
                            <td>

                            </td>
                            <td>
                            {{ $studentgradeperiode->id ?? '' }}
                            </td>
                            <td>
                            {{ $studentgradeperiode->students->name ?? '' }}
                            </td>
                            <td>
                                @can('gradeperiode_delete')
                                    <form action="{{ route('admin.gradeperioder.studentRemove') }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_id" value={{$studentgradeperiode->id}}>
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