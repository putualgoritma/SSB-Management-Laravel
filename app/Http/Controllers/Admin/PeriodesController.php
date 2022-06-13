<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePeriodeRequest;
use App\Http\Requests\UpdatePeriodeRequest;
use App\Periode;
use Illuminate\Http\Request;

class PeriodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(\Gate::allows('periode_access'), 403);
        $periodes = Periode::all();
        return view('admin.periodes.index', compact('periodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(\Gate::allows('periode_create'), 403);
        return view('admin.periodes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePeriodeRequest $request)
    {
        abort_unless(\Gate::allows('periode_create'), 403);
        $periode = Periode::create($request->all());

        return redirect()->route('admin.periodes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Periode $periode)
    {
        abort_unless(\Gate::allows('periode_show'), 403);
        return view('admin.periodes.show', compact('periode'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Periode $periode)
    {
        abort_unless(\Gate::allows('periode_edit'), 403);
        return view('admin.periodes.edit', compact('periode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePeriodeRequest $request, Periode $periode)
    {
        abort_unless(\Gate::allows('periode_edit'), 403);        
        $periode->update($request->all());
        if ($request->status == 'active') {
            //Periode::query()->update(['status' => 'close']);
            Periode::where('id','!=', $periode->id)->update(['status' => 'close']);
        }
        return redirect()->route('admin.periodes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Periode $periode)
    {
        abort_unless(\Gate::allows('periode_delete'), 403);
        $periode->delete();
        return back();
    }
}
