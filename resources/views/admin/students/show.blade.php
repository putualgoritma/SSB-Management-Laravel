@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.student.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.student.fields.code') }}
                    </th>
                    <td>
                        {{ $student->code }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.name') }}
                    </th>
                    <td>
                        {{ $student->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.alias') }}
                    </th>
                    <td>
                        {{ $student->alias }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.place') }}
                    </th>
                    <td>
                        {{ $student->place }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.date') }}
                    </th>
                    <td>
                        {{ $student->date }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.grade_id') }}
                    </th>
                    <td>
                        {{ $student->grade->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.team_id') }}
                    </th>
                    <td>
                        {{ $student->team->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.gender') }}
                    </th>
                    <td>
                        {{ $student->gender }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.school') }}
                    </th>
                    <td>
                        {{ $student->school }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.gradeoriginal') }}
                    </th>
                    <td>
                        {{ $student->gradeoriginal }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.nisn') }}
                    </th>
                    <td>
                        {{ $student->nisn }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.religion') }}
                    </th>
                    <td>
                        {{ $student->religion }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.address') }}
                    </th>
                    <td>
                        {{ $student->address }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.village') }}
                    </th>
                    <td>
                        {{ $student->village }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.district') }}
                    </th>
                    <td>
                        {{ $student->district }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.regency') }}
                    </th>
                    <td>
                        {{ $student->regency }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.email') }}
                    </th>
                    <td>
                        {{ $student->email }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.phone') }}
                    </th>
                    <td>
                        {{ $student->phone }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.jerseynumber') }}
                    </th>
                    <td>
                        {{ $student->jerseynumber }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.jerseysize') }}
                    </th>
                    <td>
                        {{ $student->jerseysize }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.position') }}
                    </th>
                    <td>
                        {{ $student->position }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.fathername') }}
                    </th>
                    <td>
                        {{ $student->fathername }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.fatherjob') }}
                    </th>
                    <td>
                        {{ $student->fatherjob }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.fatherphone') }}
                    </th>
                    <td>
                        {{ $student->fatherphone }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.mothername') }}
                    </th>
                    <td>
                        {{ $student->mothername }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.motherjob') }}
                    </th>
                    <td>
                        {{ $student->motherjob }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.motherphone') }}
                    </th>
                    <td>
                        {{ $student->motherphone }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.photo') }}
                    </th>
                    <td>
                        {{ $student->photo }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.familylist') }}
                    </th>
                    <td>
                        {{ $student->familylist }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.ijazah') }}
                    </th>
                    <td>
                        {{ $student->ijazah }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.student.fields.birthcertificate') }}
                    </th>
                    <td>
                        {{ $student->birthcertificate }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection