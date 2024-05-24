<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
//Print
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class PrintController extends Controller
{
    private $current;
    private $weekId;

    public function __construct()
    {
        //Dates
        $this->current = Carbon::today();
        $this->weekId = $this->current->week();
    }
    public function payslip($id)
    {
        $payroll = Payroll::findOrFail($id);
        $convert = Functions::convert_number_to_words($payroll->net);
        if($convert == false){
            $convert = "zero";
        }
        $pdf = Pdf::loadView('admin.payslip', [
            'convert' => $convert,
            'payroll' => $payroll,
        ]);
        return $pdf->stream('INVOICE');        
    }
    public function payroll($page)
    {
        $data = Payroll::where('week_id', $this->weekId)->get();
        $data = $data->slice(($page - 1) * 8, 8);
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
        foreach($data as $key){
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
        
        $pdf = Pdf::setPaper('A4','landscape')->loadView('admin.payroll',[
            'payroll' => $data,
            'total' => $total,
        ]);
        return $pdf->stream('INVOICE');     
    }
}
