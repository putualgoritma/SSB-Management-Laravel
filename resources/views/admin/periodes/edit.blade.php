@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.periode.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.periodes.update", [$periode->id]) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
            @csrf
            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                <label for="code">{{ trans('global.periode.fields.code') }}*</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('code', isset($periode) ? $periode->code : '') }}">
                @if($errors->has('code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.periode.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($periode) ? $periode->name : '') }}">
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('periode') ? 'has-error' : '' }}">
                <label for="periode">{{ trans('global.periode.fields.periode') }}*</label>
                <input type="text" id="periode" name="periode" class="form-control" value="{{ old('periode', isset($periode) ? $periode->name : '') }}">
                @if($errors->has('periode'))
                    <em class="invalid-feedback">
                        {{ $errors->first('periode') }}
                    </em>
                @endif
            </div>

            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                <label for="status">{{ trans('global.periode.fields.status') }}*</label>
                <select id="status" name="status" class="form-control" value="{{ old('status', isset($periode) ? $periode->status : '') }}">
                    <option value="active" {{$periode->status == 'active' ? 'selected' : ''}}>Active</option>
                    <option value="close" {{$periode->status == 'close' ? 'selected' : ''}}>Non Active</option>
                </select>
                @if($errors->has('status'))
                    <em class="invalid-feedback">
                        {{ $errors->first('status') }}
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