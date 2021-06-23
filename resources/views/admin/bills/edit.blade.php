@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.bill.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.bills.update", [$bill->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                <label for="code">{{ trans('global.bill.fields.code') }}*</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('code', isset($bill) ? $bill->code : '') }}">
                @if($errors->has('code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('periode') ? 'has-error' : '' }}">
                <label for="periode">{{ trans('global.bill.fields.periode') }}*</label>
                <input type="text" id="periode" name="periode" class="form-control" value="{{ old('periode', isset($bill) ? $bill->periode : '') }}">
                @if($errors->has('periode'))
                    <em class="invalid-feedback">
                        {{ $errors->first('periode') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('register') ? 'has-error' : '' }}">
                <label for="register">{{ trans('global.bill.fields.register') }}*</label>
                <input type="date" id="register" name="register" class="form-control" value="{{ old('register', isset($bill) ? $bill->register : '') }}">
                @if($errors->has('register'))
                    <em class="invalid-feedback">
                        {{ $errors->first('register') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                <label for="amount">{{ trans('global.bill.fields.amount') }}*</label>
                <input type="text" id="amount" name="amount" class="form-control" value="{{ old('amount', isset($bill) ? $bill->amount : '') }}">
                @if($errors->has('amount'))
                    <em class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                <label for="status">{{ trans('global.bill.fields.status') }}*</label>
                <input type="text" id="status" name="status" class="form-control" value="{{ old('status', isset($bill) ? $bill->status : '') }}">
                @if($errors->has('status'))
                    <em class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('student_id') ? 'has-error' : '' }}">
                <label for="student_id">{{ trans('global.bill.fields.student_id') }}*</label>
                <select id="student_id" name="student_id" class="form-control" value="{{ old('student_id', isset($bill) ? $bill->student_id : '') }}">
                @foreach($students as $student)
                <option value="{{$student->id}}" {{$bill->student->id == $student->id ? 'selected' : ''}}>{{ $student->name}}</option>
                @endforeach
                 </select>
                </select>
                @if($errors->has('student_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('student_id') }}
                    </em>
                @endif
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection