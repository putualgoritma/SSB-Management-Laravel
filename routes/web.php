<?php

//Route::get('member/register', 'MembersController@register');
Route::resource('member', 'MembersController');

Route::redirect('/', '/login');

Route::redirect('/home', '/admin');

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');

    Route::resource('permissions', 'PermissionsController');

    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');

    Route::resource('roles', 'RolesController');

    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');

    Route::resource('users', 'UsersController');

    Route::resource('students','StudentsController');

    Route::resource('teachers','TeachersController');
    
    Route::resource('grades','GradesController');
    Route::delete('grades/destroy', 'GradesController@massDestroy')->name('grades.massDestroy');

    Route::resource('subjects','SubjectsController');

    Route::delete('tests/destroy', 'TestsController@massDestroy')->name('tests.massDestroy');
    Route::resource('tests','TestsController');
    

    Route::resource('schedules','SchedulesController');
    Route::get('schedules/createsubject','ScheduleController@createsubject');
    Route::get('schedule/grades','SchedulesController@grades')->name('schedules.grades');

    Route::resource('absents','AbsentsController');
    Route::get('absent/schedule', 'AbsentsController@schedule')->name('absents.schedule');
    Route::get('absent/list/{id}/{grade}', 'AbsentsController@index')->name('absents.list');
    Route::get('absent/presence/{sid}/{reg}/{ssid}', 'AbsentsController@presence')->name('absents.presence');
    Route::post('absent/presence-process', 'AbsentsController@presenceProcess')->name('absents.presenceprocess');
    Route::get('absent/bill/{sid}/{reg}/{ssid}', 'AbsentsController@bill')->name('absents.bill');
    Route::post('absent/bill-process', 'AbsentsController@billProcess')->name('absents.billprocess');

    Route::delete('bills/destroy', 'TestsController@massDestroy')->name('bills.massDestroy');
    Route::resource('bills','BillsController');
    Route::get('bills/paid/{id}/{period}', 'BillsController@paid')->name('bills.paid');
    Route::post('bills/paid-process', 'BillsController@paidProcess')->name('bills.paidprocess');

    Route::delete('semesters/destroy', 'SemestersController@massDestroy')->name('semesters.massDestroy');
    Route::resource('semesters','SemestersController');

    Route::resource('periodes','PeriodesController');

    Route::resource('teams','TeamsController');

    Route::resource('gradeperiodes','GradePeriodesController');
    Route::delete('gradeperiodes/destroy', 'GradePeriodesController@massDestroy')->name('gradeperiodes.massDestroy');
    //Route::get('gradeperiodes/{id}', 'GradePeriodesController@index')->name('gradeperiodes.index');
    Route::get('gradeperiodes/student-grade/{id}', 'GradePeriodesController@studentGrade')->name('gradeperiodes.studentGrade');
    Route::get('gradeperiodes/students/{id}', 'GradePeriodesController@students')->name('gradeperiodes.students');
    Route::get('gradeperiodes/student-add/{gid}/{sid}', 'GradePeriodesController@studentAdd')->name('gradeperiodes.studentAdd');
    Route::delete('gradeperioder/student-remove', 'GradePeriodesController@studentRemove')->name('gradeperioder.studentRemove');
});
