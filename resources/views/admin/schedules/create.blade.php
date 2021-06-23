@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.schedule.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.schedules.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                <label for="code">{{ trans('global.schedule.fields.code') }}*</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('code', isset($schedule) ? $schedule->code : '') }}">
                @if($errors->has('code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </em>
                @endif
            </div>
            
            <div class="form-group {{ $errors->has('periode_id') ? 'has-error' : '' }}">
                <label for="periode_id">{{ trans('global.schedule.fields.periode_id') }}*</label>
                <select id="periode_id" name="periode_id" class="form-control" value="{{ old('periode_id', isset($schedule) ? $schedule->periode_id : '') }}">
                <option value="0">--Pilih Periode--</option>
                @foreach($periodes as $periode)
                <option value="{{$periode->id}}">{{ $periode->periode}}</option>
                @endforeach
                 </select>
                </select>
                @if($errors->has('periode_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('periode_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('semester_id') ? 'has-error' : '' }}">
                <label for="semester_id">{{ trans('global.schedule.fields.semester_id') }}*</label>
                <select id="semester_id" name="semester_id" class="form-control" value="{{ old('semester_id', isset($schedule) ? $schedule->semester_id : '') }}">
                <option value="0">--Pilih Semester--</option>
                @foreach($semesters as $semester)
                <option value="{{$semester->id}}">{{ $semester->name}}</option>
                @endforeach
                 </select>
                </select>
                @if($errors->has('semester'))
                    <em class="invalid-feedback">
                        {{ $errors->first('semester') }}
                    </em>
                @endif
            </div>            
            <div class="form-group {{ $errors->has('grade_id') ? 'has-error' : '' }}">
                <label for="grade_id">{{ trans('global.schedule.fields.grade_id') }}*</label>
                <select id="grade_id" name="grade_id" class="form-control" value="{{ old('grade_id', isset($schedule) ? $schedule->grade_id : '') }}">
                <option value="0">--Pilih Kelas--</option>
                @foreach($grades as $grade)
                <option value="{{$grade->id}}">{{ $grade->name}}</option>
                @endforeach
                 </select>
                </select>
                @if($errors->has('grade'))
                    <em class="invalid-feedback">
                        {{ $errors->first('grade') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('register') ? 'has-error' : '' }}">
                <label for="register">{{ trans('global.schedule.fields.register') }}*</label>
                <select id="register" name="register" class="form-control" value="{{ old('register', isset($schedule) ? $schedule->register : '') }}">
                    <option value="">--Pilih Hari--</option>
                    <option value="Sunday">Minggu</option>
                    <option value="Monday">Senin</option>
                    <option value="Tuesday">Selasa</option>
                    <option value="Wednesday">Rabu</option>
                    <option value="Thursday">Kamis</option>
                    <option value="Friday">Jumat</option>
                    <option value="Saturday">Sabtu</option>
                </select>
                @if($errors->has('register'))
                    <em class="invalid-feedback">
                        {{ $errors->first('register') }}
                    </em>
                @endif
            </div>
            <div class="card">
                <div class="card-header">
                    Jadwal Mata Pelajaran
                </div>

                <div class="card-body">
                    <table class="table" id="subjects_table">
                        <thead>
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                                <th>Mulai</th>
                                <th>Berakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (old('subjects', ['']) as $index => $oldSubject)
                                <tr id="subject{{ $index }}">
                                <td>
                                        <select name="subject_id[]" class="form-control subject_list">
                                            <option value="">-- Pilih Mata Pelajaran --</option>
                                            @foreach ($subjects as $subject)
                                            <option value="{{$subject->id}}">{{ $subject->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="teacher_id[]" class="form-control subject_list">
                                            <option value="">-- Pilih Guru --</option>
                                            @foreach ($teachers as $teacher)
                                            <option value="{{$teacher->id}}">{{ $teacher->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                    <input type="time" id="start" name="start[]" class="form-control" value="{{ old('start', isset($schedule) ? $schedule->start : '') }}">
                                    </td>
                                    <td>
                                    <input type="time" id="end" name="end[]" class="form-control" value="{{ old('end', isset($schedule) ? $schedule->end : '') }}">
                                    </td>
                                </tr>
                            @endforeach
                            <tr id="subject{{ count(old('subjects', [''])) }}"></tr>
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
    let row_number = {{ count(old('subjects', [''])) }};
    $("#add_row").click(function(e){
      e.preventDefault();
      let new_row_number = row_number - 1;
      $('#subject' + row_number).html($('#subject' + new_row_number).html()).find('td:first-child');
      $('#subjects_table').append('<tr id="subject' + (row_number + 1) + '"></tr>');
      row_number++;
    });
});
    $("#delete_row").click(function(e){
      e.preventDefault();
      if(row_number > 1){
        $("#subject" + (row_number - 1)).html('');
        row_number--;
      }
    });
    </script>
@endsection