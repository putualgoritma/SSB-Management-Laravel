@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.gradeperiode.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.gradeperiode.fields.grade_id') }}
                    </th>
                    <td>
                        {{ $gradeperiode->grade->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.gradeperiode.fields.periode_id') }}
                    </th>
                    <td>
                        {{ $gradeperiode->periode->name }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection