@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.absent.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.absents.billprocess") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('register') ? 'has-error' : '' }}">
                <label for="register">{{ trans('global.absent.fields.register') }}*</label>
                <input type="date" id="register" name="register" class="form-control" readonly value="{{ old('register', isset($absent) ? $absent->register : '') }}">
                @if($errors->has('register'))
                    <em class="invalid-feedback">
                        {{ $errors->first('register') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('schedule_subject_id') ? 'has-error' : '' }}">
                <label for="schedule_subject_id">{{ trans('global.absent.fields.schedule_subject_id') }}*</label>
                <input type="text" id="schedule_subject_id" name="schedule_subject_id" class="form-control" readonly value="{{ old('schedule_subject_id', isset($absent) ? $absent->schedulesubject->subjects->name : '') }}">
                @if($errors->has('schedule_subject_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('schedule_subject_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('student_id') ? 'has-error' : '' }}">
                <label for="student_id">{{ trans('global.absent.fields.student_id') }}*</label>
                <input type="text" id="student_id" name="student_id" class="form-control" readonly value="{{ old('student_id', isset($absent) ? $absent->student->name : '') }}">
                @if($errors->has('student_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('student_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('bill') ? 'has-error' : '' }}">
            <label for="bill">{{ trans('global.absent.fields.bill') }}*</label>
                <select id="bill" name="bill" class="form-control" value="{{ old('bill', isset($absent) ? $absent->bill : '') }}">
                <option value="paid" {{$absent->bill == 'paid' ? 'selected' : ''}}>Sudah Bayar</option>
                <option value="unpaid" {{$absent->bill == 'unpaid' ? 'selected' : ''}}>Belum Bayar</option>
                 </select>
                </select>
                @if($errors->has('bill'))
                    <em class="invalid-feedback">
                        {{ $errors->first('bill') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
            <label for="amount">{{ trans('global.absent.fields.amount') }}*</label>
                <input type="text" id="amount" name="amount" class="form-control" value="{{ old('amount', isset($absent) ? $absent->amount : '') }}">
                @if($errors->has('amount'))
                    <em class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </em>
                @endif
                <input type="hidden" id="student_id_hidden" name="student_id_hidden" value="{{ $absent->student_id }}">
                <input type="hidden" id="schedule_subject_id_hidden" name="schedule_subject_id_hidden" value="{{ $absent->schedule_subject_id }}">
            </div>
            
            
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection