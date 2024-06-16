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
    private $weekId;
    private $monthId;
    private $yearId;
    private $admin;
    private $log;
    private $start;
    private $end;
    private $week;
    private $timezone;
    public function __construct()
    {
        //Dates
        $this->current = Carbon::now();
        $this->start = $this->current->startOfWeek(Carbon::SATURDAY);
        $this->end = $this->start->clone()->addDays(6);
        $this->week = $this->start->format('F jS, Y') . ' - ' . $this->end->format('F jS, Y');
        $this->weekId = $this->start->weekOfYear;
        $this->monthId = $this->current->month;
        $this->yearId = $this->current->year;
        //Admin
        $this->admin = auth()->user();
        $this->timezone = config('app.timezone');
    }
    public function data(Request $request)
    {
        $data = $request->all();
        $employee = Employee::where('user_name', $data['id'])->first();
        if ($employee == null) {
            return response()->json([
                'error' => 'true',
            ]);
        } else {
            return response()->json([
                'id' => $employee->id,
                'user_name' => $employee->user_name,
                'name' => $employee->last_name . ', ' . $employee->first_name . ' ' . $employee->middle_name,
                'role' => $employee->role,
                'job' => $employee->job,
            ]);
        }
    }
    public function image(Request $request)
    {
        $data = $request->all();
        $image = Image::where('user_name', $data['id'])->first();
        if ($image == null) {
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
        if ($employee == null) {
            return response()->json([
                'error' => true,
            ]);
        }
        $qr = QR::where('user_name', $data['id'])->latest()->first();
        if (!empty($qr)) {
            $diff = $qr->created_at->diffInMinutes(Carbon::now());
            if ($diff < 30) {
                return response()->json([
                    'timed' => true,
                ]);
            }
        }

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
            $employee->qr()->create($temp);
            return response()->json([
                'add' => true,
            ]);
        } else {
            if ($qr->created_at == $qr->updated_at) {
                if (($qr->created_at->format('Y-m-d') != Carbon::now()->format('Y-m-d'))) {
                    $employee->qr()->create($temp);
                    return response()->json([
                        'add' => true,
                    ]);
                } else {
                    $qr->touch();
                    $qr->save();
                    return response()->json([
                        'update' => true,
                    ]);
                }
            }
        }
    }
}
