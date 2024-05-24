<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Employee;
use App\Models\Image;
use App\Models\Log;
use App\Models\Payroll;
use App\Models\QRLogin;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;



class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     // Define a class property
    private $user;
    private $current;
    private $weekId;
    public function __construct()
    {
        $this->current = Carbon::now();
        $this->weekId = $this->current->week();
        //User
        $this->user = auth()->user();
    }
    public function index(): View
    {
        $dash = Payroll::where('userName', $this->user->userName)->get();
        $gross = 0;
        $deduction = 0;
        $net = 0;
        foreach($dash as $data) {
            $gross += $data->gross;
            $deduction += $data->deduction;
            $net += $data->net;
        }
        $qr = QRLogin::where('week_id', $this->weekId)->get();
        return view('employee.index',[
            'gross' => $gross,
            'deduction' => $deduction,
            'net' => $net,
            'qr' => $qr,
        ]);
    }
    public function salary(): View
    {
        $salary = Payroll::where('userName', $this->user->userName)->paginate(5);
        return view('employee.salary',[
            'payroll' => $salary,
        ]);
    }
    public function qr(): View
    {
        $qr = QRLogin::where('userName', $this->user->userName)->paginate(10);
        return view('employee.qr',[
            'qr' => $qr,
        ]);
    }
}
