@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.schedule.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
    <div class="form-group">
         <div class="col-md-6">
             <form action="" id="filtersForm">                
                <div class="input-group">
                    <select id="periode" name="periode" class="form-control">
                    <option value="">== Semua Periode ==</option>
                    @foreach($periodes as $periode)
                    <option value="{{$periode->id}}">{{ $periode->name}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="input-group">
                &nbsp;
                </div>                
                <div class="input-group">
                    <select id="semester" name="semester" class="form-control">
                    <option value="">== Semua Semester ==</option>
                    @foreach($semesters as $semester)
                    <option value="{{$semester->id}}">{{ $semester->name}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="input-group">
                &nbsp;
                </div>
                <div class="input-group">
                    <select id="grade" name="grade" class="form-control">
                    <option value="">== Semua Kelas ==</option>
                    @foreach($grades as $grade)
                    <option value="{{$grade->id}}">{{ $grade->name}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="input-group">
                &nbsp;
                </div>
                <div class="input-group">
                    <select id="register" name="register" class="form-control">
                    <option value="">== Semua Hari ==</option>
                    <option value="Sunday">Minggu</option>
                    <option value="Monday">Senin</option>
                    <option value="Tuesday">Selasa</option>
                    <option value="Wednesday">Rabu</option>
                    <option value="Thursday">Kamis</option>
                    <option value="Friday">Jumat</option>
                    <option value="Saturday">Sabtu</option>
                    </select>
                    <span class="input-group-btn">
                    &nbsp;&nbsp;<input type="submit" class="btn btn-primary" value="Filter">
                    </span> 
                </div>
             </form>
             </div> 
        </div>
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable ajaxTable datatable-schedules">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            No.
                        </th>
                        <th>
                            {{ trans('global.subject.fields.name') }}
                        </th>
                        <th>
                            {{ trans('global.schedule.fields.periode_id') }}
                        </th>
                        <th>
                            {{ trans('global.schedule.fields.semester_id') }}
                        </th>                        
                        <th>
                            {{ trans('global.schedule.fields.grade_id') }}
                        </th>
                        <th>
                            {{ trans('global.schedule.fields.register') }}
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
  let periode = searchParams.get('periode')
  let semester = searchParams.get('semester')
  let grade = searchParams.get('grade')
  let register = searchParams.get('register')

  //alert(periode);
  if (periode) {
    $("#periode").val(periode);
  }else{
    $("#periode").val('');
  } 
  if (semester) {
    $("#semester").val(semester);
  }else{
    $("#semester").val('');
  } 
  if (grade) {
    $("#grade").val(grade);
  }else{
    $("#grade").val('');
  }
  if (register) {
    $("#register").val(register);
  }else{
    $("#register").val('');
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
    paging: true,
    aaSorting: [],
    ajax: {
      url: "{{ route('admin.absents.schedule') }}",
      data: {
        'periode': $("#periode").val(),
        'semester': $("#semester").val(),
        'grade': $("#grade").val(),
        'register': $("#register").val(),
      }
    },
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        { data: 'DT_RowIndex', name: 'no' },
        { data: 'code', name: 'code' },
        { data: 'periode', name: 'periode' },
        { data: 'semester', name: 'semester' },
        { data: 'grade', name: 'grade' },        
        { data: 'register', name: 'register' },
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    pageLength: 100,
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
  };

  $('.datatable-schedules').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
@endsection