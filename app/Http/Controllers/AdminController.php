<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use App\Models\Image;
use App\Models\Log;
use App\Models\Payroll;
use App\Models\User;
use App\Models\QRLogin;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
//QR Code
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Date;

class AdminController extends Controller
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
        $this->log = Log::where('user_id', $this->admin->id)
            ->whereDate('created_at', $this->current)
            ->get();
    }
    public function index(): View
    {
        $emp = Employee::all();
        foreach ($emp as $e) {
            $qr = QRLogin::where('userName', $e->userName)->latest()->first();
            $last = Carbon::parse($qr->updated_at);
            $diff = $last->diffInDays(Carbon::now());
            if ($diff >= 30) {
                $temp = [];
                $temp['eStatus'] = 'INACTIVE';
                $e->update($temp);
            }
        }
        $month = Payroll::where('month_id', $this->monthId)->get();
        $year = Payroll::where('year_id', $this->yearId)->get();
        $status = Employee::where('eStatus', "INACTIVE")->count();
        $netM = 0;
        $netY = 0;
        foreach ($month as $data) {
            $netM += $data->net;
        };
        foreach ($year as $data) {
            $netY += $data->net;
        };
        $count = Employee::count();
        return view('admin.index', [
            'week' => $this->weekId,
            'month' => $netM,
            'year' => $netY,
            'count' => $count,
            'status' => $status,
            'log' => $this->log,
        ]);
    }
    public function empIndex(): View
    {
        return view('admin.emp', [
            'log' => $this->log,
        ]);
    }

    public function empView(): View
    {
        $employee = Employee::paginate(5);
        return view('admin.view', [
            'employees' => $employee,
            'log' => $this->log,
        ]);
    }
    public function payView(Request $request): View
    {
        $week = $this->firstDay . ' - ' . $this->lastDay;
        $payroll = Payroll::where('week_id', $this->weekId)->get();
        if (count($payroll) >= 1) {
            foreach ($payroll as $pay) {
                $temp = [];
                $temp['week'] = $week;
                $pay->update($temp);
            }
        } else {
            if (Payroll::count() >= 1) {
                $weekId = Carbon::now()->subWeek()->startOfWeek()->week();
                $payroll = Payroll::where('week_id', $weekId)->get();
                foreach ($payroll as $pay) {
                    $temp = [];
                    $temp['pay_id'] = Functions::payId();
                    $temp['name'] = $pay->name;
                    $temp['userName'] = $pay->userName;
                    $temp['employee_id'] = $pay->employee_id;
                    $temp['week_id'] = $this->weekId;
                    $temp['month_id'] = $this->monthId;
                    $temp['year_id'] = $this->yearId;
                    $temp['week'] = $week;
                    $temp['job'] = $pay->job;
                    $temp['rate'] = $pay->rate;
                    $temp['rph'] = $pay->rate / 8 + ($pay->rate / 8) * 0.2;
                    $request->user()->payroll()->create($temp);
                }
            }
        }
        return view('admin.pay', [
            'payroll' => Payroll::where('week_id', $this->weekId)->paginate(8),
            'log' => $this->log,
        ]);
    }
    public function payEdit($id): View
    {
        $payroll = Payroll::find($id);
        Gate::authorize('update', $payroll);
        return view('admin.editPayroll', [
            'payroll' => $payroll,
        ]);
    }
    public function payUpdate(Request $request, $id): RedirectResponse
    {
        try {
            $payroll = Payroll::find($id);
            Gate::authorize('update', $payroll);
            $validated = $request->validate([
                'rate' => 'nullable|string|uppercase|max:255',
                'holiday' => 'nullable|string|uppercase|max:255',
                'sss' => 'nullable|string|uppercase|max:255',
                'philhealth' => 'nullable|string|uppercase|max:255',
                'advance' => 'nullable|string|uppercase|max:255',
            ]);
            $validated['gross'] = $request->holiday + $payroll->gross;
            $validated['deduction'] = $validated['philhealth'] + $validated['sss'] + $validated['advance'];
            $validated['net'] = $validated['gross'] - $validated['deduction'];
            $payroll->update($validated);
            $changes = $payroll->getChanges();
            unset($changes['updated_at']);
            $columns = [];
            foreach ($changes as $attribute => $values) {
                $columns[] = $attribute;
            }
            $sentence = Str::title(implode(', ', $columns));
            $log = [];
            $log['title'] = "EDIT PAYROLL";
            $log['log'] = "User " . $this->admin->userName . " edited " . $payroll->userName . " details. The columns edited are " . $sentence . ".";
            $request->user()->log()->create($log);
            return redirect(route('a-payroll'))->with('success', 'Successfully Updated Payroll.');
        } catch (\Exception $e) {
            return redirect(route('a-payroll'))->with('danger', $e->getMessage());
        }
    }


    public function store(Request $request): RedirectResponse
    {
        $week = $this->firstDay . ' - ' . $this->lastDay;
        try {
            //Create Employee
            $validated = $request->validate([
                'role' => 'nullable|string|uppercase|max:255',
                'userName' => 'nullable|string|uppercase|max:255',
                'first' => 'nullable|string|uppercase|max:255',
                'middle' => 'nullable|string|uppercase|max:255',
                'last' => 'nullable|string|uppercase|max:255',
                'status' => 'nullable|string|uppercase|max:255',
                'email' => 'nullable|string|uppercase|max:255',
                'phone' => 'nullable|string|uppercase|max:255',
                'job' => 'nullable|string|uppercase|max:255',
                'sss' => 'nullable|string|uppercase|max:255',
                'philhealth' => 'nullable|string|uppercase|max:255',
                'address' => 'nullable|string|uppercase|max:255',
                'eName' => 'nullable|string|uppercase|max:255',
                'ePhone' => 'nullable|string|uppercase|max:255',
                'eAdd' => 'nullable|string|uppercase|max:255',
            ]);
            $name = $request->last . ', ' . $request->first . ' ' . $request->middle;
            $validated['eStatus'] = "ACTIVE";
            $validated['name'] = $name;
            $validated['created_by'] = $this->admin->name;
            Employee::create($validated);
            $employee = Employee::latest()->first();

            //Get Image
            $userName = $request->userName;
            $fileName = $userName . '-' . time() . '.' . $request->image->extension();
            $imageData = file_get_contents($request->file('image')->getRealPath());

            //Get QR
            $writer = new PngWriter();
            $qrCode = QrCode::create($userName)
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
                ->setSize(300)
                ->setMargin(10)
                ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255));
            $result = $writer->write($qrCode);

            //Save File
            $result->saveToFile(public_path('images/' . $fileName));
            $qrData = file_get_contents(public_path('images/' . $fileName));
            $imagePath = 'images/' . $fileName;
            Storage::disk('public')->delete($imagePath);

            // Save Image And QR
            $image = [];
            $image['userName'] = $userName;
            $image['image_name'] = $fileName;
            $image['image_data'] = $imageData;
            $image['qr_data'] = $qrData;
            $employee->image()->create($image);

            //Create Payroll
            $payroll = [];
            $payroll['pay_id'] = Functions::payId();
            $payroll['name'] = $name;
            $payroll['userName'] = $userName;
            $payroll['employee_id'] = $employee->id;
            $payroll['week_id'] = $this->weekId;
            $payroll['month_id'] = $this->monthId;
            $payroll['year_id'] = $this->yearId;
            $payroll['week'] = $week;
            $payroll['job'] = $request->job;
            $payroll['rate'] = $request->rate;
            $payroll['rph'] = $request->rate / 8 + ($request->rate / 8) * 0.2;
            $request->user()->payroll()->create($payroll);

            $user = [];
            $user['employee_id'] = $employee->id;
            $user['name'] = $name;
            $user['userName'] = $userName;
            $user['userType'] = 'USER';
            $user['password'] = Hash::make($request->last);
            User::create($user);

            $log = [];
            $log['title'] = "ADD EMPLOYEE";
            $log['log'] = "User " . $this->admin->userName . " added " . $userName . ".";
            $request->user()->log()->create($log);
            return redirect('admin/employee')->with('success', 'Successfully added employee.');
        } catch (\Exception $e) {
            return redirect('admin/employee')->with('danger', $e->getMessage());
        }
    }

    public function edit($id): View
    {
        $employee = Employee::find($id);
        $payroll = Payroll::find($id);
        $image = Image::find($id);
        return view('admin.editEmp', [
            'employee' => $employee,
            'payroll' => $payroll,
            'image' => $image,
            'log' => $this->log,
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $employee = Employee::find($id);
            $payroll = Payroll::where('userName', $employee->userName)->first();
            $user = User::where('userName', $employee->userName)->first();
            $validated = $request->validate([
                'role' => 'nullable|string|uppercase|max:255',
                'userName' => 'nullable|string|uppercase|max:255',
                'first' => 'nullable|string|uppercase|max:255',
                'middle' => 'nullable|string|uppercase|max:255',
                'last' => 'nullable|string|uppercase|max:255',
                'status' => 'nullable|string|uppercase|max:255',
                'email' => 'nullable|string|uppercase|max:255',
                'phone' => 'nullable|string|uppercase|max:255',
                'job' => 'nullable|string|uppercase|max:255',
                'sss' => 'nullable|string|uppercase|max:255',
                'philhealth' => 'nullable|string|uppercase|max:255',
                'rate' => 'nullable|string|uppercase|max:255',
                'address' => 'nullable|string|uppercase|max:255',
                'eName' => 'nullable|string|uppercase|max:255',
                'ePhone' => 'nullable|string|uppercase|max:255',
                'eAdd' => 'nullable|string|uppercase|max:255',
            ]);
            if (isset($request->promote)) {
                $validated['role'] = 'EMPLOYEE';
            }
            $validated['name'] = $request->last . ', ' . $request->first . ' ' . $request->middle;
            $validated['edited_by'] = $this->admin->name;
            $employee->update($validated);
            $payroll->update($validated);
            $user->update($validated);
            if ($request->hasFile('image')) {
                $image = Image::where('employee_id', $employee->id)->first();
                $userName = $request->userName;
                $fileName = $userName . '-' . time() . '.' . $request->image->extension();
                $imageData = file_get_contents($request->file('image')->getRealPath());
                $temp = [];
                $temp['image_name'] = $fileName;
                $temp['image_data'] = $imageData;
                $image->update($temp);
            }
            $changes = $employee->getChanges();
            unset($changes['updated_at']);
            $columns = [];
            foreach ($changes as $attribute => $values) {
                $columns[] = $attribute;
            }
            $sentence = implode(', ', $columns);
            $log = [];
            $log['title'] = "EDIT EMPLOYEE";
            $log['log'] = "User " . $this->admin->userName . " edited " . $employee->userName . " details. The columns edited are " . $sentence . ".";
            $request->user()->log()->create($log);
            return redirect(route('a-view'))->with('success', 'Successfully Updated Employee.');
        } catch (\Exception $e) {
            dd($e);
            return redirect(route('a-view'))->with('danger', $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $employee = Employee::find($id);
            $employee->delete();
            $admin = User::find($this->admin->id);
            $log = [];
            $log['title'] = "DELETE EMPLOYEE";
            $log['log'] = "User " . $this->admin->userName . " deleted " . $employee->userName . ".";
            $admin->log()->create($log);
            return redirect(route('a-view'))->with('success', 'Successfully Deleted Employee.');;
        } catch (\Exception $e) {
            return redirect(route('a-view'))->with('danger', $e->getMessage());
        }
    }

    public function payrollAll()
    {
        return view('admin.pay', [
            'payroll' => Payroll::paginate(8),
            'log' => $this->log,
        ]);
    }
}
