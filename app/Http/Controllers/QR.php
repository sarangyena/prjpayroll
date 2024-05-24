<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Image;
use App\Models\Payroll;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\QRLogin;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Stevebauman\Location\Facades\Location;

use stdClass;

use function PHPUnit\Framework\isEmpty;

class QR extends Controller
{
    private $current;
    private $firstDay;
    private $lastDay;
    private $week;
    private $weekId;
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
        $this->timezone = config('app.timezone');
    }
    public function index()
    {
        $qr = QRLogin::where('week_id', $this->weekId)->latest('updated_at')->paginate(5);
        return view('qr.index', [
            'qr' => $qr,
        ]);
    }
    public function view(): View
    {
        $qr = QRLogin::paginate(10);
        return view('qr.view', [
            'qr' => $qr,
        ]);
    }
    public function find(Request $request)
    {
        $data = $request->all();
        $userId = $data['id'];
        $employee = Employee::where('userName', $userId)->first();
        if (is_null($employee)) {
            return response()->json([
                'error' => 'true',
            ]);
        } else {
            return response()->json([
                'id' => $employee->id,
                'userName' => $employee->userName,
                'name' => $employee->name,
                'role' => $employee->role,
                'job' => $employee->job,
            ]);
        }
    }
    public function image(Request $request)
    {
        $data = $request->all();
        $userId = $data['id'];
        $image = Image::where('userName', $userId)->first();
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
    public function check(Request $request)
    {
        $data = $request->all();
        $loc = [];
        $loc['latitude'] = $data['latitude'];
        $loc['longitude'] = $data['longitude'];
        session()->put('loc', $loc);
        $userId = $data['id'];
        $qr = QRLogin::where('userName', $userId)->latest('updated_at')->first();
        if (is_null($qr)) {
            return response()->json([
                'check' => 'null',
            ]);
        } else {
            if ($qr->created_at->eq($qr->updated_at)) {
                return response()->json([
                    'check' => 'logout',
                ]);
            } else {
                return response()->json([
                    'check' => 'login',
                ]);
            }
        }
    }

    public function store(Request $request): RedirectResponse
    {
        $qr = Employee::where('userName', $request->userName)->first();
        $payroll = Payroll::where('userName', $request->userName)->first();
        $image = Image::findOrFail($qr->id);

        $created = Carbon::now();
        $late = Carbon::createFromTimeString('08:16:00');
        $diff = $late->diffInHours($created);
        $diff = number_format($diff, 2);


        $record = QRLogin::whereDate('created_at', $created)->count();
        if (is_null($qr)) {
            return redirect('qr')->with('danger', 'The user does not exist.');
        } else if ($record == 2) {
            return redirect('qr')->with('danger', 'Limited to only 2 login per day.');
        } else {
            $loc = session()->get('loc');
            try {
                //Create Employee
                $validated = $request->validate([
                    'userName' => 'nullable|string|uppercase|max:255',
                    'role' => 'nullable|string|uppercase|max:255',
                    'job' => 'nullable|string|uppercase|max:255',
                    'name' => 'nullable|string|uppercase|max:255',
                ]);
                $validated['timezone'] = $this->timezone;
                $validated['week_id'] = $this->weekId;
                $validated['ip'] = $request->ip();
                $validated['geo'] = $loc['longitude'] . ', ' . $loc['latitude'];
                $qr->qr()->create($validated);
                if ($diff > 0) {
                    $diff += 0.5;
                    $data = [];
                    $data['week'] = $this->week;
                    $data['week_id'] = $this->weekId;
                    $data['late'] = $payroll->late + $diff;
                    $payroll->update($data);
                }
                $validated['image_data'] = $image->image_data;
                session()->put('data', $validated);
                return redirect('qr')->with('success', 'Successfully login.');
            } catch (\Exception $e) {
                return redirect('qr')->with('danger', $e->getMessage());
            }
        }
    }
    public function update(Request $request): RedirectResponse
    {
        $qr = QRLogin::where('userName', $request->userName)->latest('updated_at')->first();
        $emp = Payroll::where('userName', $request->userName)->first();
        $date = new DateTime($qr->created_at);
        $date = $date->format('Y-m-d');
        try {
            $qr->week_id = $this->weekId;
            $qr->timestamps = false;
            $qr->timezone = $this->timezone;
            $qr->updated_at = now(); // or any other timestamp value
            $qr->save();

            $created = Carbon::parse($qr->created_at);
            $updated = Carbon::parse($date . ' 19:00:00');
            $hours = $created->diffInHours($updated);
            $hours = number_format($hours, 2);

            $timein = Carbon::parse($date . '08:00:00');
            $diff1 = $created->diffInHours($timein);
            $diff1 = number_format($diff1, 2);
            if ($diff1 > 0) {
                $hours = $hours - $diff1;
            }

            $ot = Carbon::parse($date . '18:00:00');
            $diff = $ot->diffInHours($updated);
            $diff = number_format($diff, 2);
            if ($diff < 0) {
                $diff = 0;
            }
            $payroll = [];
            $payroll['days'] = $hours / 8 + $emp->days;
            $payroll['salary'] = $emp->salary + ($emp->rate * $payroll['days'] + ($emp->rate / 8) * $emp->late);
            $payroll['hrs'] = $emp->hrs + $diff;
            $payroll['otpay'] = $emp->otpay + ($emp->rph * $payroll['hrs']);
            $payroll['gross'] = $payroll['salary'] + $payroll['otpay'] + $emp->holiday;
            $payroll['deduction'] = $emp->philhealth + $emp->sss + $emp->advance;
            $payroll['net'] = $payroll['gross'] - $payroll['deduction'];
            $emp->update($payroll);

            $emp1 = Employee::all();
            foreach ($emp1 as $data) {
                $user = QRLogin::where('userName', $data->userName)->latest('updated_at')->first();
                $time1 = Carbon::parse($user->updated_at);
                $time2 = Carbon::now();
                $diff = $time1->diffInDays($time2);
                if ($diff >= 30) {
                    $emp2 = Employee::where('userName', $data->userName)->first();
                    $update = [];
                    $update['eStatus'] = "INACTIVE";
                    $emp2->update($update);
                }
            }
            return redirect('qr')->with('success', 'Successfully logout.');
        } catch (\Exception $e) {
            return redirect('qr')->with('danger', $e->getMessage());
        }
    }
}
