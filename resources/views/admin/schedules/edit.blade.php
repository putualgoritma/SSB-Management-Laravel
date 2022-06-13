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
                <input type="hidden" id="grade_periode_id" name="grade_periode_id" value="{{ $schedule->grade_periode_id }}">
            </div>            
            <div class="form-group {{ $errors->has('semester_id') ? 'has-error' : '' }}">
                <label for="semester_id">{{ trans('global.schedule.fields.semester_id') }}*</label>
                <select id="semester_id" name="semester_id" class="form-control" value="{{ old('semester_id', isset($schedule) ? $schedule->semester_id : '') }}">
                <option value="0">--Pilih Semester--</option>
                @foreach($semesters as $semester)
                <option value="{{$semester->id}}" {{$schedule->semester_id == $semester->id ? 'selected' : ''}}>{{ $semester->name}}</option>
                @endforeach
                 </select>
                </select>
                @if($errors->has('semester'))
                    <em class="invalid-feedback">
                        {{ $errors->first('semester') }}
                    </em>
                @endif
            </div>            
            <div class="form-group {{ $errors->has('register') ? 'has-error' : '' }}">
                <label for="register">{{ trans('global.schedule.fields.register') }}*</label>
                <select id="register" name="register" class="form-control" value="{{ old('register', isset($schedule) ? $schedule->register : '') }}">
                    <option value="" {{$schedule->register == "" ? 'selected' : ''}}>--Pilih Hari--</option>
                    <option value="Sunday" {{$schedule->register == "Sunday" ? 'selected' : ''}}>Minggu</option>
                    <option value="Monday" {{$schedule->register == "Monday" ? 'selected' : ''}}>Senin</option>
                    <option value="Tuesday" {{$schedule->register == "Tuesday" ? 'selected' : ''}}>Selasa</option>
                    <option value="Wednesday" {{$schedule->register == "Wednesday" ? 'selected' : ''}}>Rabu</option>
                    <option value="Thursday" {{$schedule->register == "Thursday" ? 'selected' : ''}}>Kamis</option>
                    <option value="Friday" {{$schedule->register == "Friday" ? 'selected' : ''}}>Jumat</option>
                    <option value="Saturday" {{$schedule->register == "Saturday" ? 'selected' : ''}}>Sabtu</option>
                </select>
                @if($errors->has('register'))
                    <em class="invalid-feedback">
                        {{ $errors->first('register') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('subject_id') ? 'has-error' : '' }}">
                <label for="subject_id">{{ trans('global.schedule.fields.subject_id') }}*</label>
                <select id="subject_id" name="subject_id" class="form-control" value="{{ old('subject_id', isset($schedule) ? $schedule->subject_id : '') }}">
                <option value="0"{{$schedule->subject_id =='0' ? 'selected' : ''}}>--Pilih subject--</option>
                @foreach($subjects as $subject)
                <option value="{{$subject->id}}" {{$schedule->subject_id == $subject->id ? 'selected' : ''}}>{{ $subject->name}}</option>
                @endforeach
                 </select>
                </select>
                @if($errors->has('subject'))
                    <em class="invalid-feedback">
                        {{ $errors->first('subject') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('start') ? 'has-error' : '' }}">
                <label for="start">{{ trans('global.schedule.fields.start') }}*</label>
                <input type="time" id="start" name="start" class="form-control" value="{{ old('start', isset($schedule) ? $schedule->start : '') }}">
                @if($errors->has('start'))
                    <em class="invalid-feedback">
                        {{ $errors->first('start') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('end') ? 'has-error' : '' }}">
                <label for="end">{{ trans('global.schedule.fields.end') }}*</label>
                <input type="time" id="end" name="end" class="form-control" value="{{ old('end', isset($schedule) ? $schedule->end : '') }}">
                @if($errors->has('end'))
                    <em class="invalid-feedback">
                        {{ $errors->first('end') }}
                    </em>
                @endif
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
                        @foreach (old('teachers', $schedule->teachers->count() ? $schedule->teachers : ['']) as $schedule_teacher)
                                <tr id="teacher{{ $loop->index }}">
                                    <td>
                                        <select name="teachers[]" class="form-control teacher_list">
                                            <option value="">-- Pilih Guru --</option>
                                            @foreach ($teachers as $teacher)
                                            <option value="{{$teacher->id}}"@if (old('teachers.' . $loop->index, optional($schedule_teacher)->id) == $teacher->id) selected @endif>{{ $teacher->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="positions[]" class="form-control position_list">
                                            <option value=""@if (old('positions.' . $loop->index, optional($schedule_teacher)->pivot->position) == '') selected @endif>-- Pilih Posisi --</option>
                                            <option value="head"@if (old('positions.' . $loop->index, optional($schedule_teacher)->pivot->position) == 'head') selected @endif>Utama</option>
                                            <option value="assistant"@if (old('positions.' . $loop->index, optional($schedule_teacher)->pivot->position) == 'assistant') selected @endif>Asisten</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                            <tr id="teacher{{ count(old('teachers', $schedule->teachers->count() ? $schedule->teachers : [''])) }}"></tr>
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
        let row_number = {{ count(old('teachers', $schedule->teachers->count() ? $schedule->teachers : [''])) }};
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
