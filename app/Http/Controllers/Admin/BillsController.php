<?php

namespace App\Http\Controllers\Admin;

use App\Bill;
use App\Grade;
use App\Http\Controllers\Controller;
use App\Student;
use App\StudentGradePeriode;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BillsController extends Controller
{
    public function paid($student_grade_periode_id, $periode)
    {
        abort_unless(\Gate::allows('bill_create'), 403);

        $bill = Bill::where('student_grade_periode_id', $student_grade_periode_id)
            ->where('periode', $periode)
            ->first();
        if (empty($bill)) {
            $bill['status'] = 'unpaid';
            $bill['register'] = date("Y-m-d");
            $bill['code'] = '';
            $bill['amount'] = 0;
            $bill = (object) $bill;
        }

        $student_grade_periode = StudentGradePeriode::where('id', $student_grade_periode_id)
        ->with('students')
        ->first();
        return view('admin.bills.paid', compact('student_grade_periode', 'periode', 'bill'));
    }

    public function paidProcess(Request $request)
    {
        abort_unless(\Gate::allows('bill_create'), 403);

        //get status checkbox
        $status = 'unpaid';
        if ($request->has('status')) {
            $status = 'paid';
        }
        //check if data not exist
        $bill = Bill::where('student_grade_periode_id', $request->input('student_grade_periode_id'))
            ->where('periode', $request->input('periode'))
            ->first();
        if (empty($bill)) {
            //create
            $data = ['register' => $request->input('register'), 'code' => $request->input('code'), 'periode' => $request->input('periode'), 'student_grade_periode_id' => $request->input('student_grade_periode_id'), 'amount' => $request->input('amount'), 'status' => $status];
            $bill = Bill::create($data);
        } else {
            //update
            $bill->status = $status;
            $bill->register = $request->input('register');
            $bill->code = $request->input('code');
            $bill->amount = $request->input('amount');
            $bill->save();
        }

        $student_grade_periode = StudentGradePeriode::where('id', $request->input('student_grade_periode_id'))
        ->with('grade_periode')
        ->first();

        return redirect(route("admin.bills.index") . "?period=" . $request->input('periode') . "&status-filter=" . "&grade=" . $student_grade_periode->grade_periode->grade->id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_unless(\Gate::allows('bill_access'), 403);

        if ($request->ajax()) {
            //get input
            $status = $request->status;
            $period = $request->period;
            $grade = $request->grade;
            //set query
            $qry = StudentGradePeriode::selectRaw('student_grade_periode.id,student_grade_periode.student_id,student_grade_periode.grade_periode_id,bills.code,bills.register,bills.status,bills.periode,bills.amount')
                ->join('grade_periode', 'student_grade_periode.grade_periode_id', '=', 'grade_periode.id')
                ->leftJoinSub(Bill::selectRaw('bills.*')
                        ->where(function ($query) use ($period) {
                            if ($period != "") {
                                $query->where('bills.periode', '=', $period);
                            }
                        }),
                    'bills',
                    function ($join) {
                        $join->on('student_grade_periode.id', '=', 'bills.student_grade_periode_id');
                    }
                )
                ->where(function ($query) use ($status) {
                    if ($status == "unpaid") {
                        $query->where('bills.status', '=', $status)
                            ->orWhere('bills.status', null);
                    } else if ($status == "paid") {
                        $query->where('bills.status', '=', $status);
                    }
                })
                ->where(function ($query) use ($grade) {
                    if ($grade != "") {
                        $query->where('grade_periode.grade_id', '=', $grade);
                    }
                })
                ->with('students')
                ->get();
            $table = Datatables::of($qry);

            //set def period
            $period_def = $period;

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($period_def) {
                $viewGate = 'bill_show';
                $editGate = 'bill_edit';
                $deleteGate = 'bill_delete';
                $crudRoutePart = 'bills';

                return view('partials.billsActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row',
                    'period_def'
                ));
            });
            $table->editColumn('code', function ($row) {
                return $row->code ? $row->code : "";
            });

            $table->editColumn('name', function ($row) {
                return $row->students->name ? $row->students->name : "";
            });

            $table->editColumn('periode', function ($row) {
                return $row->periode ? $row->periode : "";
            });

            $table->editColumn('register', function ($row) {
                return $row->register ? $row->register : "";
            });

            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : "";
            });

            $table->editColumn('status', function ($row) {
                return $row->status ? $row->status : "unpaid";
            });

            $table->rawColumns(['actions', 'placeholder']);

            $table->addIndexColumn();
            return $table->make(true);
        }
        //default view
        $grades = Grade::all();
        return view('admin.bills.index', compact('grades'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(\Gate::allows('bill_create'), 403);
        $students = Student::all();
        return view('admin.bills.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless(\Gate::allows('bill_create'), 403);
        $bill = Bill::create($request->all());

        return redirect()->route('admin.bills.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill)
    {
        abort_unless(\Gate::allows('bill_show'), 403);
        // $students = student::all();
        // $bill = Bill::find($id);
        return view('admin.bills.show', compact('bill'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        abort_unless(\Gate::allows('bill_edit'), 403);
        // $students = student::all();
        // $bill = Bill::find($id);
        return view('admin.bills.edit', compact('bill'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        abort_unless(\Gate::allows('bill_edit'), 403);
        $bill->update($request->all());
        return redirect()->route('admin.bills.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        abort_unless(\Gate::allows('bill_delete'), 403);
        $bill->delete();
        return back();
    }
}
