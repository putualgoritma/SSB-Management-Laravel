@extends('layouts.admin')
@section('content')
@can('student_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.students.create") }}">
                {{ trans('global.add') }} {{ trans('global.student.title_singular') }}
            </a>
        </div>
    </div>
    
@endcan
<div class="card">

    <div class="card-header">
        {{ trans('global.student.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
    <div class="form-group">
         <div class="col-md-6">
             <form action="" id="filtersForm">
                <div class="input-group">
                    <select id="grade" name="grade" class="form-control">
                    <option value="">== Semua Kelas ==</option>
                    @foreach($grades as $grade)
                    <option value="{{$grade->id}}">{{ $grade->name}}</option>
                    @endforeach
                    </select>
                    <span class="input-group-btn">
                    &nbsp;&nbsp;<input type="submit" class="btn btn-primary" value="Filter">
                    </span>
                </div>                
             </form>
             </div> 
        </div>
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable ajaxTable datatable-students">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            No.
                        </th>
                        <th>
                            {{ trans('global.student.fields.code') }}
                        </th>
                        <th>
                            {{ trans('global.student.fields.name') }}
                        </th>
                        <th>
                            {{ trans('global.student.fields.place') }}
                        </th>
                        <th>
                            {{ trans('global.student.fields.date') }}
                        </th>
                        <th>
                            {{ trans('global.student.fields.address') }}
                        </th>
                        <th>
                            {{ trans('global.student.fields.gender') }}
                        </th>
                        <th>
                            {{ trans('global.student.fields.school') }}
                        </th>
                        <th>
                            {{ trans('global.student.fields.email') }}
                        </th>
                        <th>
                            {{ trans('global.student.fields.phone') }}
                        </th>
                        <th>
                            {{ trans('global.student.fields.grade_id') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                
            </table>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
        let searchParams = new URLSearchParams(window.location.search)
        let grade = searchParams.get('grade')
        if (grade) {
            $("#grade").val(grade);
        }else{
            $("#grade").val('');
        }
  
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: {
      url: "{{ route('admin.students.index') }}",
      data: {
        'grade': $("#grade").val(),
      }
    },
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        { data: 'DT_RowIndex', name: 'no' },
        { data: 'code', name: 'code' },
        { data: 'name', name: 'name' },
        { data: 'place', name: 'place' },
        { data: 'date', name: 'date' },
        { data: 'address', name: 'address' },
        { data: 'gender', name: 'gender' },
        { data: 'school', name: 'school' },
        { data: 'email', name: 'email' },
        { data: 'phone', name: 'phone' },
        { data: 'grade', name: 'grade' },
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 1, 'asc' ]],
    pageLength: 100,
  };

  $('.datatable-students').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
@endsection