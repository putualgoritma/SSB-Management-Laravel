<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\MassDestroySemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;
use App\Semester;

class SemestersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(\Gate::allows('semester_access'), 403);
        $semesters = Semester::all();
        return view('admin.semesters.index', compact('semesters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(\Gate::allows('semester_create'), 403);
        return view('admin.semesters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSemesterRequest $request)
    {
        abort_unless(\Gate::allows('semester_create'), 403);
        $semester = Semester::create($request->all());
    
        return redirect()->route('admin.semesters.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Semester $semester)
    {
        abort_unless(\Gate::allows('semester_show'), 403);
        return view('admin.semesters.show', compact('semester')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Semester $semester)
    {
        abort_unless(\Gate::allows('semester_edit'), 403);
        return view('admin.semesters.edit', compact('semester')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSemesterRequest $request, Semester $semester)
    {
        abort_unless(\Gate::allows('semester_edit'), 403);
        $semester->update($request->all());
        if ($request->status == 'active') {
            Semester::where('id','!=', $semester->id)->update(['status' => 'close']);
        }
        return redirect()->route('admin.semesters.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Semester $semester)
    {
        abort_unless(\Gate::allows('semester_delete'), 403);
        $semester->delete();
        return back();
    }
    public function massDestroy(MassDestroySemesterRequest $request)
    {
        Semester::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
