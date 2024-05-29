<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Image;
use App\Models\Payroll;
use App\Models\QR;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QRController extends Controller
{
    private $current;
    private $firstDay;
    private $lastDay;
    private $week;
    private $weekId;
    private $monthId;
    private $yearId;
    private $timezone;
    public function __construct()
    {
        //Dates
        $this->current = Carbon::today();
        $firstDay = $this->current->copy()->startOfWeek();
        $this->firstDay = $firstDay->format('F j, Y');
        $this->lastDay = $this->current->format('F j, Y');
        $this->week = $this->firstDay . " - " . $this->lastDay;
        $this->weekId = $this->current->week();
        $this->monthId = $this->current->month;
        $this->yearId = $this->current->year;
        $this->timezone = config('app.timezone');
    }
    public function data(Request $request)
    {
        $data = $request->all();
        $employee = Employee::where('user_name', $data['id'])->first();
        if (is_null($employee)) {
            return response()->json([
                'error' => 'true',
            ]);
        } else {
            return response()->json([
                'id' => $employee->id,
                'user_name' => $employee->user_name,
                'name' => Payroll::where('user_name', $data['id'])->first()->name,
                'role' => $employee->role,
                'job' => $employee->job,
            ]);
        }
    }
    public function image(Request $request)
    {
        $data = $request->all();
        $image = Image::where('user_name', $data['id'])->first();
        if (is_null($image)) {
            return response()->json([
                'error' => 'true',
            ]);
        } else {
            $data = $image->image_data;
            $filename = $image->image_name;
            return response($data)
                ->header('Content-Type', 'application/octet-stream')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        }
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $employee = Employee::where('user_name', $data['id'])->first();
        if (empty($employee)) {
            return response()->json([
                'error' => true,
            ]);
        }
        $qr = QR::where('user_name', $data['id'])->latest()->first();
        $payroll = Payroll::where('user_name', $data['id'])->where('week_id', $this->weekId)->first();

        $temp = [];
        $temp['week_id'] = $this->weekId;
        $temp['user_name'] = $employee->user_name;
        $temp['name'] = $employee->last_name . ', ' . $employee->first_name . ' ' . $employee->middle_name;
        $temp['role'] = $employee->role;
        $temp['job'] = $employee->job;
        $temp['timezone'] = $this->timezone;
        $temp['ip'] = $request->ip();
        $temp['geo'] = $data['latitude'] . ', ' . $data['longitude'];
        if (empty($qr) || $qr->created_at != $qr->updated_at) {
            if (empty($payroll)) {
                $payroll = Payroll::where('user_name', $data['id'])->latest()->first();
                $temp1 = [];
                $temp1['pay_id'] = FunctionController::payId();
                $temp1['user_name'] = $payroll->user_name;
                $temp1['week_id'] = $this->weekId;
                $temp1['month_id'] = $this->monthId;
                $temp1['year_id'] = $this->yearId;
                $temp1['name'] = $payroll->name;
                $temp1['job'] = $payroll->job;
                $temp1['rate'] = $payroll->rate;
                $temp1['rph'] = $payroll->rph;
                $employee->payroll()->create($temp1);
                $employee->qr()->create($temp);
                return response()->json([
                    'add' => true,
                ]);
            } else {
                $employee->qr()->create($temp);
                return response()->json([
                    'add' => true,
                ]);
            }
        } else {
            if ($qr->created_at == $qr->updated_at) {
                $time = Carbon::today()->setTimeFromTimeString($qr->created_at);
                $lateLimit = Carbon::today()->setTimeFromTimeString('08:16:00');
                $overtimeStart = Carbon::today()->setTimeFromTimeString('18:00:00');
                $days = $time->diffInHours(Carbon::now());
                $days = $days / 8;
                $late = 0;
                $hrs = 0;
                if ($time >= $lateLimit) {
                    $late = round($lateLimit->diffInHours($time) + 0.5, 2);
                }
                if ($time >= $overtimeStart) {
                    $hrs = round($overtimeStart->diffInHours($time), 2);
                }
                $temp1 = [];
                $temp1['days'] = $payroll->days + $days;
                $temp1['late'] = $payroll->late + $late;
                if ($temp1['late'] != 0) {
                    $temp1['salary'] = round($payroll->rate * $temp1['days'] - $payroll->rate / (8 * $temp1['late']), 2);
                } else {
                    $temp1['salary'] = round($payroll->rate * $temp1['days'], 2);
                }
                $temp1['hrs'] = $payroll->hrs + $hrs;
                $temp1['otpay'] = $payroll->rph * $temp1['hrs'];
                $temp1['gross'] = $temp1['salary'] + $temp1['otpay'] + $payroll->holiday;
                $temp1['net'] = $temp1['gross'] - $payroll->deduction;
                $payroll->update($temp1);
                $qr->touch();
                $qr->save();
                return response()->json([
                    'update' => true,
                ]);
            }
        }
    }
}
