@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.user.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.grades.update", [$grade->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                <label for="code">{{ trans('global.grade.fields.code') }}*</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('code', isset($grade) ? $grade->code : '') }}">
                @if($errors->has('code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.grade.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($grade) ? $grade->name : '') }}">
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('agemin') ? 'has-error' : '' }}">
                <label for="agemin">{{ trans('global.grade.fields.agemin') }}*</label>
                <input type="text" id="agemin" name="agemin" class="form-control" value="{{ old('agemin', isset($grade) ? $grade->agemin : '') }}">
                @if($errors->has('agemin'))
                    <em class="invalid-feedback">
                        {{ $errors->first('agemin') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('agemax') ? 'has-error' : '' }}">
                <label for="agemax">{{ trans('global.grade.fields.agemax') }}*</label>
                <input type="text" id="agemax" name="agemax" class="form-control" value="{{ old('agemax', isset($grade) ? $grade->agemax : '') }}">
                @if($errors->has('agemax'))
                    <em class="invalid-feedback">
                        {{ $errors->first('agemax') }}
                    </em>
                @endif
            </div>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection