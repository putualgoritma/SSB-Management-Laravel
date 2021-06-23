@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.test.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.test.fields.code') }}
                    </th>
                    <td>
                        {{ $test->code }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.test.fields.value') }}
                    </th>
                    <td>
                        {{ $test->value }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.test.fields.name') }}
                    </th>
                    <td>
                    @if ($test->name == 'Daily')
                        Harian
                    @elseif($test->name == 'Middle')
                        Tengah Semester
                    @elseif ($test->name == 'End')
                        Akhir Semester
                    @else
                    @endif
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.test.fields.student_id') }}
                    </th>
                    <td>
                        {{ $test->student->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.test.fields.subject_id') }}
                    </th>
                    <td>
                        {{ $test->subject->name }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection