@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.session.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.absents.sessionsStore") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('register') ? 'has-error' : '' }}">
                <label for="regiser">{{ trans('global.session.fields.register') }}*</label>
                <input type="date" id="register" name="register" class="form-control" value="{{ old('register', isset($session) ? $session->register : '') }}">
                @if($errors->has('register'))
                    <em class="invalid-feedback">
                        {{ $errors->first('register') }}
                    </em>
                @endif
                <input type="hidden" id="schedule_id" name="schedule_id" value="{{ $request->schedule_id }}">
                <input type="hidden" id="grade_periode_id" name="grade_periode_id" value="{{ $request->grade_periode_id }}">
            </div>            
            <div class="card">
                <div class="card-header">
                    Pilih Guru
                </div>

                <div class="card-body">
                    <table class="table" id="teachers_table">
                        <thead>
                            <tr>
                                <th>Guru</th>
                                <th>Posisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (old('teachers', ['']) as $index => $oldTeacher)
                                <tr id="teacher{{ $index }}">
                                    <td>
                                        <select name="teachers[]" class="form-control teacher_list">
                                            <option value="">-- Pilih Guru --</option>
                                            @foreach ($teachers as $teacher)
                                            <option value="{{$teacher->id}}">{{ $teacher->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="positions[]" class="form-control position_list">
                                            <option value="">-- Pilih Posisi --</option>
                                            <option value="head">Utama</option>
                                            <option value="assistant">Asisten</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                            <tr id="teacher{{ count(old('teachers', [''])) }}"></tr>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-md-12">
                            <button id="add_row" class="btn btn-default pull-left">+ Add Row</button>
                            <button id='delete_row' class="pull-right btn btn-danger">- Delete Row</button>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection
@section('scripts')
<script>
  $(document).ready(function(){
    let row_number = {{ count(old('teachers', [''])) }};
    $("#add_row").click(function(e){
      e.preventDefault();
      let new_row_number = row_number - 1;
      $('#teacher' + row_number).html($('#teacher' + new_row_number).html()).find('td:first-child');
      $('#teachers_table').append('<tr id="teacher' + (row_number + 1) + '"></tr>');
      row_number++;
    });

    $("#delete_row").click(function(e){
      e.preventDefault();
      if(row_number > 1){
        $("#teacher" + (row_number - 1)).html('');
        row_number--;
      }
    });
});
    </script>
@endsection
