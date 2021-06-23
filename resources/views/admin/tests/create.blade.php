@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.test.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.tests.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                <label for="code">{{ trans('global.test.fields.code') }}*</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('code', isset($test) ? $test->code : '') }}">
                @if($errors->has('code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.test.fields.name') }}*</label>
                <select id="name" name="name" class="form-control" value="{{ old('name', isset($test) ? $test->name : '') }}">
                    <option value="">--Pilih Jenis Test--</option>
                    <option value="Daily">Harian</option>
                    <option value="Middle">Tengah Semester</option>
                    <option value="End">Akhir Semester</option>
                </select>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('value') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.test.fields.value') }}*</label>
                <input type="text" id="value" name="value" class="form-control" value="{{ old('value', isset($test) ? $test->value : '') }}">
                @if($errors->has('value'))
                    <em class="invalid-feedback">
                        {{ $errors->first('value') }}
                    </em>
                @endif
            </div>
             <div class="form-group {{ $errors->has('student_id') ? 'has-error' : '' }}">
                <label for="roles">{{ trans('global.test.fields.student_id') }}*
                   </label>
                <select name="student_id" id="student_id" class="form-control select2" multiple="multiple">
                    @foreach($students as $student)
                    <option value="{{$student->id}}">{{ $student->name}}</option>
                        </option>
                    @endforeach
                </select>
                @if($errors->has('student_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('student_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
                <label for="subject">{{ trans('global.test.fields.subject_id') }}*</label>
                <select id="subject_id" name="subject_id" class="form-control" value="{{ old('subject_id', isset($test) ? $test->subject_id : '') }}">
                <option value="0">--Pilih Kelas--</option>
                @foreach($subjects as $subject)
                <option value="{{$subject->id}}">{{ $subject->name}}</option>
                @endforeach
                 </select>
                </select>
                @if($errors->has('subject'))
                    <em class="invalid-feedback">
                        {{ $errors->first('subject') }}
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