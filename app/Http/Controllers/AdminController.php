<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Image;
use App\Models\Log;
use App\Models\Payroll;
use App\Models\User;
use App\Models\Payslip;
use App\Models\QR;
use App\Models\Temp;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\File;





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
    public function addEmp(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|string|max:255',
            'user_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'email' => 'nullable|string|max:255',
            'phone' => 'nullable|numeric',
            'job' => 'required|string|max:255',
            'rate' => 'required|string|max:255',
            'sss' => 'nullable|string|max:255',
            'philhealth' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'eName' => 'nullable|string|max:255',
            'ePhone' => 'nullable|numeric',
            'eAdd' => 'nullable|string|max:255',
        ]);
        $validated['eStatus'] = "ACTIVE";
        $name = $request->last_name . ', ' . $request->first_name . ' ' . $request->middle_name;
        Employee::create($validated);
        $employee = Employee::latest()->first();
        //Get Image
        $user_name = $request->user_name;
        if($request->hasFile('image')){
            $fileName = $user_name . '-' . time() . '.' . $request->image->extension();
            $imageData = file_get_contents($request->file('image')->getRealPath());
        }else{
            $image = public_path('images/user1.png');
            $fileName = $user_name . '-' . time() . '.png';
            $imageData = File::get($image);
        }
        

        //Get QR
        $writer = new PngWriter();
        $qrCode = QrCode::create($user_name)
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

        //Create Payroll
        /*$payroll = [];
        $payroll['pay_id'] = FunctionController::payId();
        $payroll['name'] = $name;
        $payroll['user_name'] = $user_name;
        $payroll['week_id'] = $this->weekId;
        $payroll['month_id'] = $this->monthId;
        $payroll['year_id'] = $this->yearId;
        $payroll['job'] = $request->job;
        $payroll['rate'] = $request->rate;
        $payroll['rph'] = $request->rate / 8 + ($request->rate / 8) * 0.2;
        $employee->payroll()->create($payroll);*/

        // Save Image And QR
        $image = [];
        $image['user_name'] = $user_name;
        $image['image_name'] = $fileName;
        $image['image_data'] = $imageData;
        $image['qr_data'] = $qrData;
        $employee->image()->create($image);

        $user = [];
        $user['name'] = $name;
        $user['user_name'] = $user_name;
        $user['email'] = $employee->email;
        $user['password'] = Hash::make($employee->last_name);
        $employee->user()->create($user);

        $user = User::where('user_name', $this->admin->user_name)->first();
        $log = new Log();
        $log->title = 'CREATE RECORD';
        $log->log = 'Admin ' . auth()->user()->user_name . ' created ' . $employee->user_name;
        $log->user()->associate($user);
        $log->save();
        return redirect()->route('a-empView')->with('success', 'Successfully added employee.');
    }
    public function updateEmp(Request $request, $id)
    {
        try {
            $employee = Employee::find($id);
            $user = User::where('user_name', $employee->user_name)->first();
            $image = Image::where('user_name', $employee->user_name)->first();
            $payroll = Payroll::where('user_name', $employee->user_name)->first();
            $validated = $request->validate([
                'role' => 'nullable|string|max:255',
                'user_name' => 'nullable|string|max:255',
                'first_name' => 'nullable|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'status' => 'nullable|string|max:255',
                'email' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:255',
                'job' => 'nullable|string|max:255',
                'sss' => 'nullable|string|max:255',
                'philhealth' => 'nullable|string|max:255',
                'rate' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'eName' => 'nullable|string|max:255',
                'ePhone' => 'nullable|string|max:255',
                'eAdd' => 'nullable|string|max:255',
            ]);
            if (isset($request->promote)) {
                $validated['role'] = 'EMPLOYEE';
                //Get QR
                $writer = new PngWriter();
                $qrCode = QrCode::create($request->user_name)
                    ->setEncoding(new Encoding('UTF-8'))
                    ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
                    ->setSize(300)
                    ->setMargin(10)
                    ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
                    ->setForegroundColor(new Color(0, 0, 0))
                    ->setBackgroundColor(new Color(255, 255, 255));
                $result = $writer->write($qrCode);

                //Save File
                $fileName = $request->user_name . '-' . time() . '.png';
                $result->saveToFile(public_path('images/' . $fileName));
                $qrData = file_get_contents(public_path('images/' . $fileName));
                $imagePath = 'images/' . $fileName;
                Storage::disk('public')->delete($imagePath);
                $image->user_name = $request->user_name;
                $image->image_name = $fileName;
                $image->qr_data = $qrData;
                $image->save();
            }
            $validated['name'] = $request->last_name . ', ' . $request->first_name . ' ' . $request->middle_name;
            $payroll->user_name = $request->user_name;
            $payroll->name = $validated['name'];
            $payroll->job = $request->job;
            $payroll->save();
            $employee->update($validated);
            $user->update($validated);
            if ($request->hasFile('image')) {
                $image = Image::where('employee_id', $employee->id)->first();
                $user_name = $request->user_name;
                $fileName = $user_name . '-' . time() . '.' . $request->image->extension();
                $imageData = file_get_contents($request->file('image')->getRealPath());
                $temp = [];
                $temp['image_name'] = $fileName;
                $temp['image_data'] = $imageData;
                $image->update($temp);
            }

            $user = User::where('user_name', $this->admin->user_name)->first();
            $log = new Log();
            $log->title = 'UPDATE RECORD';
            $changes = $employee->getChanges();
            unset($changes['updated_at']);
            if (!empty($changes)) {
                $columns = [];
                foreach ($changes as $attribute => $values) {
                    $columns[] = $attribute;
                }
                $sentence = Str::title(implode(', ', $columns));
                $log->log = 'Admin ' . auth()->user()->user_name . ' updated ' . $employee->user_name . 'The columns edited are ' . $sentence . '.';
            } else {
                $log->log = 'Admin ' . auth()->user()->user_name . ' updated. ';
            }
            $log->user()->associate($user);
            $log->save();
            return redirect()->route('a-empView')->with('success', 'Successfully edited employee.');
        } catch (Exception $e) {
            return redirect()->route('a-editEmp')->with([
                'danger' => $e->getMessage(),
            ]);
        }
    }
    public function deleteEmp($id)
    {
        try {
            $employee = Employee::find($id);
            $temp = $employee->user_name;
            $employee->delete();
            $user = User::where('user_name', $this->admin->user_name)->first();
            $log = new Log();
            $log->title = 'DELETE RECORD';
            $log->log = 'Admin ' . auth()->user()->user_name . ' deleted ' . $temp;
            $log->user()->associate($user);
            $log->save();
            return redirect()->back()->with('success', 'Successfully Deleted Employee.');;
        } catch (Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }
    public function updatePay(Request $request, $id)
    {
        try {
            $temp = $request->all();
            if (empty($temp)) {
                return redirect()->route('a-editPay')->with('danger', 'No data to be updated.');
            }
            $data = [];
            foreach ($temp as $key => $value) {
                if ($key == '_token' || $key == '_method' || $value == null) {
                    continue;
                } else {
                    $data[$key] = $value;
                }
            }
            $payroll = Payslip::findOrFail($id);
            $payroll->update($data);
            $user = User::where('user_name', $this->admin->user_name)->first();
            $log = new Log();
            $log->title = 'UPDATE PAYROLL';
            $changes = $payroll->getChanges();
            unset($changes['updated_at']);
            $columns = [];
            foreach ($changes as $attribute => $values) {
                $columns[] = $attribute;
            }
            $sentence = Str::title(implode(', ', $columns));
            $log->log = 'Admin ' . auth()->user()->user_name . ' updated ' . $payroll->user_name . '. The columns edited are ' . $sentence . '.';
            $log->user()->associate($user);
            $log->save();
            return redirect()->route('a-payslip')->with('success', 'Successfully edited payroll.');
        } catch (Exception $e) {
            return redirect()->route('a-editPay')->with('danger', $e->getMessage());
        }
    }
    public function payslip($id)
    {
        $payroll = Payslip::findOrFail($id);
        $convert = FunctionController::convert_number_to_words($payroll->net);
        if ($convert == false) {
            $convert = "zero";
        }
        $pdf = Pdf::loadView('print.payslip', [
            'convert' => $convert,
            'payroll' => $payroll,
        ]);
        return $pdf->stream('INVOICE');
    }
    public function payroll()
    {
        $data = Cache::get('data');
        if($data == null){
            return redirect()->route('a-payroll')->with('danger', 'No data to be generated.');
        }
        $count = count($data);
        $inputFileType = 'Xlsx';
        $inputFileName = public_path('template.xlsx');
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet = $reader->load($inputFileName);
        $current = 5;
        foreach($data as $d){
            $date = $d['pay_period'];
            $spreadsheet->getActiveSheet()->insertNewRowBefore($current+1,1);
            $spreadsheet->getActiveSheet()->setCellValue('A2','Salaries and Wages For Period '.$d['pay_period']);
            $spreadsheet->getActiveSheet()
                ->setCellValue('A'.$current, $d['name'])
                ->setCellValue('B'.$current, $d['job'])
                ->setCellValue('C'.$current, $d['rate'])
                ->setCellValue('D'.$current, $d['days'])
                ->setCellValue('E'.$current, $d['late'])
                ->setCellValue('F'.$current, $d['salary'])
                ->setCellValue('G'.$current, $d['rph'])
                ->setCellValue('H'.$current, $d['ot'])
                ->setCellValue('I'.$current, $d['otpay'])
                ->setCellValue('J'.$current, $d['otpay'])
                ->setCellValue('K'.$current, $d['otpay'])
                ->setCellValue('L'.$current, $d['otpay'])
                ->setCellValue('M'.$current, $d['otpay'])
                ->setCellValue('N'.$current, $d['otpay'])
                ->setCellValue('O'.$current, $d['gross']);
            $current++;
            $spreadsheet->getActiveSheet()->setCellValue('F'.$current+1,'=SUM(F5:F'.($current).')');
            $spreadsheet->getActiveSheet()->setCellValue('G'.$current+1,'=SUM(G5:G'.($current).')');
            $spreadsheet->getActiveSheet()->setCellValue('H'.$current+1,'=SUM(H5:H'.($current).')');
            $spreadsheet->getActiveSheet()->setCellValue('I'.$current+1,'=SUM(I5:I'.($current).')');
            $spreadsheet->getActiveSheet()->setCellValue('J'.$current+1,'=SUM(J5:J'.($current).')');
            $spreadsheet->getActiveSheet()->setCellValue('K'.$current+1,'=SUM(K5:K'.($current).')');
            $spreadsheet->getActiveSheet()->setCellValue('L'.$current+1,'=SUM(L5:L'.($current).')');
            $spreadsheet->getActiveSheet()->setCellValue('M'.$current+1,'=SUM(M5:M'.($current).')');
            $spreadsheet->getActiveSheet()->setCellValue('N'.$current+1,'=SUM(N5:N'.($current).')');
            $spreadsheet->getActiveSheet()->setCellValue('O'.$current+1,'=SUM(O5:O'.($current).')');
        }
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$date.'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        /*$data = Cache::get('data');
        $salary = 0;
        $rph = 0;
        $hrs = 0;
        $ot = 0;
        $holiday = 0;
        $philhealth = 0;
        $sss = 0;
        $advance = 0;
        $gross = 0;
        $deduction = 0;
        $net = 0;
        foreach ($data as $key) {
            $salary += $key->salary;
            $rph += $key->rph;
            $hrs += $key->hrs;
            $ot += $key->otpay;
            $holiday += $key->holiday;
            $philhealth += $key->philhealth;
            $sss += $key->sss;
            $advance += $key->advance;
            $gross += $key->gross;
            $deduction += $key->deduction;
            $net += $key->net;
        }
        $total = new Employee();
        $total->salary = $salary;
        $total->rph = $rph;
        $total->hrs = $hrs;
        $total->otpay = $ot;
        $total->holiday = $holiday;
        $total->philhealth = $philhealth;
        $total->sss = $sss;
        $total->advance = $advance;
        $total->gross = $gross;
        $total->deduction = $deduction;
        $total->net = $net;

        $pdf = Pdf::setPaper('A4', 'landscape')->loadView('print.payroll', [
            'payroll' => $data,
            'total' => $total,
        ]);
        return $pdf->stream('INVOICE');*/
    }
}
