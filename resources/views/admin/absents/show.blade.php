@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.absent.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.absent.fields.code') }}
                    </th>
                    <td>
                        {{ $absent->code }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.absent.fields.register') }}
                    </th>
                    <td>
                        {{ $absent->register }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.absent.fields.schedule_id') }}
                    </th>
                    <td>
                        {{ $absent->schedule->register }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.absent.fields.student_id') }}
                    </th>
                    <td>
                        {{ $absent->student->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.absent.fields.presence') }}
                    </th>
                    <td>
                        {{ $absent->presence }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.absent.fields.description') }}
                    </th>
                    <td>
                        {{ $absent->description}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection