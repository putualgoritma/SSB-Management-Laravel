@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('global.bill.title') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('global.bill.fields.code') }}
                    </th>
                    <td>
                        {{ $bill->code }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.bill.fields.periode') }}
                    </th>
                    <td>
                        {{ $bill->periode }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.bill.fields.register') }}
                    </th>
                    <td>
                        {{ $bill->register }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.bill.fields.amount') }}
                    </th>
                    <td>
                        {{ $bill->amount}}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.bill.fields.status') }}
                    </th>
                    <td>
                        {{ $bill->status }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('global.bill.fields.student_id') }}
                    </th>
                    <td>
                        {{ $bill->student->name}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection