<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Image;
use App\Models\Log;
use App\Models\Payroll;
use App\Models\Payslip;
use App\Models\QR;
use App\Models\Temp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;
use Illuminate\Support\Facades\Cache;

class FunctionController extends Controller
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
        //Log
        if ($this->admin->user_name == 'ADMIN') {
            $this->log = Log::where('user_id', $this->admin->id)
                ->whereDate('created_at', $this->current)
                ->get();
        }
    }
    public function username(Request $request)
    {
        $data = $request->input('role');
        $count = Employee::where('role', $data)
            ->orderBy('id', 'desc')
            ->value('id') + 1;
        $role = $data[0];
        $length = strlen($count);
        switch ($length) {
            case 1:
                return response()->json($role . '-00' . $count);
            case 2:
                return response()->json($role . '-0' . $count);
            default:
                return response()->json($role . '-' . $count);
        }
    }
    public static function username1(Request $request)
    {
        $data = $request->input('role');
        $count = Employee::where('role', $data)
            ->orderBy('id', 'desc')
            ->value('id') + 1;
        $role = $data[0];
        $length = strlen($count);
        switch ($length) {
            case 1:
                return response()->json($role . '-00' . $count);
            case 2:
                return response()->json($role . '-0' . $count);
            default:
                return response()->json($role . '-' . $count);
        }
    }
    public static function username2($role)
    {
        $count = Employee::where('role', $role)
            ->orderBy('id', 'desc')
            ->value('id') + 1;
        $role = $role[0];
        $length = strlen($count);
        switch ($length) {
            case 1:
                return response()->json($role . '-00' . $count);
            case 2:
                return response()->json($role . '-0' . $count);
            default:
                return response()->json($role . '-' . $count);
        }
    }
    public static function payId()
    {
        $count = Payslip::count() + 1;
        $length = strlen($count);
        switch ($length) {
            case 1:
                return 'PAY-00' . $count;
            case 2:
                return 'PAY-0' . $count;
            default:
                return 'PAY-' . $count;
        }
    }
    public static function convert_number_to_words($number)
    {

        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'fourty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            1000000             => 'million',
            1000000000          => 'billion',
            1000000000000       => 'trillion',
            1000000000000000    => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . Self::convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . Self::convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = Self::convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= Self::convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }
    public function qrSession(Request $request)
    {
        if ($request->input('error')) {
            $data = $request->input('error');
            $data = json_decode($data, true);
            session([
                'danger' => $data['message'],
            ]);

            return redirect()->route('qr-scanner');
        } else {
            $data = $request->input('object');
            $data = json_decode($data, true);
            $data['image_data'] = Image::where('user_name', $data['user_name'])->first()->image_data;
            session([
                'success' => $data['message'],
                'data1' => $data,
            ]);
            return redirect()->route('qr-scanner');
        }
    }
    public function QR($id)
    {
        $image = Image::findOrFail($id);
        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $image->image_name . '"',
        ];
        return response()->stream(function () use ($image) {
            echo $image->qr_data;
        }, 200, $headers);
    }
    public function month(Request $request)
    {
        $month = Carbon::parse("1 $request->month");
        $payroll = Payroll::where('month_id', $month->month)->get();
        if (count($payroll) >= 1) {
            $net = 0;
            foreach ($payroll as $p) {
                $net += $p->net;
            }
            return $net;
        } else {
            return $net = 0;
        }
    }
    public function year(Request $request)
    {
        $year = (int)$request->year;
        $payroll = Payroll::where('year_id', $year)->get();
        if (count($payroll) >= 1) {
            $net = 0;
            foreach ($payroll as $p) {
                $net += $p->net;
            }
            return $net;
        } else {
            return $net = 0;
        }
    }
    public function empMonth(Request $request)
    {
        $month = Carbon::parse("1 $request->month");
        $payroll = Payroll::where('user_name', auth()->user()->user_name)->where('month_id', $month->month)->get();
        if (count($payroll) >= 1) {
            $net = 0;
            foreach ($payroll as $p) {
                $net += $p->net;
            }
            return $net;
        } else {
            return $net = 0;
        }
    }
    public function empYear(Request $request)
    {
        $year = (int)$request->year;
        $payroll = Payroll::where('user_name', auth()->user()->user_name)->where('year_id', $year)->get();
        if (count($payroll) >= 1) {
            $net = 0;
            foreach ($payroll as $p) {
                $net += $p->net;
            }
            return $net;
        } else {
            return $net = 0;
        }
    }

    public function payslip(Request $request)
    {
        try {
            $week = $request->input('week');
            $fYear = Carbon::createFromDate($this->yearId, 1, 1);
            $wdOff = ($fYear->dayOfWeek - Carbon::SATURDAY) % 7;
            $wkOff = ($week - 1) * 7 - $wdOff;
            $start = $fYear->addDays($wkOff);
            $end = $start->copy()->addDays(6);
            $emp = Employee::all();
            foreach ($emp as $e) {
                if($e->role == 'EMPLOYEE'){
                    $weekday_offset = ($this->current->dayOfWeek - Carbon::SATURDAY) % 7;
                    $start_date = $this->current->subDays($weekday_offset);
                    $end_date = $start_date->copy()->addDays(14);
                    $qr = QR::where('user_name', $e->user_name)->whereBetween('created_at', [$start_date, $end_date])->get();
                }else if($e->role == 'ON-CALL'){
                    $qr = QR::where('user_name', $e->user_name)->whereBetween('created_at', [$start, $end])->get();
                }
                if (!$qr->isEmpty()) {
                    $data = [];
                    $data['days'] = 0;
                    $data['late'] = 0;
                    $data['ot'] = 0;
                    foreach ($qr as $q) {
                        $diff = $q->created_at->diffInHours($q->updated_at);
                        $diff > 8 ? $data['days'] += 1 : $data['days'] += $diff / 8;
                        if ($q->created_at >= Carbon::parse($q->created_at->format('Y-m-d') . '08:16:00') && $q->created_at < Carbon::parse($q->created_at->format('Y-m-d') . '12:00:00')) {
                            if ($q->created_at >= Carbon::parse($q->created_at->format('Y-m-d') . '08:31:00')) {
                                $data['late'] += Carbon::parse($q->created_at->format('Y-m-d') . '08:31:00')->diffInMinutes($q->created_at) + 30;
                                $data['late'] >= 60 ? $data['late'] /= 60 : $data['late'];
                            } else {
                                $data['late'] += 30;
                                $data['late'] >= 60 ? $data['late'] /= 60 : $data['late'];
                            }
                        }
                        if ($q->created_at >= Carbon::parse($q->created_at->format('Y-m-d') . '17:00:00')) {
                            $data['ot'] += Carbon::parse($q->created_at->format('Y-m-d') . '18:00:00')->diffInHours($q->updated_at);
                        }
                    }
                    $payslip = Payslip::where('user_name', $e->user_name)->where('week_id', $week)->first();
                    if ($payslip == null) {
                        $data['pay_id'] = FunctionController::payId();
                    }
                    $data['hired'] = $e->created_at;
                    $data['user_name'] = $e->user_name;
                    $data['week_id'] = $week;
                    $data['month_id'] = $this->monthId;
                    $data['year_id'] = $this->yearId;
                    if ($e->role == 'EMPLOYEE') {
                        $data['pay_period'] = $start_date->format('F jS, Y') . ' - ' . $end_date->format('F jS, Y');
                    } else if ($e->role == 'ON-CALL') {
                        $data['pay_period'] = $this->week;
                    }
                    $data['name'] = $e->last_name . ', ' . $e->first_name . ' ' . $e->middle_name;
                    $data['job'] = $e->job;
                    $data['rate'] = 430;
                    $data['salary'] = $data['rate'] * $data['days'] - ($data['rate'] / 8 * $data['late']);
                    $data['rph'] = ($data['rate'] / 8) + ($data['rate'] / 8) * 0.2;
                    $data['otpay'] = $data['rph'] * $data['ot'];
                    $data['gross'] = $data['salary'] + $data['otpay'];
                    $data['net'] = $data['gross'];
                    if ($payslip != null) {
                        $payslip->update($data);
                    } else {
                        $e->payslip()->create($data);
                    }
                }
            }
            $payslip = Payslip::where('week_id', $week)->get();
            if ($payslip->isEmpty()) {
                return redirect()->back()->with('danger', 'No data to generate.');
            } else {
                return redirect()->back()->with('success', 'Successfully generated payslips.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function payroll(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        try {
            $emp = Employee::all();
            $data = [];
            foreach ($emp as $e) {
                $qr = QR::where('user_name', $e->user_name)->whereBetween('created_at', [$start, $end])->get();
                if (!$qr->isEmpty()) {
                    $data[$e->user_name] = [];
                    $data[$e->user_name]['days'] = 0;
                    $data[$e->user_name]['late'] = 0;
                    $data[$e->user_name]['ot'] = 0;
                    foreach ($qr as $q) {
                        $diff = $q->created_at->diffInHours($q->updated_at);
                        $diff > 8 ? $data[$e->user_name]['days'] += 1 : $data[$e->user_name]['days'] += $diff / 8;
                        if ($q->created_at >= Carbon::parse($q->created_at->format('Y-m-d') . '08:16:00') && $q->created_at < Carbon::parse($q->created_at->format('Y-m-d') . '12:00:00')) {
                            if ($q->created_at >= Carbon::parse($q->created_at->format('Y-m-d') . '08:31:00')) {
                                $data[$e->user_name]['late'] += Carbon::parse($q->created_at->format('Y-m-d') . '08:31:00')->diffInMinutes($q->created_at) + 30;
                                $data[$e->user_name]['late'] >= 60 ? $data[$e->user_name]['late'] /= 60 : $data[$e->user_name]['late'];
                            } else {
                                $data[$e->user_name]['late'] += 30;
                                $data[$e->user_name]['late'] >= 60 ? $data[$e->user_name]['late'] /= 60 : $data[$e->user_name]['late'];
                            }
                        }
                        if ($q->created_at >= Carbon::parse($q->created_at->format('Y-m-d') . '17:00:00')) {
                            $data[$e->user_name]['ot'] += Carbon::parse($q->created_at->format('Y-m-d') . '18:00:00')->diffInHours($q->updated_at);
                        }
                    }
                    $payslip = Payslip::where('user_name', $e->user_name)->where('week_id', $this->week)->first();
                    $data[$e->user_name]['hired'] = $e->created_at;
                    $data[$e->user_name]['user_name'] = $e->user_name;
                    $data[$e->user_name]['week_id'] = $this->weekId;
                    $data[$e->user_name]['month_id'] = $this->monthId;
                    $data[$e->user_name]['year_id'] = $this->yearId;
                    $data[$e->user_name]['pay_period'] = Carbon::parse($start)->format('F jS, Y') . ' - ' . Carbon::parse($end)->format('F jS, Y');
                    $data[$e->user_name]['name'] = $e->last_name . ', ' . $e->first_name . ' ' . $e->middle_name;
                    $data[$e->user_name]['job'] = $e->job;
                    $data[$e->user_name]['rate'] = 430;
                    $data[$e->user_name]['salary'] = $data[$e->user_name]['rate'] * $data[$e->user_name]['days'] - ($data[$e->user_name]['rate'] / 8 * $data[$e->user_name]['late']);
                    $data[$e->user_name]['rph'] = ($data[$e->user_name]['rate'] / 8) + ($data[$e->user_name]['rate'] / 8) * 0.2;
                    $data[$e->user_name]['otpay'] = $data[$e->user_name]['rph'] * $data[$e->user_name]['ot'];
                    $data[$e->user_name]['gross'] = $data[$e->user_name]['salary'] + $data[$e->user_name]['otpay'];
                    $data[$e->user_name]['net'] = $data[$e->user_name]['gross'];
                }
            }   
            Cache::forget('data'); // 10 years
            Cache::put('data', $data, 60 * 60 * 24 * 365 * 10); // 10 years
            return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }
}
