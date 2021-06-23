@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('global.gradeperiode.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.gradeperiodes.update", [$gradeperiode->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('grade') ? 'has-error' : '' }}">
                <label for="grade">{{ trans('global.gradeperiode.fields.grade_id') }}*</label>
                <select id="grade_id" name="grade_id" class="form-control" value="{{ old('grade_id', isset($gradeperiode) ? $gradeperiode->grade_id : '') }}">
                <option value="0">--Pilih Kelas--</option>
                @foreach($grades as $grade)
                <option value="{{$grade->id}}" {{$grade->id == $gradeperiode->grade_id ? 'selected' : ''}}>{{ $grade->name}}</option>
                @endforeach
                 </select>
                </select>
                @if($errors->has('grade_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('grade_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('periode') ? 'has-error' : '' }}">
                <label for="periode">{{ trans('global.gradeperiode.fields.periode_id') }}*</label>
                <select id="periode_id" name="periode_id" class="form-control" value="{{ old('periode_id', isset($gradeperiode) ? $gradeperiode->periode_id : '') }}">
                <option value="0">--Pilih Periode--</option>
                @foreach($periodes as $periode)
                <option value="{{$periode->id}}" {{$periode->id == $gradeperiode->periode_id ? 'selected' : ''}}>{{ $periode->name}}</option>
                @endforeach
                 </select>
                </select>
                @if($errors->has('periode_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('periode_id') }}
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
