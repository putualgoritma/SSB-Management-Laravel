@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.schedule.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.schedules.update", [$schedule->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                <label for="code">{{ trans('global.schedule.fields.code') }}*</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('code', isset($schedule) ? $schedule->code : '') }}">
                @if($errors->has('code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('register') ? 'has-error' : '' }}">
                <label for="start">{{ trans('global.schedule.fields.start') }}</label>
                <input type="date" id="register" name="register" class="form-control" value="{{ old('register', isset($schedule) ? $schedule->register : '') }}">
                @if($errors->has('register'))
                    <em class="invalid-feedback">
                        {{ $errors->first('register') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('start') ? 'has-error' : '' }}">
                <label for="start">{{ trans('global.schedule.fields.start') }}</label>
                <input type="text" id="start" name="start" class="form-control" value="{{ old('start', isset($schedule) ? $schedule->start : '') }}">
                @if($errors->has('start'))
                    <em class="invalid-feedback">
                        {{ $errors->first('start') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('end') ? 'has-error' : '' }}">
                <label for="end">{{ trans('global.schedule.fields.end') }}</label>
                <input type="text" id="end" name="end" class="form-control" value="{{ old('end', isset($schedule) ? $schedule->end : '') }}">
                @if($errors->has('end'))
                    <em class="invalid-feedback">
                        {{ $errors->first('end') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('periode') ? 'has-error' : '' }}">
                <label for="periode">{{ trans('global.schedule.fields.periode') }}</label>
                <input type="text" id="periode" name="periode" class="form-control" value="{{ old('periode', isset($schedule) ? $schedule->periode : '') }}">
                @if($errors->has('periode'))
                    <em class="invalid-feedback">
                        {{ $errors->first('periode') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('teacher_id') ? 'has-error' : '' }}">
                <label for="teacher_id">{{ trans('global.schedule.fields.teacher_id') }}*
                    <span class="btn btn-info btn-xs select-all">Select all</span>
                    <span class="btn btn-info btn-xs deselect-all">Deselect all</span></label>
                <select name="teacher_id" id="teacher_id" class="form-control select2" multiple="multiple">
                    @foreach($teachers as $id => $teacher)
                    <option value="{{$teacher->id}}" {{$schedule->teacher->id == $teacher->id ? 'selected' : ''}}>{{ $teacher->name}}</option>
                        </option>
                    @endforeach
                </select>
                @if($errors->has('teacher_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('teacher_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('subject_id') ? 'has-error' : '' }}">
                <label for="subject_id">{{ trans('global.schedule.fields.subject_id') }}*</label>
                <select id="subject_id" name="subject_id" class="form-control" value="{{ old('subject_id', isset($schedule) ? $schedule->subject_id : '') }}">
                @foreach($subjects as $subject)
                <option value="{{$subject->id}}" {{$schedule->subject->id == $subject->id ? 'selected' : ''}}>{{ $subject->name}}</option>
                @endforeach
                 </select>
                </select>
                @if($errors->has('subject_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('subject_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('grade_id') ? 'has-error' : '' }}">
                <label for="grade_id">{{ trans('global.schedule.fields.grade_id') }}*</label>
                <select id="grade_id" name="grade_id" class="form-control" value="{{ old('grade_id', isset($schedule) ? $schedule->grade_id : '') }}">
                @foreach($grades as $grade)
                <option value="{{$grade->id}}" {{$schedule->grade->id == $grade->id ? 'selected' : ''}}>{{ $grade->name}}</option>
                @endforeach
                 </select>
                </select>
                @if($errors->has('grade'))
                    <em class="invalid-feedback">
                        {{ $errors->first('grade') }}
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