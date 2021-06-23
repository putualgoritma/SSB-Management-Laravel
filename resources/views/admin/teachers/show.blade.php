@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.teacher.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.teacher.fields.code') }}
                    </th>
                    <td>
                        {{ $teacher->code }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.teacher.fields.name') }}
                    </th>
                    <td>
                        {{ $teacher->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.teacher.fields.place') }}
                    </th>
                    <td>
                        {{ $teacher->place }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.teacher.fields.date') }}
                    </th>
                    <td>
                        {{ $teacher->date }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.teacher.fields.address') }}
                    </th>
                    <td>
                        {{ $teacher->address }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.teacher.fields.gender') }}
                    </th>
                    <td>
                        {{ $teacher->gender }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.teacher.fields.email') }}
                    </th>
                    <td>
                        {{ $teacher->email }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.teacher.fields.phone') }}
                    </th>
                    <td>
                        {{ $teacher->phone }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection