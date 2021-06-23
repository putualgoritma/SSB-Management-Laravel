<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyGradeRequest;
use App\Grade;

class GradesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(\Gate::allows('grade_access'), 403);
        $grades = Grade::all();
        return view('admin.grades.index', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(\Gate::allows('grade_create'), 403);
        return view('admin.grades.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless(\Gate::allows('grade_create'), 403);
        $grade = Grade::create($request->all());
    
        return redirect()->route('admin.grades.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_unless(\Gate::allows('grade_show'), 403);
        $grade = Grade::find($id);
        return view('admin.grades.show', compact('grade'));  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless(\Gate::allows('grade_edit'), 403);
        $grade = Grade::find($id);
        return view('admin.grades.edit', compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grade $grade)
    {
        abort_unless(\Gate::allows('grade_edit'), 403);
        $grade->update($request->all());
        return redirect()->route('admin.grades.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grade $grade)
    {
        abort_unless(\Gate::allows('grade_delete'), 403);
        $grade->delete();
        return back();
    }
    public function massDestroy(MassDestroyGradeRequest $request)
    {
        Grade::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
