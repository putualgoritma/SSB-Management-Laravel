@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('global.student.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.students.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                <label for="code">{{ trans('global.student.fields.code') }}*</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('code', isset($student) ? $student->code : '') }}">
                @if($errors->has('code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('global.student.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($student) ? $student->name : '') }}">
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('alias') ? 'has-error' : '' }}">
                <label for="alias">{{ trans('global.student.fields.alias') }}*</label>
                <input type="text" id="alias" name="alias" class="form-control" value="{{ old('alias', isset($student) ? $student->alias : '') }}">
                @if($errors->has('alias'))
                    <em class="invalid-feedback">
                        {{ $errors->first('alias') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('place') ? 'has-error' : '' }}">
                <label for="place">{{ trans('global.student.fields.place') }}*</label>
                <input type="text" id="place" name="place" class="form-control" value="{{ old('place', isset($student) ? $student->place : '') }}">
                @if($errors->has('place'))
                    <em class="invalid-feedback">
                        {{ $errors->first('place') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                <label for="date">{{ trans('global.student.fields.date') }}*</label>
                <input type="date" id="date" name="date" class="form-control" value="{{ old('date', isset($student) ? $student->date : '') }}">
                @if($errors->has('date'))
                    <em class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('grade') ? 'has-error' : '' }}">
                <label for="grade">{{ trans('global.student.fields.grade_id') }}*</label>
                <select id="grade_id" name="grade_id" class="form-control" value="{{ old('grade_id', isset($student) ? $student->grade_id : '') }}">
                <option value="0">--Pilih Kelompok Umur--</option>
                @foreach($grades as $grade)
                <option value="{{$grade->id}}">{{ $grade->name}}</option>
                @endforeach
                 </select>
                </select>
                @if($errors->has('grade_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('grade_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('team') ? 'has-error' : '' }}">
                <label for="team">{{ trans('global.student.fields.team_id') }}*</label>
                <select id="team_id" name="team_id" class="form-control" value="{{ old('team_id', isset($student) ? $student->team_id : '') }}">
                <option value="0">--Pilih Kelompok Tim--</option>
                @foreach($teams as $team)
                <option value="{{$team->id}}">{{ $team->name}}</option>
                @endforeach
                 </select>
                </select>
                @if($errors->has('team_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('team_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
                <label for="gender">{{ trans('global.student.fields.gender') }}*</label>
                <select id="gender" name="gender" class="form-control" value="{{ old('gender', isset($student) ? $student->gender : '') }}">
                    <option value="">--Pilih Jenis Kelamin--</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                @if($errors->has('gender'))
                    <em class="invalid-feedback">
                        {{ $errors->first('gender') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('school') ? 'has-error' : '' }}">
                <label for="school">{{ trans('global.student.fields.school') }}*</label>
                <input type="text" id="school" name="school" class="form-control" value="{{ old('school', isset($student) ? $student->school : '') }}">
                @if($errors->has('school'))
                    <em class="invalid-feedback">
                        {{ $errors->first('school') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('gradeoriginal') ? 'has-error' : '' }}">
                <label for="gradeoriginal">{{ trans('global.student.fields.gradeoriginal') }}*</label>
                <input type="text" id="gradeoriginal" name="gradeoriginal" class="form-control" value="{{ old('gradeoriginal', isset($student) ? $student->gradeoriginal : '') }}">
                @if($errors->has('gradeoriginal'))
                    <em class="invalid-feedback">
                        {{ $errors->first('gradeoriginal') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('nisn') ? 'has-error' : '' }}">
                <label for="nisn">{{ trans('global.student.fields.nisn') }}*</label>
                <input type="text" id="nisn" name="nisn" class="form-control" value="{{ old('nisn', isset($student) ? $student->nisn : '') }}">
                @if($errors->has('nisn'))
                    <em class="invalid-feedback">
                        {{ $errors->first('nisn') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('religion') ? 'has-error' : '' }}">
                <label for="religion">{{ trans('global.student.fields.religion') }}*</label>
                <input type="text" id="religion" name="religion" class="form-control" value="{{ old('religion', isset($student) ? $student->religion : '') }}">
                @if($errors->has('religion'))
                    <em class="invalid-feedback">
                        {{ $errors->first('religion') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                <label for="address">{{ trans('global.student.fields.address') }}*</label>
                <input type="text" id="address" name="address" class="form-control" value="{{ old('address', isset($student) ? $student->address : '') }}">
                @if($errors->has('address'))
                    <em class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('village') ? 'has-error' : '' }}">
                <label for="village">{{ trans('global.student.fields.village') }}*</label>
                <input type="text" id="village" name="village" class="form-control" value="{{ old('village', isset($student) ? $student->village : '') }}">
                @if($errors->has('village'))
                    <em class="invalid-feedback">
                        {{ $errors->first('village') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('district') ? 'has-error' : '' }}">
                <label for="district">{{ trans('global.student.fields.district') }}*</label>
                <input type="text" id="district" name="district" class="form-control" value="{{ old('district', isset($student) ? $student->district : '') }}">
                @if($errors->has('district'))
                    <em class="invalid-feedback">
                        {{ $errors->first('district') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('regency') ? 'has-error' : '' }}">
                <label for="regency">{{ trans('global.student.fields.regency') }}*</label>
                <input type="text" id="regency" name="regency" class="form-control" value="{{ old('regency', isset($student) ? $student->regency : '') }}">
                @if($errors->has('regency'))
                    <em class="invalid-feedback">
                        {{ $errors->first('regency') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">{{ trans('global.student.fields.email') }}*</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', isset($student) ? $student->email : '') }}">
                @if($errors->has('email'))
                    <em class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                <label for="phone">{{ trans('global.student.fields.phone') }}*</label>
                <input type="teks" id="phone" name="phone" class="form-control" value="{{ old('phone', isset($student) ? $student->phone : '') }}">
                @if($errors->has('phone'))
                    <em class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('jerseynumber') ? 'has-error' : '' }}">
                <label for="jerseynumber">{{ trans('global.student.fields.jerseynumber') }}*</label>
                <input type="text" id="jerseynumber" name="jerseynumber" class="form-control" value="{{ old('jerseynumber', isset($student) ? $student->jerseynumber : '') }}">
                @if($errors->has('jerseynumber'))
                    <em class="invalid-feedback">
                        {{ $errors->first('jerseynumber') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('jerseysize') ? 'has-error' : '' }}">
                <label for="jerseysize">{{ trans('global.student.fields.jerseysize') }}*</label>
                <input type="text" id="jerseysize" name="jerseysize" class="form-control" value="{{ old('jerseysize', isset($student) ? $student->jerseysize : '') }}">
                @if($errors->has('jerseysize'))
                    <em class="invalid-feedback">
                        {{ $errors->first('jerseysize') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('position') ? 'has-error' : '' }}">
                <label for="position">{{ trans('global.student.fields.position') }}*</label>
                <input type="text" id="position" name="position" class="form-control" value="{{ old('position', isset($student) ? $student->position : '') }}">
                @if($errors->has('position'))
                    <em class="invalid-feedback">
                        {{ $errors->first('position') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('fathername') ? 'has-error' : '' }}">
                <label for="fathername">{{ trans('global.student.fields.fathername') }}*</label>
                <input type="text" id="fathername" name="fathername" class="form-control" value="{{ old('fathername', isset($student) ? $student->fathername : '') }}">
                @if($errors->has('fathername'))
                    <em class="invalid-feedback">
                        {{ $errors->first('fathername') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('fatherjob') ? 'has-error' : '' }}">
                <label for="fatherjob">{{ trans('global.student.fields.fatherjob') }}*</label>
                <input type="text" id="fatherjob" name="fatherjob" class="form-control" value="{{ old('fatherjob', isset($student) ? $student->fatherjob : '') }}">
                @if($errors->has('fatherjob'))
                    <em class="invalid-feedback">
                        {{ $errors->first('fatherjob') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('fatherphone') ? 'has-error' : '' }}">
                <label for="fatherphone">{{ trans('global.student.fields.fatherphone') }}*</label>
                <input type="text" id="fatherphone" name="fatherphone" class="form-control" value="{{ old('fatherphone', isset($student) ? $student->fatherphone : '') }}">
                @if($errors->has('fatherphone'))
                    <em class="invalid-feedback">
                        {{ $errors->first('fatherphone') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('mothername') ? 'has-error' : '' }}">
                <label for="mothername">{{ trans('global.student.fields.mothername') }}*</label>
                <input type="text" id="mothername" name="mothername" class="form-control" value="{{ old('mothername', isset($student) ? $student->mothername : '') }}">
                @if($errors->has('mothername'))
                    <em class="invalid-feedback">
                        {{ $errors->first('mothername') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('motherjob') ? 'has-error' : '' }}">
                <label for="motherjob">{{ trans('global.student.fields.motherjob') }}*</label>
                <input type="text" id="motherjob" name="motherjob" class="form-control" value="{{ old('motherjob', isset($student) ? $student->motherjob : '') }}">
                @if($errors->has('motherjob'))
                    <em class="invalid-feedback">
                        {{ $errors->first('motherjob') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('motherphone') ? 'has-error' : '' }}">
                <label for="motherphone">{{ trans('global.student.fields.motherphone') }}*</label>
                <input type="text" id="motherphone" name="motherphone" class="form-control" value="{{ old('motherphone', isset($student) ? $student->motherphone : '') }}">
                @if($errors->has('motherphone'))
                    <em class="invalid-feedback">
                        {{ $errors->first('motherphone') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('photo') ? 'has-error' : '' }}">
                <label for="photo">{{ trans('global.student.fields.photo') }}*</label>
                <input type="text" id="photo" name="photo" class="form-control" value="{{ old('photo', isset($student) ? $student->photo : '') }}">
                @if($errors->has('photo'))
                    <em class="invalid-feedback">
                        {{ $errors->first('photo') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('familylist') ? 'has-error' : '' }}">
                <label for="familylist">{{ trans('global.student.fields.familylist') }}*</label>
                <input type="text" id="familylist" name="familylist" class="form-control" value="{{ old('familylist', isset($student) ? $student->familylist : '') }}">
                @if($errors->has('familylist'))
                    <em class="invalid-feedback">
                        {{ $errors->first('familylist') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('ijazah') ? 'has-error' : '' }}">
                <label for="ijazah">{{ trans('global.student.fields.ijazah') }}*</label>
                <input type="text" id="ijazah" name="ijazah" class="form-control" value="{{ old('ijazah', isset($student) ? $student->ijazah : '') }}">
                @if($errors->has('ijazah'))
                    <em class="invalid-feedback">
                        {{ $errors->first('ijazah') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('birthcertificate') ? 'has-error' : '' }}">
                <label for="birthcertificate">{{ trans('global.student.fields.birthcertificate') }}*</label>
                <input type="text" id="birthcertificate" name="birthcertificate" class="form-control" value="{{ old('birthcertificate', isset($student) ? $student->birthcertificate : '') }}">
                @if($errors->has('birthcertificate'))
                    <em class="invalid-feedback">
                        {{ $errors->first('birthcertificate') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('note') ? 'has-error' : '' }}">
                <label for="note">{{ trans('global.student.fields.note') }}*</label>
                <input type="text" id="note" name="note" class="form-control" value="{{ old('note', isset($student) ? $student->note : '') }}">
                @if($errors->has('note'))
                    <em class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('register') ? 'has-error' : '' }}">
                <label for="register">{{ trans('global.student.fields.register') }}*</label>
                <input type="date" id="register" name="register" class="form-control" value="{{ old('register', isset($student) ? $student->register : '') }}">
                @if($errors->has('register'))
                    <em class="invalid-feedback">
                        {{ $errors->first('register') }}
                    </em>
                @endif
            </div>
           
            <!-- <div class="form-group {{ $errors->has('grade_id') ? 'has-error' : '' }}">
                <label for="roles">{{ trans('global.student.fields.grade_id') }}*
                    <span class="btn btn-info btn-xs select-all">Select all</span>
                    <span class="btn btn-info btn-xs deselect-all">Deselect all</span></label>
                <select name="grade_id" id="grade_id" class="form-control select2" multiple="multiple">
                    @foreach($grades as $id => $grades)
                        <option value="{{ $id }}" {{ (in_array($id, old('grade_id', [])) || isset($student) && $student->grades->contains($id)) ? 'selected' : '' }}>
                            {{ $grades }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('grades_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('grades_id') }}
                    </em>
                @endif
            </div> -->
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection