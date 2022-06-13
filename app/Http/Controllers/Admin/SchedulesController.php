<?php

namespace App\Http\Controllers\Admin;

use App\Grade;
use App\GradePeriode;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Periode;
use App\Schedule;
use App\School;
use App\Semester;
use App\Subject;
use App\Teacher;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SchedulesController extends Controller
{
    public function gradePeriodes(Request $request)
    {
        abort_unless(\Gate::allows('schedule_access'), 403);

        if ($request->ajax()) {
            //set query
            $qry = Schedule::with('grade_periode')
                ->with('semester')
                ->with('subject')
                ->FilterSubject()
                ->FilterSemester()
                ->FilterGradePeriode()
                ->FilterRegister()
                ->get();
            $table = Datatables::of($qry);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'schedule_show';
                $editGate = 'schedule_edit';
                $deleteGate = 'schedule_delete';
                $crudRoutePart = 'schedules';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
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
        $schedules = Schedule::with('grade_periode')
            ->with('semester')
            ->with('subject')
            ->FilterSubject()
            ->FilterSemester()
            ->FilterGradePeriode()
            ->FilterRegister()
            ->get();
        $semesters = Semester::all();
        $gradeperiodes = GradePeriode::where('id', $request->grade_periode_id)
            ->with('grade')
            ->with('periode')
            ->first();

        return view('admin.schedules.gradeperiode', compact('schedules', 'semesters', 'request', 'gradeperiodes'));
    }

    public function grades()
    {
        abort_unless(\Gate::allows('schedule_access'), 403);

        //default view
        //find periode
        $periode = Periode::where('status','active')->first();
        $gradeperiodes = GradePeriode::where('periode_id', $periode->id)
            ->with('grade')
            ->with('periode')
            ->get();
        return view('admin.schedules.grades', compact('gradeperiodes'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_unless(\Gate::allows('schedule_access'), 403);

        if ($request->ajax()) {
            //set query
            $qry = Schedule::with('periode')
                ->with('semester')
                ->with('grade')
                ->FilterPeriode()
                ->FilterSemester()
                ->FilterGrade()
                ->FilterRegister()
                ->get();
            $table = Datatables::of($qry);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'schedule_show';
                $editGate = 'schedule_edit';
                $deleteGate = 'schedule_delete';
                $crudRoutePart = 'schedules';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });
            $table->editColumn('code', function ($row) {
                return $row->code ? $row->code : "";
            });

            $table->editColumn('periode', function ($row) {
                return $row->periode->name ? $row->periode->name : "";
            });

            $table->editColumn('semester', function ($row) {
                return $row->semester->name ? $row->semester->name : "";
            });

            $table->editColumn('grade', function ($row) {
                return $row->grade->name ? $row->grade->name : "";
            });

            $table->editColumn('register', function ($row) {
                return $row->register ? $row->register : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            $table->addIndexColumn();
            return $table->make(true);
        }
        //default view
        $schedules = Schedule::with('periode')
            ->with('semester')
            ->with('grade')
            ->get();
        $periodes = Periode::all();
        $semesters = Semester::all();
        $grades = Grade::all();

        return view('admin.schedules.index', compact('schedules', 'periodes', 'semesters', 'grades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_unless(\Gate::allows('schedule_create'), 403);
        $semesters = Semester::all();
        $teachers = Teacher::all();
        $subjects = Subject::all();
        return view('admin.schedules.create', compact('semesters', 'teachers', 'subjects', 'request'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreScheduleRequest $request)
    {
        abort_unless(\Gate::allows('schedule_create'), 403);

        //create
        $schedule = Schedule::create($request->all());
        //get input arr
        $teachers = $request->input('teachers', []);
        $positions = $request->input('positions', []);
        //attach into tbl schedule_teacher
        foreach ($teachers as $key => $value) {
            $schedule->teachers()->attach($value, ['position' => $positions[$key]]);
        }

        return redirect()->route('admin.schedules.gradePeriodes', ['grade_periode_id' => $request->input('grade_periode_id')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_unless(\Gate::allows('schedule_show'), 403);
        $schedule = Schedule::find($id);
        $subjects = Subject::all();
        $grades = Grade::all();
        $teachers = Teacher::all();
        return view('admin.schedules.show', compact('schedule', 'subjects', 'grades', 'teachers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(\Gate::allows('schedule_edit'), 403);
        $schedule = Schedule::find($id);
        $semesters = Semester::all();
        $teachers = Teacher::all();
        $subjects = Subject::all();
        return view('admin.schedules.edit', compact('schedule', 'subjects', 'teachers', 'semesters'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        abort_unless(\Gate::allows('schedule_edit'), 403);
        $schedule->update($request->all());
        //get input arr
        $teachers = $request->input('teachers', []);
        $positions = $request->input('positions', []);
        //attach into tbl schedule_teacher
        $schedule->teachers()->detach();
        foreach ($teachers as $key => $value) {
            $schedule->teachers()->attach($value, ['position' => $positions[$key]]);
        }
        return redirect()->route('admin.schedules.gradePeriodes', ['grade_periode_id' => $request->input('grade_periode_id')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        abort_unless(\Gate::allows('schedule_delete'), 403);
        $schedule->delete();
        return back();
    }

}
