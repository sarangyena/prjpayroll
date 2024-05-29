<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Image;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class FunctionController extends Controller
{
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
    public static function payId()
    {
        $count = Payroll::count() + 1;
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
            $data = $request->input('object');
            $data = json_decode($data, true);
            $data['image_data'] = Image::where('user_name', $data['user_name'])->first()->image_data;
            session([
                'danger' => $data['message'],
                'data1' => $data,
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
        if(count($payroll) >= 1){
            $net = 0;
            foreach($payroll as $p){
                $net += $p->net;
            }
            return $net;
        }else{
            return $net = 0;
        }
    }
    public function year(Request $request)
    {
        $year = (int)$request->year;
        $payroll = Payroll::where('year_id', $year)->get();
        if(count($payroll) >= 1){
            $net = 0;
            foreach($payroll as $p){
                $net += $p->net;
            }
            return $net;
        }else{
            return $net = 0;
        }
    }
}
