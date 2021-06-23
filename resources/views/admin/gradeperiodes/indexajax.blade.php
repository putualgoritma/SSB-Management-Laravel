@extends('layouts.admin')
@section('content')
@can('gradeperiode_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.gradeperiodes.create") }}">
                {{ trans('global.add') }} {{ trans('global.gradeperiode.title_singular') }}
            </a>
        </div>
    </div>
    
@endcan
<div class="card">

    <div class="card-header">
        {{ trans('global.gradeperiode.title_singular') }} {{ trans('global.list') }}
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
                    <span class="input-group-btn">
                    &nbsp;&nbsp;<input type="submit" class="btn btn-primary" value="Filter">
                    </span>
                </div>                
             </form>
             </div> 
        </div>
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable ajaxTable datatable-gradeperiodes">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            No.
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
        if (periode) {
            $("#periode").val(periode);
        }else{
            $("#periode").val('');
        }
  
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.gradeperiodes.massDestroy') }}",
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
@can('gradeperiode_delete')
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
      url: "{{ route('admin.gradeperiodes.index') }}",
      data: {
        'periode': $("#periode").val(),
      }
    },
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        { data: 'DT_RowIndex', name: 'no' },        
        { data: 'name', name: 'name' },
        { data: 'periode_name', name: 'periode_name' },
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 1, 'asc' ]],
    pageLength: 100,
  };

  $('.datatable-gradeperiodes').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
@endsection