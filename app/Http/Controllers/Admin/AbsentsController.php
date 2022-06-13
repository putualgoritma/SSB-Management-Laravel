<?php

namespace App\Http\Controllers\Admin;

use App\Absent;
use App\Grade;
use App\GradePeriode;
use App\Http\Controllers\Controller;
use App\Periode;
use App\Schedule;
use App\Schedule_subject;
use App\School;
use App\Semester;
use App\Session;
use App\Student;
use App\StudentGradePeriode;
use App\Subject;
use App\Teacher;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AbsentsController extends Controller
{

    public function sessionsCreate(Request $request)
    {
        abort_unless(\Gate::allows('absent_create'), 403);
        $teachers = Teacher::all();

        return view('admin.absents.sessionscreate', compact('teachers', 'request'));
    }

    public function sessionsStore(Request $request)
    {
        abort_unless(\Gate::allows('absent_create'), 403);
        //create
        $session = Session::create($request->all());
        //get input arr
        $teachers = $request->input('teachers', []);
        $positions = $request->input('positions', []);
        //attach into tbl session_teacher
        foreach ($teachers as $key => $value) {
            $session->teachers()->attach($value, ['position' => $positions[$key]]);
        }

        return redirect()->route('admin.absents.gradePeriodes', ['grade_periode_id' => $request->input('grade_periode_id')]);
    }

    public function gradePeriodes(Request $request)
    {
        abort_unless(\Gate::allows('absent_access'), 403);

        $register_sessi = $request->registersessi;
        $register = $request->register;
        if ($request->ajax()) {
            $grade_periode_id = $request->grade_periode_id;
            //set query
            $qry = Schedule::selectRaw("schedules.*,sessions.id as session_id")
                ->leftJoinSub(Session::selectRaw('*')
                        ->where(function ($query) use ($register_sessi) {
                            if ($register_sessi != "") {
                                $query->where('sessions.register', '=', $register_sessi);
                            }
                        }),
                    'sessions',
                    function ($join) {
                        $join->on('schedules.id', '=', 'sessions.schedule_id');
                    }
                )
                ->where(function ($query) use ($register) {
                    if ($register != "") {
                        $query->where('schedules.register', '=', $register);
                    }
                })
                ->with('grade_periode')
                ->with('semester')
                ->with('subject')
                ->FilterSubject()
                ->FilterSemester()
                ->FilterGradePeriode()
                ->get();
            $table = Datatables::of($qry);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($grade_periode_id) {
                $viewGate = 'absent_show';
                $editGate = 'absent_edit';
                $deleteGate = 'absent_delete';
                $crudRoutePart = 'absents';
                $grade_periode_id = $grade_periode_id;

                return view('partials.absentGradePeriodes', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row',
                    'grade_periode_id'
                ));
            });
            $table->editColumn('code', function ($row) {
                return $row->code ? $row->code : "";
            });

            $table->editColumn('periode', function ($row) {
                return $row->grade_periode->periode->name ? $row->grade_periode->periode->name : "";
            });

            $table->editColumn('semester', function ($row) {
                return $row->semester->name ? $row->semester->name : "";
            });

            $table->editColumn('grade', function ($row) {
                return $row->grade_periode->grade->name ? $row->grade_periode->grade->name : "";
            });

            $table->editColumn('register', function ($row) {
                return $row->register ? $row->register : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            $table->addIndexColumn();
            return $table->make(true);
        }
        //default view
        $schedules = Schedule::selectRaw("schedules.*,sessions.id as session_id")
            ->leftJoinSub(Session::selectRaw('*')
                    ->where(function ($query) use ($register_sessi) {
                        if ($register_sessi != "") {
                            $query->where('sessions.register', '=', $register_sessi);
                        }
                    }),
                'sessions',
                function ($join) {
                    $join->on('schedules.id', '=', 'sessions.schedule_id');
                }
            )
            ->where(function ($query) use ($register) {
                if ($register != "") {
                    $query->where('schedules.register', '=', $register);
                }
            })
            ->where('schedules.register',$request->register)
            ->with('grade_periode')
            ->with('semester')
            ->with('subject')
            ->FilterSubject()
            ->FilterSemester()
            ->FilterGradePeriode()
            ->get();
        $semesters = Semester::all();
        $gradeperiodes = GradePeriode::where('id', $request->grade_periode_id)
            ->with('grade')
            ->with('periode')
            ->first();

        return view('admin.absents.gradeperiode', compact('schedules', 'semesters', 'request', 'gradeperiodes'));
    }

    public function grades()
    {
        abort_unless(\Gate::allows('absent_access'), 403);

        //default view
        //find periode
        $periode = Periode::where('status','active')->first();
        $gradeperiodes = GradePeriode::where('periode_id', $periode->id)
            ->with('grade')
            ->with('periode')
            ->get();
        return view('admin.absents.grades', compact('gradeperiodes'));
    }

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

    public function presence($student_grade_periode_id, $register, $session_id)
    {
        abort_unless(\Gate::allows('absent_create'), 403);

        $absent = Absent::where('student_grade_periode_id', $student_grade_periode_id)
            ->where('register', $register)
            ->where('session_id', $session_id)
            ->with('sessions')
            ->with('studentgradeperiodes')
            ->first();
        if (empty($absent)) {
            $student_grade_periode = StudentGradePeriode::with('students')->where('id', $student_grade_periode_id)->first();
            $sessions = Session::with('schedules')->where('id', $session_id)->first();
            
            $absent['studentgradeperiodes']['students']['name'] = $student_grade_periode->students->name;
            $absent['sessions']['schedules']['subject']['name'] = $sessions->schedules->subject->name;
            $absent['presence'] = 'alpha';
            $absent['register'] = $register;
            $absent['session_id'] = $session_id;
            $absent['student_grade_periode_id'] = $student_grade_periode_id;
            $absent['description'] = '';
            //$absent = (object) $absent;
        }
        $absent = json_decode(json_encode($absent), false);
        //dd($absent);
        return view('admin.absents.presence', compact('absent'));
    }

    public function presenceProcess(Request $request)
    {
        abort_unless(\Gate::allows('absent_create'), 403);

        $absent = Absent::where('student_grade_periode_id', $request->input('student_grade_periode_id_hidden'))
            ->where('register', $request->input('register'))
            ->where('session_id', $request->input('session_id_hidden'))
            ->first();
        if (empty($absent)) {
            //create
            $data = ['register' => $request->input('register'), 'student_grade_periode_id' => $request->input('student_grade_periode_id_hidden'), 'session_id' => $request->input('session_id_hidden'), 'presence' => $request->input('presence'), 'description' => $request->input('description'), 'bill' => 'unpaid', 'amount' => 0];
            $absent = Absent::create($data);
        } else {
            //update
            $absent->presence = $request->input('presence');
            $absent->description = $request->input('description');
            $absent->save();
        }

        return redirect(route("admin.absents.list", [$request->input('session_id_hidden')]));
    }

    public function bill($student_grade_periode_id, $register, $session_id)
    {
        abort_unless(\Gate::allows('absent_create'), 403);

        $absent = Absent::where('student_grade_periode_id', $student_grade_periode_id)
            ->where('register', $register)
            ->where('session_id', $session_id)
            ->with('sessions')
            ->with('studentgradeperiodes')
            ->first();
        if (empty($absent)) {
            $student_grade_periode = StudentGradePeriode::with('students')->where('id', $student_grade_periode_id)->first();
            $sessions = Session::with('schedules')->where('id', $session_id)->first();
            
            $absent['studentgradeperiodes']['students']['name'] = $student_grade_periode->students->name;
            $absent['sessions']['schedules']['subject']['name'] = $sessions->schedules->subject->name;            
            $absent['register'] = $register;
            $absent['session_id'] = $session_id;
            $absent['student_grade_periode_id'] = $student_grade_periode_id;
            $absent['description'] = '';
            $absent['bill'] = 'unpaid';
            $absent['amount'] = 0;
            //$absent = (object) $absent;
        }
        $absent = json_decode(json_encode($absent), false);
        //dd($absent);
        return view('admin.absents.bill', compact('absent'));        
    }

    public function billProcess(Request $request)
    {
        abort_unless(\Gate::allows('absent_create'), 403);

        $absent = Absent::where('student_grade_periode_id', $request->input('student_grade_periode_id_hidden'))
            ->where('register', $request->input('register'))
            ->where('session_id', $request->input('session_id_hidden'))
            ->first();
        if (empty($absent)) {
            //create
            $data = ['register' => $request->input('register'), 'student_grade_periode_id' => $request->input('student_grade_periode_id_hidden'), 'session_id' => $request->input('session_id_hidden'), 'presence' => 'alpha', 'bill' => $request->input('bill'), 'amount' => $request->input('amount')];
            $absent = Absent::create($data);
        } else {
            //update
            $absent->bill = $request->input('bill');
            $absent->amount = $request->input('amount');
            $absent->save();
        }

        return redirect(route("admin.absents.list", [$request->input('session_id_hidden')]));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sid, Request $request)
    {
        abort_unless(\Gate::allows('absent_access'), 403);

        //get input
        $presence = $request->presence;
        $register = $request->register;
        $session = Session::with('schedules')->where('id', $sid)->first();

        if ($request->ajax()) {
            //set query
            $qry = StudentGradePeriode::selectRaw('student_grade_periode.id,student_grade_periode.student_id,absents.code,absents.register,absents.presence,absents.description,absents.session_id,absents.amount')
                ->leftJoinSub(Absent::selectRaw('absents.*')
                        ->where('absents.register', '=', $register),
                    'absents',
                    function ($join) {
                        $join->on('student_grade_periode.id', '=', 'absents.student_grade_periode_id');
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
                ->where('student_grade_periode.grade_periode_id', '=', $session->schedules->grade_periode_id)
                ->with('students')
                ->get();
            $table = Datatables::of($qry);

            //set def register
            $register_def = $register;
            $session_id = $session->id;

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($register_def, $session_id) {
                $viewGate = 'absent_show';
                $editGate = 'absent_edit';
                $deleteGate = 'absent_delete';
                $crudRoutePart = 'absents';
                $session_id = $session_id;

                return view('partials.absentsActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row',
                    'register_def',
                    'session_id'
                ));
            });
            $table->editColumn('code', function ($row) use ($session) {
                return $session->schedules->subject['name'] ? $session->schedules->subject['name'] : "";
            });

            $table->editColumn('name', function ($row) {
                return $row->students->name ? $row->students->name : "";
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
        $absents = StudentGradePeriode::selectRaw('student_grade_periode.id,student_grade_periode.student_id,absents.code,absents.register,absents.presence,absents.description,absents.session_id,absents.amount')
            ->leftJoinSub(Absent::selectRaw('absents.*')
                    ->where('absents.register', '=', $register),
                'absents',
                function ($join) {
                    $join->on('student_grade_periode.id', '=', 'absents.student_grade_periode_id');
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
            ->where('student_grade_periode.grade_periode_id', '=', $session->schedules->grade_periode_id)
            ->with('students')
            ->get();
        return view('admin.absents.index', compact('absents', 'sid'));
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
