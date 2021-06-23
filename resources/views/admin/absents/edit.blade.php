@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.absent.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.absents.update", [$absent->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                <label for="code">{{ trans('global.absent.fields.code') }}*</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('code', isset($absent) ? $absent->code : '') }}">
                @if($errors->has('code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('register') ? 'has-error' : '' }}">
                <label for="start">{{ trans('global.schedule.fields.start') }}</label>
                <input type="date" id="register" name="register" class="form-control" value="{{ old('register', isset($absent) ? $absent->register : '') }}">
                @if($errors->has('register'))
                    <em class="invalid-feedback">
                        {{ $errors->first('register') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('schedule_id') ? 'has-error' : '' }}">
                <label for="schedule_id">{{ trans('global.absent.fields.schedule_id') }}*</label>
                <select id="schedule_id" name="schedule_id" class="form-control" value="{{ old('schedule_id', isset($absent) ? $absent->schedule_id : '') }}">
                @foreach($schedules as $schedule)
                <option value="{{$schedule->id}}" {{$absent->schedule->id == $schedule->id ? 'selected' : ''}}>{{ $schedule->register}}</option>
                @endforeach
                 </select>
                </select>
                @if($errors->has('schedule_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('schedule_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('student_id') ? 'has-error' : '' }}">
                <label for="student_id">{{ trans('global.absent.fields.student_id') }}*</label>
                <select id="student_id" name="student_id" class="form-control" value="{{ old('student_id', isset($absent) ? $absent->student_id : '') }}">
                @foreach($students as $student)
                <option value="{{$student->id}}" {{$absent->student->id == $student->id ? 'selected' : ''}}>{{ $student->name}}</option>
                @endforeach
                 </select>
                </select>
                @if($errors->has('student_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('student_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('presence') ? 'has-error' : '' }}">
                <label for="presence">{{ trans('global.absent.fields.presence') }}*</label>
                <input type="text" id="presence" name="presence" class="form-control" value="{{ old('presence', isset($absent) ? $absent->presence : '') }}">
                @if($errors->has('presence'))
                    <em class="invalid-feedback">
                        {{ $errors->first('presence') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">{{ trans('global.absent.fields.description') }}*</label>
                <input type="text" id="description" name="description" class="form-control" value="{{ old('description', isset($absent) ? $absent->description : '') }}">
                @if($errors->has('description'))
                    <em class="invalid-feedback">
                        {{ $errors->first('description') }}
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