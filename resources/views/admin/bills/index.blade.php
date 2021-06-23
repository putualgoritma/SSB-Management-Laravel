@extends('layouts.admin')
@section('content')
@can('student_create')
    <!-- <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.bills.create") }}">
                {{ trans('global.add') }} {{ trans('global.bill.title_singular') }}
            </a>
        </div>
    </div> -->
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('global.bill.title_singular') }} {{ trans('global.list') }}
    </div>
    <div class="card-body">
        <div class="form-group">
         <div class="col-md-6">
             <form action="" id="filtersForm">
                <div class="input-group">
                    <input type="month" id="period" name="period" class="form-control"> 
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
                    <select id="status-filter" name="status-filter" class="form-control">
                    <option value="">== Semua Status ==</option>
                    <option value="paid">Bayar</option>
                    <option value="unpaid">Belum</option>
                    </select>
                    <span class="input-group-btn">
                    &nbsp;&nbsp;<input type="submit" class="btn btn-primary" value="Filter">
                    </span> 
                </div>
             </form>
             </div> 
        </div>
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable ajaxTable datatable-bills">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            No.
                        </th>
                        <th>
                            {{ trans('global.bill.fields.code') }}
                        </th>
                        <th>
                            {{ trans('global.bill.fields.student_id') }}
                        </th>
                        <th>
                            {{ trans('global.bill.fields.periode') }}
                        </th>
                        <th>
                            {{ trans('global.bill.fields.register') }}
                        </th>
                        <th>
                            {{ trans('global.bill.fields.amount') }}
                        </th>
                        <th>
                            {{ trans('global.bill.fields.status') }}
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

  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'

  let statusFilter = searchParams.get('status-filter')
  let period = searchParams.get('period')
  let grade = searchParams.get('grade')

  //alert(statusFilter);

  if (statusFilter) {
    $("#status-filter").val(statusFilter);
  }else{
    $("#status-filter").val('');
  } 
  if (period) {
    $("#period").val(period);
  }else{
    let Ym = moment().format("YYYY-MM");
    $("#period").val(Ym);
  } 
  if (grade) {
    $("#grade").val(grade);
  }else{
    $("#grade").val('');
  }

  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.bills.massDestroy') }}",
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
@can('bill_delete')
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
      url: "{{ route('admin.bills.index') }}",
      data: {
        'status': $("#status-filter").val(),
        'period': $("#period").val(),
        'grade': $("#grade").val(),
      }
    },
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        { data: 'DT_RowIndex', name: 'no' },
        { data: 'code', name: 'code' },
        { data: 'name', name: 'name' },
        { data: 'periode', name: 'periode' },
        { data: 'register', name: 'register' },
        { data: 'amount', name: 'amount' },
        { data: 'status', name: 'status' },
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 1, 'asc' ]],
    pageLength: 100,
  };

  $('.datatable-bills').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });    
})

</script>
@endsection
@endsection