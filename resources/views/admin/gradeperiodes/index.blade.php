@extends('layouts.admin')
@section('content')
@can('gradeperiode_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">            
            <a class="btn btn-success" href="{{ route('admin.gradeperiodes.create', ['periode'=>$periode!=null ? $periode->id : 0]) }}">
                {{ trans('global.add') }} {{ trans('global.gradeperiode.title_singular') }}
            </a>
        </div>
    </div>

@endcan
<div class="card">

    <div class="card-header">
        {{ trans('global.gradeperiode.title_singular') }} {{ trans('global.list') }} @if($periode!=null)(Periode: {{ $periode->name }})@endif
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
                            {{ trans('global.gradeperiode.fields.grade_id') }}
                        </th>
                        <th>
                            {{ trans('global.gradeperiode.fields.periode_id') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gradeperiodes as $key => $gradeperiode)
                        <tr data-entry-id="{{ $gradeperiode->id }}">
                            <td>

                            </td>
                            <td>
                            {{ $gradeperiode->grade->name ?? '' }}
                            </td>
                            <td>
                            {{ $gradeperiode->periode->name ?? '' }}
                            </td>
                            <td>
                                @can('gradeperiode_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.gradeperiodes.show', $gradeperiode->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @can('gradeperiode_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.gradeperiodes.edit', $gradeperiode->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('gradeperiode_delete')
                                    <form action="{{ route('admin.gradeperiodes.destroy', $gradeperiode->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                                <a class="btn btn-xs btn-success" href="{{ route('admin.gradeperiodes.studentGrade', $gradeperiode->id) }}">
                                        {{ trans('global.student.title') }}
                                    </a>
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