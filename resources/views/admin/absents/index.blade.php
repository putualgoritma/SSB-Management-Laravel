@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.absent.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
    <div class="form-group">
         <div class="col-md-6">
             <form action="" id="filtersForm">
                <div class="input-group">
                    <input type="date" id="register" name="register" class="form-control"> 
                </div>
                <div class="input-group">
                &nbsp;
                </div>
                <div class="input-group">
                    <select id="presence" name="presence" class="form-control">
                    <option value="">== Semua Status ==</option>
                    <option value="masuk">Masuk</option>
                    <option value="ijin">Ijin</option>
                    <option value="sakit">Sakit</option>
                    <option value="alpha">Alpha</option>
                    </select>
                    <span class="input-group-btn">
                    &nbsp;&nbsp;<input type="submit" class="btn btn-primary" value="Filter">
                    </span> 
                </div>
             </form>
             </div> 
        </div>
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable ajaxTable datatable-absents">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            No.
                        </th>
                        <th>
                            {{ trans('global.absent.fields.code') }}
                        </th>
                        <th>
                            {{ trans('global.absent.fields.register') }}
                        </th>
                        <th>
                            {{ trans('global.absent.fields.student_id') }}
                        </th>
                        <th>
                            {{ trans('global.absent.fields.description') }}
                        </th>
                        <th>
                            {{ trans('global.absent.fields.presence') }}
                        </th>
                        <th>
                            {{ trans('global.absent.fields.amount') }}
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
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'

  let searchParams = new URLSearchParams(window.location.search)
  let presence = searchParams.get('presence')
  let register = searchParams.get('register')

  if (presence) {
    $("#presence").val(presence);
  }else{
    $("#presence").val('');
  } 
  if (register) {
    $("#register").val(register);
  }else{
    let Ym = moment().format("YYYY-MM-DD");
    $("#register").val(Ym);
  }

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
      url: "{{ route('admin.absents.list',[$id,$gid]) }}",
      data: {
        'presence': $("#presence").val(),
        'register': $("#register").val(),
      }
    },
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        { data: 'DT_RowIndex', name: 'no' },
        { data: 'code', name: 'code' },
        { data: 'register', name: 'register' },
        { data: 'name', name: 'name' },        
        { data: 'description', name: 'description' },
        { data: 'presence', name: 'presence' },
        { data: 'amount', name: 'amount' },
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 1, 'asc' ]],
    pageLength: 100,
  };

  $('.datatable-absents').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
@endsection