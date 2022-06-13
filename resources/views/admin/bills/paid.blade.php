@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.bill.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.bills.paidprocess") }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group {{ $errors->has('periode') ? 'has-error' : '' }}">
                <label for="periode">{{ trans('global.bill.fields.periode') }}*</label>
                <input type="text" id="periode_off" name="periode_off" class="form-control" readonly value="{{ old('periode', isset($periode) ? $periode : '') }}">
                @if($errors->has('periode'))
                    <em class="invalid-feedback">
                        {{ $errors->first('periode') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('student_grade_periode_id') ? 'has-error' : '' }}">
                <label for="student_grade_periode_id">{{ trans('global.student.fields.name') }}*</label>
                <input type="text" id="student_grade_periode_id" name="student_grade_periode_id" class="form-control" readonly value="{{ old('student_grade_periode_id', isset($student_grade_periode->students) ? $student_grade_periode->students->name : '') }}">
                @if($errors->has('student_grade_periode_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('student_grade_periode_id') }}
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
            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                <label for="code">{{ trans('global.bill.fields.code') }}*</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('code', isset($bill) ? $bill->code : '') }}">
                @if($errors->has('code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('code') }}
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
            <div class="checkbox">
            <label>Status Bayar?</label>
            <input type="checkbox" data-toggle="toggle" name="status" id="status" data-on="Sudah" data-off="Belum" {{ old('status', $bill->status=='paid' ? 'checked' : '') }}>    
            </div>
                @if($errors->has('status'))
                    <em class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('global.bill.fields.status_helper') }}
                </p>
                <input type="hidden" id="student_grade_periode_id" name="student_grade_periode_id" value="{{ $student_grade_periode->id }}">
                <input type="hidden" id="periode" name="periode" value="{{ $periode }}">
            </div>

            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection