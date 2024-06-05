<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Image;
use App\Models\Log;
use App\Models\Payroll;
use App\Models\QR;
use App\Models\Payslip;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ViewController extends Controller
{
    private $current;
    private $firstDay;
    private $lastDay;
    private $weekId;
    private $monthId;
    private $yearId;
    private $admin;
    private $log;

    public function __construct()
    {
        //Dates
        $this->current = Carbon::today();
        $firstDay = $this->current->copy()->startOfWeek();
        $this->firstDay = $firstDay->format('F j, Y');
        $this->lastDay = $this->current->format('F j, Y');
        $this->weekId = $this->current->week();
        $this->monthId = $this->current->month;
        $this->yearId = $this->current->year;
        //Admin
        $this->admin = auth()->user();
        //Log
        if ($this->admin != null) {
            $this->log = Log::where('user_id', $this->admin->id)
                ->whereDate('created_at', $this->current)
                ->get();
        }
    }

    public function index(): View
    {
        Cache::forget('data');
        $temp = Employee::all();
        foreach ($temp as $t) {
            $qr = QR::where('user_name', $t->user_name)->latest()->first();
            if (empty($qr)) {
                continue;
            } else {
                $time = $qr->updated_at;
                $diff = $time->diffInDays(Carbon::today());
                if ($diff >= 30) {
                    $t->eStatus = 'INACTIVE';
                    $t->save();
                }
            }
        }
        return view('auth.login');
    }
    public function adminDash(): View
    {
        Cache::forget('data');
        $data = [];
        $data['emp'] = Employee::count();
        $temp = Payroll::where('month_id', $this->monthId)->get();
        $data['month'] = 0;
        foreach ($temp as $t) {
            $data['month'] = $data['month'] + $t->net;
        }
        $temp = Payroll::where('year_Id', $this->yearId)->get();
        $data['year'] = 0;
        foreach ($temp as $t) {
            $data['year'] = $data['year'] + $t->net;
        }
        $data['status'] = Employee::where('eStatus', 'INACTIVE')->count();
        $data['weekId'] = $this->weekId;
        $data['mNames'] = [
            "JANUARY",
            "FEBRUARY",
            "MARCH",
            "APRIL",
            "MAY",
            "JUNE",
            "JULY",
            "AUGUST",
            "SEPTEMBER",
            "OCTOBER",
            "NOVEMBER",
            "DECEMBER"
        ];
        $year = date('Y');
        $data['y'] = range(2010, $year);
        return view('admin.dashboard', [
            'data' => $data,
            'log' => $this->log,
        ]);
    }
    public function userDash(): View
    {
        Cache::forget('data');
        $data = [];
        $temp = Payroll::where('user_name', auth()->user()->user_name)->where('month_id', $this->monthId)->get();
        $data['month'] = 0;
        foreach ($temp as $t) {
            $data['month'] = $data['month'] + $t->net;
        }
        $temp = Payroll::where('user_name', auth()->user()->user_name)->where('year_Id', $this->yearId)->get();
        $data['year'] = 0;
        foreach ($temp as $t) {
            $data['year'] = $data['year'] + $t->net;
        }
        $data['weekId'] = $this->weekId;
        $data['mNames'] = [
            "JANUARY",
            "FEBRUARY",
            "MARCH",
            "APRIL",
            "MAY",
            "JUNE",
            "JULY",
            "AUGUST",
            "SEPTEMBER",
            "OCTOBER",
            "NOVEMBER",
            "DECEMBER"
        ];
        $year = date('Y');
        $data['y'] = range(2010, $year);
        return view('user.dashboard', [
            'data' => $data,
        ]);
    }
    public function qrScanner(): View
    {
        Cache::forget('data');
        return view('qr.scanner');
    }
    public function addEmp(): View
    {
        Cache::forget('data');
        return view('admin.addEmp', [
            'log' => $this->log,
        ]);
    }
    public function editEmp($id): View
    {
        Cache::forget('data');
        $employee = Employee::find($id);
        $image = Image::where('employee_id', $id)->first();
        return view('admin.editEmp', [
            'employee' => $employee,
            'image' => $image,
            'log' => $this->log,
        ]);
    }
    public function editPay($id): View
    {
        Cache::forget('data');
        $payroll = Payslip::find($id);
        return view('admin.editPay', [
            'payroll' => $payroll,
            'log' => $this->log,
        ]);
    }
    public function empView(): View
    {
        Cache::forget('data');
        $data = Employee::paginate();
        return view('admin.empView', [
            'data' => $data,
            'log' => $this->log,
        ]);
    }
    public function payView(Request $request): View
    {
        Cache::forget('data');
        $data = Payroll::paginate();
        return view('admin.payView', [
            'data' => $data,
            'log' => $this->log,
        ]);
    }
    public function payroll(Request $request): View
    {
        $data = null;
        return view('admin.generate', [
            'data' => $data,
        ]);
    }

    public function qrView(Request $request): View
    {
        Cache::forget('data');
        if ($request->input('date')) {
            $data = $request->input('date');
            $qr = QR::whereDate('created_at', $data)->paginate();
            return view('admin.qrView', [
                'data' => $qr,
                'log' => $this->log,
            ]);
        } else if ($request->input('range')) {
            $data = $request->input('range');
            $data = json_decode($data, true);
            $qr = QR::whereBetween('created_at', [$data[0], $data[1]])->paginate();
            return view('admin.qrView', [
                'data' => $qr,
                'log' => $this->log,
            ]);
        } else {
            $data = QR::paginate();
            return view('admin.qrView', [
                'data' => $data,
                'log' => $this->log,
            ]);
        }
    }
    public function empQr(Request $request): View
    {
        Cache::forget('data');
        if ($request->input('date')) {
            $data = $request->input('date');
            $qr = QR::where('user_name', $this->admin->user_name)->whereDate('created_at', $data)->paginate();
            return view('user.qrView', [
                'data' => $qr,
                'log' => $this->log,
            ]);
        } else if ($request->input('range')) {
            $data = $request->input('range');
            $data = json_decode($data, true);
            $qr = QR::where('user_name', $this->admin->user_name)->whereBetween('created_at', [$data[0], $data[1]])->paginate();
            return view('user.qrView', [
                'data' => $qr,
                'log' => $this->log,
            ]);
        } else {
            $data = QR::where('user_name', $this->admin->user_name)->paginate();
            return view('user.qrView', [
                'data' => $data,
                'log' => $this->log,
            ]);
        }
    }
    public function empPay(): View
    {
        Cache::forget('data');
        $payroll = Payroll::where('user_name', auth()->user()->user_name)->paginate();
        return view('user.payroll', [
            'data' => $payroll,
        ]);
    }
    public function logs(Request $request): View
    {
        Cache::forget('data');
        if ($request->input('date')) {
            $data = $request->input('date');
            $qr = Log::whereDate('created_at', $data)->paginate();
            return view('admin.logs', [
                'data' => $qr,
                'log' => $this->log,
            ]);
        } else if ($request->input('range')) {
            $data = $request->input('range');
            $data = json_decode($data, true);
            $qr = Log::whereBetween('created_at', [$data[0], $data[1]])->paginate();
            return view('uadmin.logs', [
                'data' => $qr,
                'log' => $this->log,
            ]);
        } else {
            $data = Log::paginate();
            return view('admin.logs', [
                'data' => $data,
                'log' => $this->log,
            ]);
        }
    }
    
    public function payslip(Request $request): View
    {
        Cache::forget('data');
        $today = Carbon::now();
        $weekStart = $today->startOfWeek(Carbon::SATURDAY);
        $weeks = range(1, $weekStart->weekOfYear);
        if ($request->input('data')) {
            $data = $request->input('data');
            $data = json_decode($data, true);
            $payslip = Payslip::where('week_id', $data)->paginate();
            return view('admin.payslip',[
                'weeks'=>$weeks,
                'data'=>$payslip,
                'week'=>$data,
            ]);
        }else{
            $payslip = Payslip::where('week_id', $weekStart->weekOfYear)->paginate();
            return view('admin.payslip',[
                'weeks'=>$weeks,
                'data'=>$payslip,
            ]);
        }

        
    }
}
