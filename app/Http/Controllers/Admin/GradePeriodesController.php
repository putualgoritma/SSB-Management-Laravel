<?php

namespace App\Http\Controllers\Admin;

use App\Grade;
use App\GradePeriode;
use App\Http\Controllers\Controller;
use App\Periode;
use App\Student;
use App\StudentGradePeriode;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GradePeriodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_unless(\Gate::allows('gradeperiode_access'), 403);

        //default view
        $gradeperiodes = GradePeriode::FilterPeriode()
            ->with('periode')
            ->get();
        $periode = Periode::where('id', $request->periode)->first();
        return view('admin.gradeperiodes.index', compact('gradeperiodes', 'periode'));
    }

    public function indexAjax(Request $request)
    {
        abort_unless(\Gate::allows('gradeperiode_access'), 403);

        if ($request->ajax()) {
            //set query
            $qry = GradePeriode::FilterPeriode()
                ->with('periode')
                ->get();
            $table = Datatables::of($qry);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'gradeperiode_show';
                $editGate = 'gradeperiode_edit';
                $deleteGate = 'gradeperiode_delete';
                $crudRoutePart = 'gradeperiodes';

                return view('partials.gradePeriodesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });
            $table->editColumn('name', function ($row) {
                return $row->grade->name ? $row->grade->name : "";
            });

            $table->editColumn('periode_name', function ($row) {
                return $row->periode->name ? $row->periode->name : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            $table->addIndexColumn();
            return $table->make(true);
        }
        //default view
        $periodes = Periode::all();
        return view('admin.gradeperiodes.index', compact('periodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_unless(\Gate::allows('gradeperiode_create'), 403);
        $periodes = Periode::all();
        $grades = Grade::all();
        $periode = Periode::where('id', $request->periode)->first();
        return view('admin.gradeperiodes.create', compact('grades', 'periodes', 'periode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless(\Gate::allows('gradeperiode_create'), 403);
        //check if already exist
        //return $request;
        $gradeperiode_exist = GradePeriode::where('periode_id', $request->periode_id)->where('grade_id', $request->grade_id)->get();
        if (count($gradeperiode_exist) == 0) {
            $gradeperiode = GradePeriode::create($request->all());
        }
        if ($request->periode > 0) {
            return redirect()->route('admin.gradeperiodes.index', ['periode' => $request->periode]);
        } else {
            return redirect()->route('admin.gradeperiodes.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_unless(\Gate::allows('gradeperiode_show'), 403);
        $gradeperiode = GradePeriode::with('grade')
            ->with('periode')
            ->get()
            ->find($id);
        return view('admin.gradeperiodes.show', compact('gradeperiode'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(\Gate::allows('gradeperiode_edit'), 403);
        $periodes = Periode::all();
        $grades = Grade::all();
        $gradeperiode = GradePeriode::find($id);
        return view('admin.gradeperiodes.edit', compact('grades', 'periodes', 'gradeperiode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GradePeriode $gradeperiode)
    {
        abort_unless(\Gate::allows('gradeperiode_edit'), 403);
        $gradeperiode->update($request->all());
        return redirect()->route('admin.gradeperiodes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(GradePeriode $gradeperiode)
    {
        abort_unless(\Gate::allows('gradeperiode_delete'), 403);
        $gradeperiode->delete();
        return back();
    }

    public function studentGrade($id)
    {
        abort_unless(\Gate::allows('gradeperiode_access'), 403);

        //default view
        $studentgradeperiodes = StudentGradePeriode::select('*')
            ->where('grade_periode_id', $id)
            ->with('students')
            ->get();
        $gradeperiode = GradePeriode::with('grade')
            ->with('periode')
            ->get()
            ->find($id);
        //return $studentgradeperiode;
        return view('admin.gradeperiodes.studentgrade', compact('studentgradeperiodes', 'gradeperiode'));
    }

    public function students($id, Request $request)
    {
        abort_unless(\Gate::allows('gradeperiode_access'), 403);

        $students = Student::FilterGrade()
            ->with('grade')
            ->get();
        //default view
        $gradeperiode = GradePeriode::with('grade')
            ->with('periode')
            ->get()
            ->find($id);
        return view('admin.gradeperiodes.students', compact('students', 'gradeperiode'));
    }

    public function studentAdd($gid, $sid)
    {
        abort_unless(\Gate::allows('gradeperiode_create'), 403);
        //check if data not exist
        $studentgrade = StudentGradePeriode::where('student_id', $sid)
            ->where('grade_periode_id', $gid)
            ->first();
        if (empty($studentgrade)) {
            $data = ['grade_periode_id' => $gid, 'student_id' => $sid];
            $gradeperiode = StudentGradePeriode::create($data);
        }
        $studentgradeperiodes = StudentGradePeriode::select('*')
            ->where('grade_periode_id', $gid)
            ->with('students')
            ->get();
        $gradeperiode = GradePeriode::with('grade')
            ->with('periode')
            ->get()
            ->find($gid);
        //return $studentgradeperiode;
        return view('admin.gradeperiodes.studentgrade', compact('studentgradeperiodes', 'gradeperiode'));
    }

    public function studentRemove(Request $request)
    {
        abort_unless(\Gate::allows('gradeperiode_delete'), 403);
        $studentgradeperiode = StudentGradePeriode::find($request->_id);
        // return $studentgradeperiode;
        $studentgradeperiode->delete();
        return back();
    }
}
