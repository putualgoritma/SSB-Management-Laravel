@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.absent.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.absents.presenceprocess") }}" method="POST" enctype="multipart/form-data">
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
            <div class="form-group {{ $errors->has('session_id') ? 'has-error' : '' }}">
                <label for="session_id">{{ trans('global.subject.fields.name') }}*</label>
                <input type="text" id="session_id" name="session_id" class="form-control" readonly value="{{ old('session_id', isset($absent) ? $absent->sessions->schedules->subject->name : '') }}">
                @if($errors->has('session_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('session_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('student_grade_periode_id') ? 'has-error' : '' }}">
                <label for="student_grade_periode_id">{{ trans('global.student.fields.name') }}*</label>
                <input type="text" id="student_grade_periode_id" name="student_grade_periode_id" class="form-control" readonly value="{{ old('student_grade_periode_id', isset($absent) ? $absent->studentgradeperiodes->students->name : '') }}">
                @if($errors->has('student_grade_periode_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('student_grade_periode_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('presence') ? 'has-error' : '' }}">
            <label for="presence">{{ trans('global.absent.fields.presence') }}*</label>
                <select id="presence" name="presence" class="form-control" value="{{ old('presence', isset($absent) ? $absent->presence : '') }}">
                <option value="ijin" {{$absent->presence == 'ijin' ? 'selected' : ''}}>Ijin</option>
                <option value="sakit" {{$absent->presence == 'sakit' ? 'selected' : ''}}>Sakit</option>
                <option value="alpha" {{$absent->presence == 'alpha' ? 'selected' : ''}}>Alpha</option>
                <option value="masuk" {{$absent->presence == 'masuk' ? 'selected' : ''}}>Masuk</option>
                 </select>
                </select>
                @if($errors->has('presence'))
                    <em class="invalid-feedback">
                        {{ $errors->first('presence') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">{{ trans('global.absent.fields.description') }}*</label>
                <textarea id="description" name="description" class="form-control ">{{ old('description', isset($absent) ? $absent->description : '') }}</textarea>
                @if($errors->has('description'))
                    <em class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </em>
                @endif
                <input type="hidden" id="student_grade_periode_id_hidden" name="student_grade_periode_id_hidden" value="{{ $absent->student_grade_periode_id }}">
                <input type="hidden" id="session_id_hidden" name="session_id_hidden" value="{{ $absent->session_id }}">
            </div>
            
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection