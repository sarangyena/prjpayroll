<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Log;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;



class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    private $current;
    private $admin;

    public function __construct()
    {
        //Dates
        $this->current = Carbon::today()->toDateString();
        //Admin
        $this->admin = auth()->user();
    }
    public function index(): View
    {   
        $log = Log::where('user_id', $this->admin->id)
            ->whereDate('created_at', $this->current)
            ->get();
        
        if(Payroll::exists()){
            $payroll = Payroll::with('user')->first()->paginate(5);
            return view('admin.pay', [
                'payroll' => Payroll::with('user')->first()->paginate(5),
                'log' => $log,
            ]);
        }else{
            
        }
        $pay = Payroll::paginate(5);
        $emp = Employee::paginate(5);
        if($pay == null) {
            return view('admin.pay', [
                'payroll' => Payroll::with('user')->first()->paginate(5),
                'employees' => Employee::with('user')->first()->paginate(5),
                'log' => $log,
            ]);
        }else{
            return view('admin.pay', [
                'payroll' => $pay,
                'employees' => $emp,
                'log' => $log,
            ]);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payroll $payroll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $payroll = Payroll::find($id);
        Gate::authorize('update', $payroll);
        return view('admin.editPayroll', [
            'payroll' => $payroll,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payroll $payroll)
    {
        //
    }
}
