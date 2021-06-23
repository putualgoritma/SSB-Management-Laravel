@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.grade.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.grade.fields.code') }}
                    </th>
                    <td>
                        {{ $grade->code }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.grade.fields.name') }}
                    </th>
                    <td>
                        {{ $grade->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.grade.fields.agemin') }}
                    </th>
                    <td>
                        {{ $grade->agemin }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.grade.fields.agemax') }}
                    </th>
                    <td>
                        {{ $grade->agemax }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection