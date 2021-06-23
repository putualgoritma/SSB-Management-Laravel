@extends('layouts.admin')
@section('content')
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
                        <th width="10">
                            {{ trans('global.student.fields.code') }}
                        </th>
                        <th>
                            {{ trans('global.student.fields.name') }}
                        </th>
                        <th>
                            {{ trans('global.student.fields.address') }}
                        </th>
                        <th>
                            {{ trans('global.student.fields.gender') }}
                        </th>
                        <th>
                            {{ trans('global.student.fields.phone') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $key => $student)
                        <tr data-entry-id="{{ $student->id }}">
                            <td>
                            
                            </td>
                            <td>
                            {{ $student->code ?? '' }}
                            </td>
                            <td>
                            {{ $student->name ?? '' }}
                            </td>
                            <td>
                            {{ $student->address ?? '' }}
                            </td>
                            <td>
                            {{ $student->gender ?? '' }}
                            </td>
                            <td>
                            {{ $student->phone ?? '' }}
                            </td>
                            <td>
                                @can('gradeperiode_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.gradeperiodes.studentAdd', [$gradeperiode->id,$student->id]) }}">
                                        Tambah
                                    </a>
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
  $('.datatable:not(.ajaxTable)').DataTable({ deferRender: false })
})

</script>
@endsection
@endsection