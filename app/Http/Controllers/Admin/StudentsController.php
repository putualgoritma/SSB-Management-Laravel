<?php

namespace App\Http\Controllers\Admin;

use App\Grade;
use App\Http\Controllers\Controller;
use App\Student;
use App\Team;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_unless(\Gate::allows('student_access'), 403);

        if ($request->ajax()) {
            //set query
            $qry = Student::FilterGrade()
                ->with('grade')
                ->get();
            $table = Datatables::of($qry);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'student_show';
                $editGate = 'student_edit';
                $deleteGate = 'student_delete';
                $crudRoutePart = 'students';

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

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });

            $table->editColumn('place', function ($row) {
                return $row->place ? $row->place : "";
            });

            $table->editColumn('date', function ($row) {
                return $row->date ? $row->date : "";
            });

            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : "";
            });

            $table->editColumn('gender', function ($row) {
                return $row->gender ? $row->gender : "";
            });

            $table->editColumn('school', function ($row) {
                return $row->school ? $row->school : "";
            });

            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });

            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : "";
            });

            $table->editColumn('grade', function ($row) {
                return $row->grade->name ? $row->grade->name : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            $table->addIndexColumn();
            return $table->make(true);
        }
        //default view
        $grades = Grade::all();
        return view('admin.students.index', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(\Gate::allows('student_create'), 403);
        $teams = Team::all();
        $grades = Grade::all();
        return view('admin.students.create', compact('grades', 'teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless(\Gate::allows('student_create'), 403);
        $student = Student::create($request->all());

        return redirect()->route('admin.students.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_unless(\Gate::allows('student_show'), 403);
        $teams = Team::all();
        $grade = Grade::all();
        $student = Student::find($id);
        return view('admin.students.show', compact('student', 'grade', 'teams'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(\Gate::allows('student_edit'), 403);
        $teams = Team::all();
        $grades = Grade::all();
        $student = Student::find($id);
        return view('admin.students.edit', compact('grades', 'student', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        abort_unless(\Gate::allows('student_edit'), 403);
        $student->update($request->all());
        return redirect()->route('admin.students.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        abort_unless(\Gate::allows('student_delete'), 403);
        $student->delete();
        return back();
    }
}
