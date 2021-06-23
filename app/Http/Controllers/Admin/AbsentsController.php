<?php

namespace App\Http\Controllers\Admin;

use App\Absent;
use App\Grade;
use App\Http\Controllers\Controller;
use App\Periode;
use App\Schedule;
use App\Schedule_subject;
use App\Semester;
use App\Student;
use App\Subject;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AbsentsController extends Controller
{

    public function schedule(Request $request)
    {
        abort_unless(\Gate::allows('absent_access'), 403);

        if ($request->ajax()) {
            //set query
            $qry = Schedule_subject::selectRaw("schedule_subjects.id,schedule_subjects.teacher_id,schedule_subjects.subject_id,schedules.code as schedule_code,schedules.register as schedule_register,periodes.name as periode_name,semesters.name as semester_name,grades.id as grade_id,grades.name as grade_name")
                ->leftjoin('schedules', 'schedule_subjects.schedule_id', '=', 'schedules.id')
                ->join('periodes', 'schedules.periode_id', '=', 'periodes.id')
                ->join('semesters', 'schedules.semester_id', '=', 'semesters.id')
                ->join('grades', 'schedules.grade_id', '=', 'grades.id')
                ->with('teachers')
                ->with('subjects')
                ->FilterPeriode()
                ->FilterSemester()
                ->FilterGrade()
                ->FilterRegister()
                ->get();
            $table = Datatables::of($qry);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'absent_show';
                $editGate = 'absent_edit';
                $deleteGate = 'absent_delete';
                $crudRoutePart = 'absents';

                return view('partials.datatablesAbsentSchedules', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });
            $table->editColumn('code', function ($row) {
                return $row->subjects->name ? $row->subjects->name : "";
            });

            $table->editColumn('periode', function ($row) {
                return $row->periode_name ? $row->periode_name : "";
            });

            $table->editColumn('semester', function ($row) {
                return $row->semester_name ? $row->semester_name : "";
            });

            $table->editColumn('grade', function ($row) {
                return $row->grade_name ? $row->grade_name : "";
            });

            $table->editColumn('register', function ($row) {
                return $row->schedule_register ? $row->schedule_register : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            $table->addIndexColumn();
            return $table->make(true);
        }
        //default view
        $schedules = Schedule_subject::selectRaw("schedule_subjects.id,schedule_subjects.teacher_id,schedule_subjects.subject_id,schedules.code as schedule_code,schedules.register as schedule_register,periodes.name as periode_name,semesters.name as semester_name,grades.name as grade_name")
            ->leftjoin('schedules', 'schedule_subjects.schedule_id', '=', 'schedules.id')
            ->join('periodes', 'schedules.periode_id', '=', 'periodes.id')
            ->join('semesters', 'schedules.semester_id', '=', 'semesters.id')
            ->join('grades', 'schedules.grade_id', '=', 'grades.id')
            ->with('teachers')
            ->with('subjects')
            ->FilterPeriode()
            ->FilterSemester()
            ->FilterGrade()
            ->FilterRegister()
            ->get();
        $periodes = Periode::all();
        $semesters = Semester::all();
        $grades = Grade::all();

        //return $schedules;
        return view('admin.absents.schedule', compact('schedules', 'periodes', 'semesters', 'grades'));
    }

    public function presence($student_id, $register, $schedule_subject_id)
    {
        abort_unless(\Gate::allows('absent_create'), 403);

        $absent = Absent::where('student_id', $student_id)
            ->where('register', $register)
            ->where('schedule_subject_id', $schedule_subject_id)
            ->with('student')
            ->with('schedulesubject')
            ->first();
        if (empty($absent)) {
            $student = Student::find($student_id);
            $Schedule_subject = Schedule_subject::find($schedule_subject_id);
            $subject = Subject::find($Schedule_subject->subject_id);
            $absent['student']['name'] = $student->name;
            $absent['schedulesubject']['subjects']['name'] = $subject->name;
            $absent['presence'] = 'alpha';
            $absent['register'] = $register;
            $absent['student_id'] = $student_id;
            $absent['schedule_subject_id'] = $schedule_subject_id;
            $absent['description'] = '';
            //$absent = (object) $absent;
        }        
        $absent = json_decode (json_encode ($absent), FALSE);
        //dd($absent);
        return view('admin.absents.presence', compact('absent'));
    }

    public function presenceProcess(Request $request)
    {
        abort_unless(\Gate::allows('absent_create'), 403);

        $absent = Absent::where('student_id', $request->input('student_id_hidden'))
            ->where('register', $request->input('register'))
            ->where('schedule_subject_id', $request->input('schedule_subject_id_hidden'))
            ->first();
        if (empty($absent)) {
            //create
            $data = ['register' => $request->input('register'), 'student_id' => $request->input('student_id_hidden'), 'schedule_subject_id' => $request->input('schedule_subject_id_hidden'), 'presence' => $request->input('presence'), 'description' => $request->input('description'), 'bill' => 'unpaid', 'amount' => 0];
            $absent = Absent::create($data);
        } else {
            //update
            $absent->presence = $request->input('presence');
            $absent->description = $request->input('description');
            $absent->save();
        }

        $schedule_subject = Schedule_subject::find($request->input('schedule_subject_id_hidden'));
        $schedule = Schedule::find($schedule_subject->schedule_id);

        return redirect(route("admin.absents.list",[$request->input('schedule_subject_id_hidden'),$schedule->grade_id]));
    }

    public function bill($student_id, $register, $schedule_subject_id)
    {
        abort_unless(\Gate::allows('absent_create'), 403);

        $absent = Absent::where('student_id', $student_id)
            ->where('register', $register)
            ->where('schedule_subject_id', $schedule_subject_id)
            ->with('student')
            ->with('schedulesubject')
            ->first();
        if (empty($absent)) {
            $student = Student::find($student_id);
            $Schedule_subject = Schedule_subject::find($schedule_subject_id);
            $subject = Subject::find($Schedule_subject->subject_id);
            $absent['student']['name'] = $student->name;
            $absent['schedulesubject']['subjects']['name'] = $subject->name;
            $absent['bill'] = 'unpaid';
            $absent['amount'] = 0;
            $absent['register'] = $register;
            $absent['student_id'] = $student_id;
            $absent['schedule_subject_id'] = $schedule_subject_id;
            $absent['description'] = '';
            //$absent = (object) $absent;
        }        
        $absent = json_decode (json_encode ($absent), FALSE);
        //dd($absent);
        return view('admin.absents.bill', compact('absent'));
    }

    public function billProcess(Request $request)
    {
        abort_unless(\Gate::allows('absent_create'), 403);

        $absent = Absent::where('student_id', $request->input('student_id_hidden'))
            ->where('register', $request->input('register'))
            ->where('schedule_subject_id', $request->input('schedule_subject_id_hidden'))
            ->first();
        if (empty($absent)) {
            //create
            $data = ['register' => $request->input('register'), 'student_id' => $request->input('student_id_hidden'), 'schedule_subject_id' => $request->input('schedule_subject_id_hidden'), 'presence' => 'alpha', 'bill' => $request->input('bill'), 'amount' => $request->input('amount')];
            $absent = Absent::create($data);
        } else {
            //update
            $absent->bill = $request->input('bill');
            $absent->amount = $request->input('amount');
            $absent->save();
        }

        $schedule_subject = Schedule_subject::find($request->input('schedule_subject_id_hidden'));
        $schedule = Schedule::find($schedule_subject->schedule_id);

        return redirect(route("admin.absents.list",[$request->input('schedule_subject_id_hidden'),$schedule->grade_id]));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $gid, Request $request)
    {
        abort_unless(\Gate::allows('absent_access'), 403);

        //get input
        $presence = $request->presence;
        $register = $request->register;
        $schedule_subject = Schedule_subject::find($id);
        $schedule = Schedule::with('subjects')->get()->find($schedule_subject->schedule_id);
        //return $schedule->subjects[0]['name'];

        if ($request->ajax()) {            
            //set query
            $qry = Student::selectRaw('students.*,absents.code,absents.register,absents.presence,absents.description,absents.schedule_subject_id,absents.amount')
                ->leftJoinSub(Absent::selectRaw('absents.*,subjects.name as subject_name')
                ->join('schedule_subjects', 'absents.schedule_subject_id', '=', 'schedule_subjects.id')
                ->join('subjects', 'schedule_subjects.subject_id', '=', 'subjects.id')        
                ->where(function ($query) use ($register,$id) {
                            if ($register != "") {
                                $query->where('absents.register', '=', $register);
                            }
                            $query->where('absents.schedule_subject_id', $id);
                        }),
                    'absents',
                    function ($join) {
                        $join->on('students.id', '=', 'absents.student_id');
                    }
                )
                ->where('students.grade_id', $gid)
                ->where(function ($query) use ($presence) {
                    if ($presence == "alpha") {
                        $query->where('absents.presence', '=', $presence)
                            ->orWhere('absents.presence', null);
                    } else if ($presence == "sakit" || $presence == "ijin" || $presence == "masuk") {
                        $query->where('absents.presence', '=', $presence);
                    }
                })
                ->get();
            $table = Datatables::of($qry);

            //set def register
            $register_def = $register;

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($register_def,$id) {
                $viewGate = 'absent_show';
                $editGate = 'absent_edit';
                $deleteGate = 'absent_delete';
                $crudRoutePart = 'absents';
                $schedule_subject_id = $id;

                return view('partials.absentsActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row',
                    'register_def',
                    'schedule_subject_id'
                ));
            });
            $table->editColumn('code', function ($row) use ($schedule) {
                return $schedule->subjects[0]['name'] ? $schedule->subjects[0]['name'] : "";
            });

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });

            $table->editColumn('register', function ($row) {
                return $row->register ? $row->register : "";
            });

            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });

            $table->editColumn('presence', function ($row) {
                return $row->presence ? $row->presence : "alpha";
            });

            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : 0;
            });

            $table->rawColumns(['actions', 'placeholder']);

            $table->addIndexColumn();
            return $table->make(true);
        }
        //default view
        $absents = Student::selectRaw('students.*,absents.code,absents.register,absents.presence,absents.description,absents.schedule_subject_id')
                ->leftJoinSub(Absent::selectRaw('*')
                        ->where(function ($query) use ($register,$id) {
                            if ($register != "") {
                                $query->where('absents.register', '=', $register);
                            }
                            $query->where('absents.schedule_subject_id', $id);
                        }),
                    'absents',
                    function ($join) {
                        $join->on('students.id', '=', 'absents.student_id');
                    }
                )
                ->where(function ($query) use ($presence) {
                    if ($presence == "alpha") {
                        $query->where('absents.presence', '=', $presence)
                            ->orWhere('absents.presence', null);
                    } else if ($presence == "sakit" || $presence == "ijin" || $presence == "masuk") {
                        $query->where('absents.presence', '=', $presence);
                    }
                })
                ->get();
        return view('admin.absents.index', compact('absents','id','gid'));
        //return $absents;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(\Gate::allows('absent_create'), 403);
        $students = Student::all();
        $schedules = Schedule::all();
        return view('admin.absents.create', compact('students', 'schedules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless(\Gate::allows('absent_create'), 403);
        $absent = Absent::create($request->all());

        return redirect()->route('admin.absents.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_unless(\Gate::allows('absent_show'), 403);
        $absent = Absent::find($id);
        $students = Student::all();
        $schedules = Schedule::all();
        return view('admin.absents.show', compact('absent', 'students', 'schedules'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(\Gate::allows('absent_edit'), 403);
        $absent = Absent::find($id);
        $students = Student::all();
        $schedules = Schedule::all();
        return view('admin.absents.edit', compact('absent', 'students', 'schedules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Absent $absent)
    {
        abort_unless(\Gate::allows('absent_edit'), 403);
        $absent->update($request->all());
        return redirect()->route('admin.absents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absent $absent)
    {
        abort_unless(\Gate::allows('absent_delete'), 403);
        $absent->delete();
        return back();
    }
}
